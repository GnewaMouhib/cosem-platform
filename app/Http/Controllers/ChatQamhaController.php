<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Sleep;
use Illuminate\Support\Str;

class ChatQamhaController extends Controller
{
    private const SYSTEM_INSTRUCTION = <<<'PROMPT'
    أنت قمحة، مستشار فلاحي قديم وخدام أرض تونسي تابع لشركة COSEM (الشركة التعاونية المركزية للبذور).
    - تحدث دائماً وأبداً باللهجة التونسية المفهومة، مكتوبة بحروف عربية فقط. إياك واستعمال الحروف اللاتينية أو الأرابيزي (مثل 7، 3، 9 بدل حروف) أو الكلمات الفرنسية.
    - إذا كتب الفلاح بالأرابيزي أو بالفرنسية أو باللاتيني، جاوبه بالعربي التونسي الواضح المكتوب بحروف عربية.
    - الاستثناء الوحيد: أسماء الشركات والمؤسسات التقنية (COSEM، INGC، INRAT 100) تبقى مكتوبة كما هي، والرقم العادي (160، 180) مقبول، أما حروف الأرابيزي فلا.
    - النبرة: ودّي ومحترم وقريب من الفلاحة، كخبير وحدّاد يعرف التراب التونسي مزيان، بغير مبالغة وبغير كلام تقني معقد.
    - احفظ معايير الـ INGC وأصناف كوزيم الـ 13 (قمح صلب: كريم، رزاق، سليم، معالي، خيار، INRAT 100، ذهبي. قمح لين: أوتيك، مктاريس، طاهنت. شعير: ريحان، كنوز. تريتيكال: الخير).
    - في مناطق المنوبة وجعيدة وتبرزة، انصح بالأصناف الممتازة كيما كريم ورزاق.
    - انصح بحرث الأرض، وبأوقات التبذير (من نص نوفمبر إلى ديسمبر)، وبلكميات (160-180 كغ/الهكتار حسب السقي أو البذر بالقطر)، وبمداواة الأمراض الورقية (السبتوريوز والصدأ البروندي والأصفر والأوديوم) في وقت النمو حسب العتبة والرطوبة.
    - شجّع دائماً على استعمال البذور الممتازة (المرشّحة) والمدواة ضد الأمراض (الأنثركنوز والكار).
    - اشرح كل شي ببساطة وبمثل الفلاح العادي يفهمها بلا تعقيد.
    PROMPT;

    private const MODEL = 'gemini-2.0-flash';

    private const MODEL_CACHE_KEY = 'qamha.gemini.model';

    private const COOL_PREFIX = 'qamha.gemini.cool.';

    private const ERROR_REPLY = 'سماحني يا خويا، أنا لواحد في هذا التو مع الاتصال. عاود اسألني شوية من بعد، هاني حاضر معاك.';

    private const MISSING_KEY_REPLY = 'مفتاح GEMINI_API_KEY ناقص في ملف .env متاع كوزيم. عاود اسألني شوية من بعد.';

    public function chat(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => 'nullable|string|max:4000',
            'messages' => 'nullable|array|max:40',
            'messages.*.role' => 'required_with:messages|string|in:user,assistant',
            'messages.*.content' => 'required_with:messages|string|max:4000',
        ]);

        $key = $this->resolveKey();

        if ($key === '') {
            return response()->json([
                'reply' => self::MISSING_KEY_REPLY,
                'warning' => 'GEMINI_API_KEY manque dans le fichier .env.',
            ], 503);
        }

        [$history, $question] = $this->buildConversation($validated);

        $contents = collect($history)
            ->map(fn (array $m) => [
                'role' => $m['role'] === 'assistant' ? 'model' : 'user',
                'parts' => [['text' => $m['content']]],
            ])
            ->push([
                'role' => 'user',
                'parts' => [
                    ['text' => "SYSTEM INSTRUCTION:\n".self::SYSTEM_INSTRUCTION."\n\nUSER QUESTION:\n".$question],
                ],
            ])
            ->values()
            ->all();

        $models = $this->modelCandidates();

        $res = null;
        $lastBody = '';
        $lastError = '';
        $start = microtime(true);
        $deadline = 45; // seconds: never make the visitor wait longer than this

        for ($i = 0; $i < count($models) && $i < 8; $i++) {
            if (microtime(true) - $start > $deadline) {
                break;
            }

            $model = $models[$i];

            for ($attempt = 1; $attempt <= 2; $attempt++) {
                if (microtime(true) - $start > $deadline) {
                    break 2;
                }

                try {
                    $res = Http::withHeaders(['Content-Type' => 'application/json'])
                        ->connectTimeout(5)
                        ->timeout(25)
                        ->post($this->endpoint($model, $key), ['contents' => $contents]);
                } catch (\Throwable $e) {
                    $lastError = $e->getMessage();
                    $res = null;
                    Log::error('Gemini API Error ['.$model.']: '.$lastError);

                    if ($attempt < 2) {
                        Sleep::for(1)->seconds();

                        continue;
                    }

                    break; // transport issue on this model → try the next one
                }

                if ($res->successful()) {
                    break 2;
                }

                $status = $res->status();
                $lastBody = $res->body();
                Log::error('Gemini API Error ['.$model.' / '.$status.']: '.$lastBody);

                // Google tells us which model to use when the requested one is retired.
                if ($status === 404 && preg_match('/models\/(gemini-[A-Za-z0-9.\-]+)/', $lastBody, $suggested)
                    && ! in_array($suggested[1], $models, true)) {
                    $models[] = $suggested[1];
                }

                // Daily/minute quota exhausted → cool this model down and move to the next one.
                if ($status === 429) {
                    $this->coolDown($model, $lastBody);

                    break;
                }

                // Transient pressure (500/503) → retry the same model once.
                if (! in_array($status, [500, 503], true)) {
                    break;
                }

                if ($attempt === 1) {
                    Sleep::for(1.5)->seconds();
                }
            }
        }

        if ($res === null || ! $res->successful()) {
            Log::error('Gemini API Error: all model candidates failed. '.$lastBody.$lastError);

            return response()->json([
                'reply' => self::ERROR_REPLY,
                'error' => Str::limit($lastBody !== '' ? $lastBody : $lastError, 300),
            ], 502);
        }

        $replyText = $res->json('candidates.0.content.parts.0.text');

        if (blank($replyText)) {
            Log::error($res->body());

            return response()->json([
                'reply' => self::ERROR_REPLY,
                'error' => 'Empty candidates in Gemini response.',
            ], 502);
        }

        Cache::put(self::MODEL_CACHE_KEY, $model, now()->addHours(6));
        Cache::forget(self::COOL_PREFIX.$model);

        return response()->json(['reply' => trim($replyText)]);
    }

    /**
     * Ordered model candidates: last known working model first (cached), then the
     * configured/primary one, stable aliases, and any model Google suggests.
     *
     * @return array<int, string>
     */
    private function modelCandidates(): array
    {
        $models = array_values(array_unique(array_filter([
            Cache::get(self::MODEL_CACHE_KEY),
            trim((string) (config('services.gemini.model') ?: self::MODEL)),
            self::MODEL,
            'gemini-flash-latest',
            'gemini-3.8-flash',
            'gemini-3.1-flash-lite',
            'gemini-flash-lite-latest',
            'gemini-3.5-flash-lite',
        ])));

        $available = array_values(array_filter(
            $models,
            fn (string $model) => ! Cache::has(self::COOL_PREFIX.$model)
        ));

        return $available !== [] ? $available : $models;
    }

    /**
     * Remember an exhausted quota for a while so we stop burning calls on it.
     */
    private function coolDown(string $model, string $body): void
    {
        $seconds = 3600;

        if (preg_match('/"retryDelay":\s*"(\d+)s"/', $body, $match)) {
            $seconds = max(60, (int) $match[1]);
        }

        $seconds = min($seconds, 8 * 3600);

        Cache::put(self::COOL_PREFIX.$model, true, now()->addSeconds($seconds));

        if (Cache::get(self::MODEL_CACHE_KEY) === $model) {
            Cache::forget(self::MODEL_CACHE_KEY);
        }

        Log::warning('Gemini model ['.$model.'] cooled down for '.round($seconds / 60).' min (quota exhausted).');
    }

    private function endpoint(string $model, string $key): string
    {
        return 'https://generativelanguage.googleapis.com/v1beta/models/'.$model.':generateContent?key='.rawurlencode($key);
    }

    /**
     * Resolve the Gemini key: config first, then env(), then the literal .env file
     * (a machine/user level GEMINI_API_KEY would otherwise shadow the .env value).
     */
    private function resolveKey(): string
    {
        $key = trim((string) (config('services.gemini.key') ?: env('GEMINI_API_KEY')));

        if ($this->isValidKey($key)) {
            return $key;
        }

        $key = $this->keyFromDotEnvFile();

        return $this->isValidKey($key) ? $key : '';
    }

    private function isValidKey(string $key): bool
    {
        return $key !== '' && $key !== 'your_key_here' && preg_match('/^AIza[A-Za-z0-9_\-]{10,}$/', $key) === 1;
    }

    private function keyFromDotEnvFile(): string
    {
        $path = base_path('.env');

        if (! is_file($path)) {
            return '';
        }

        foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            if (preg_match('/^\s*GEMINI_API_KEY\s*=\s*(.+?)\s*$/', $line, $m)) {
                return trim($m[1], " \t\"'");
            }
        }

        return '';
    }

    /**
     * @return array{0: array<int, array{role: string, content: string}>, 1: string}
     */
    private function buildConversation(array $validated): array
    {
        if (filled($validated['message'] ?? null)) {
            return [[], trim($validated['message'])];
        }

        $messages = collect($validated['messages'] ?? [])->values();

        if ($messages->isEmpty()) {
            return [[], '...'];
        }

        $last = $messages->pop();

        if (($last['role'] ?? 'user') !== 'user') {
            $messages->push($last);
            $last = ['role' => 'user', 'content' => '...'];
        }

        return [$messages->all(), trim($last['content'])];
    }
}
