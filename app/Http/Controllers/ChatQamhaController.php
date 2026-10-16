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
    - قاعدة صارمة لا تخالفها أبداً: لا تكتب حرفاً لاتينياً واحداً في جوابك (ولا في العناوين ولا في الإملاء)، ولا تستعمل الأرابيزي (1، 2، 3، 4، 5، 6، 7، 8، 9 بدل الحروف)، واكتب الأرقام بالكلمات العربية (مثال: مئة وستون كيلوغرام بدل 160).
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

    private const ERROR_REPLY = 'سامحني يا خويا، صارت تعطلة خفيفة في الكونكسيون. عاود اسألني توا!';

    private const QUOTA_REPLY = 'يا خويا، عدد الأسئلة في الوقت هذا بزّاف برشا. استنى شوية وعاود اسألني توّا.';

    /** Total wall-clock budget for the whole Gemini conversation, in seconds. */
    private const MAX_DURATION = 18;

    /**
     * Entry point. Nothing may escape this method as a 500: the chat widget only
     * knows how to render `reply`, so every failure must still return valid JSON
     * containing one — that is what makes the "قمحة يفكر…" bubble disappear.
     */
    public function chat(Request $request): JsonResponse
    {
        try {
            return $this->respond($request);
        } catch (\Throwable $e) {
            // Never log $e->getMessage(): it can embed the key-bearing request URI.
            Log::error('Qamha: unhandled '.get_class($e));

            return $this->gracefulFailure();
        }
    }

    private function respond(Request $request): JsonResponse
    {
        $start = microtime(true);

        try {
            $validated = $request->validate([
                'message' => 'nullable|string|max:4000',
                'messages' => 'nullable|array|max:40',
                'messages.*.role' => 'required_with:messages|string|in:user,assistant',
                'messages.*.content' => 'required_with:messages|string|max:4000',
            ]);
        } catch (\Throwable $e) {
            Log::warning('Qamha: invalid payload ('.$e::class.').');

            return $this->gracefulFailure();
        }

        $apiKey = trim((string) (config('services.gemini.key') ?: env('GEMINI_API_KEY')));

        if (! $this->isValidKey($apiKey)) {
            Log::warning('Qamha: GEMINI_API_KEY is missing or invalid.');

            return $this->gracefulFailure();
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
        $quotaHit = false;
        $deadline = self::MAX_DURATION;

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
                    $res = Http::withHeaders([
                        'Content-Type' => 'application/json',
                        // Key travels in a header, never in the query string, so it cannot
                        // leak through proxies, access logs or exception messages.
                        'x-goog-api-key' => $apiKey,
                    ])
                        ->connectTimeout(4)
                        ->timeout(8)
                        ->post($this->endpoint($model), ['contents' => $contents]);
                } catch (\Throwable $e) {
                    // Covers connection failures, DNS errors and the 8s timeout.
                    // Never log $e->getMessage(): it embeds the request URI and may leak secrets.
                    $lastError = get_class($e);
                    $res = null;
                    Log::error('Gemini transport error ['.$model.']: '.$lastError);

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
                Log::error('Gemini API error ['.$model.' / '.$status.']: '.$this->sanitize($lastBody));

                // Google tells us which model to use when the requested one is retired.
                if ($status === 404 && preg_match('/models\/(gemini-[A-Za-z0-9.\-]+)/', $lastBody, $suggested)
                    && ! in_array($suggested[1], $models, true)) {
                    $models[] = $suggested[1];
                }

                // Daily/minute quota exhausted → cool this model down and move to the next one.
                if ($status === 429) {
                    $quotaHit = true;
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
            Log::error('Gemini: all model candidates failed.'.($quotaHit ? ' (quota exhausted)' : '').' '.$this->sanitize($lastBody).' '.$lastError);

            return $this->gracefulFailure($quotaHit ? self::QUOTA_REPLY : self::ERROR_REPLY);
        }

        $replyText = $res->json('candidates.0.content.parts.0.text');

        if (blank($replyText)) {
            Log::error('Gemini: empty candidates. '.$this->sanitize($res->body()));

            return $this->gracefulFailure();
        }

        Cache::put(self::MODEL_CACHE_KEY, $model, now()->addHours(6));
        Cache::forget(self::COOL_PREFIX.$model);

        return response()->json(['reply' => trim($replyText)]);
    }

    /**
     * Never fail silently and never blow up with a 500: the chat widget only knows
     * how to render `reply`, and it must always receive one so the typing bubble stops.
     * The detail is logged server-side, never returned to the public caller.
     */
    private function gracefulFailure(string $reply = self::ERROR_REPLY): JsonResponse
    {
        return response()->json(['reply' => $reply]);
    }

    /**
     * Strip anything key-shaped (and cap the length) before an upstream payload reaches the log.
     */
    private function sanitize(string $body): string
    {
        $redacted = preg_replace('/AIza[A-Za-z0-9_\-]{5,}/', 'AIza***REDACTED***', $body) ?? $body;
        $redacted = preg_replace('/(key=|x-goog-api-key"?\s*:\s*")[^&"\s]+/i', '${1}***', $redacted) ?? $redacted;

        return Str::limit($redacted, 300);
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

    private function endpoint(string $model): string
    {
        return 'https://generativelanguage.googleapis.com/v1beta/models/'.$model.':generateContent';
    }

    /**
     * The key is resolved strictly from config/env — never by parsing .env at runtime.
     */
    private function isValidKey(string $key): bool
    {
        return $key !== '' && $key !== 'your_key_here' && preg_match('/^AIza[A-Za-z0-9_\-]{10,}$/', $key) === 1;
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
