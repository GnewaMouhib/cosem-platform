{{-- ==================== 9am7a (قمحة) — COSEM AI Agronomic Chatbot ==================== --}}
<div x-data="qamhaChat()" x-init="init()" class="print:hidden">

    {{-- Floating launcher --}}
    <div class="fixed bottom-6 right-6 z-50 flex flex-col items-end gap-3">

        {{-- Friendly badge --}}
        <div x-show="!open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-end="opacity-0 translate-y-2"
             x-cloak
             class="pointer-events-none -mr-1 rounded-full bg-white border border-harvest-200 px-3.5 py-1.5 text-[11px] font-bold text-harvest-700 shadow-lift">
            As2el 9am7a 🌾
        </div>

        <button type="button" @click="toggle()"
                class="group relative h-16 w-16 rounded-full bg-gradient-to-br from-emerald-500 via-forest-600 to-emerald-700 text-white shadow-lift ring-4 ring-emerald-100 hover:scale-105 active:scale-95 transition-transform focus:outline-none focus:ring-emerald-300"
                aria-label="As2el 9am7a">
            {{-- Soft pulse --}}
            <span class="absolute inset-0 -z-10 rounded-full bg-emerald-400/50 animate-ping"></span>
            <span x-show="!open" class="block text-3xl leading-none drop-shadow">🌾</span>
            <span x-show="open" x-cloak class="block text-3xl leading-none drop-shadow">✕</span>

            {{-- Online dot --}}
            <span class="absolute -top-0.5 -right-0.5 h-4 w-4 rounded-full bg-harvest-400 ring-2 ring-white"></span>
        </button>
    </div>

    {{-- Chat window --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200 origin-bottom-right"
         x-transition:enter-start="opacity-0 translate-y-6 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-150 origin-bottom-right"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-6 scale-95"
         x-cloak
         class="fixed bottom-28 right-4 sm:right-6 z-50 w-[calc(100vw-2rem)] sm:w-[390px] h-[min(72vh,600px)]
                flex flex-col rounded-3xl overflow-hidden bg-white border border-emerald-100 shadow-lift">

        {{-- Header --}}
        <div class="relative shrink-0 bg-gradient-to-r from-forest-800 via-emerald-700 to-forest-800 px-4 py-3.5 flex items-center gap-3">
            <div class="h-10 w-10 shrink-0 rounded-full bg-harvest-400/20 border border-harvest-400/50 flex items-center justify-center text-xl">🌾</div>
            <div class="min-w-0 leading-tight">
                <p class="text-white font-bold text-sm truncate">🌾 9am7a — Conseiller COSEM</p>
                <p class="flex items-center gap-1.5 text-[11px] text-emerald-200 mt-0.5">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-300 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400 ring-1 ring-emerald-200/50"></span>
                    </span>
                    متصل — نجاوبك في أي وقت
                </p>
            </div>
            <button type="button" @click="toggle()"
                    class="ml-auto shrink-0 h-8 w-8 rounded-full text-emerald-100 hover:bg-white/15 hover:text-white transition flex items-center justify-center"
                    aria-label="Sakker">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Messages --}}
        <div x-ref="scroll" class="flex-1 overflow-y-auto px-4 py-4 space-y-3 bg-emerald-50/40 scroll-smooth">
            <template x-for="(m, i) in messages" :key="i">
                <div class="flex" :class="m.role === 'user' ? 'justify-end' : 'justify-start'">
                    <div class="max-w-[85%] rounded-2xl px-3.5 py-2.5 text-[13.5px] leading-relaxed whitespace-pre-wrap break-words shadow-soft"
                         :class="m.role === 'user'
                            ? 'bg-forest-600 text-white rounded-br-md'
                            : 'bg-white text-slate-700 border border-emerald-100 rounded-bl-md'">
                        <span x-text="m.text"></span>
                    </div>
                </div>
            </template>

            {{-- Typing indicator --}}
            <div x-show="isLoading" x-cloak class="flex justify-start">
                <div class="rounded-2xl rounded-bl-md bg-white border border-emerald-100 px-4 py-3 shadow-soft flex items-center gap-1.5">
                    <span class="h-2 w-2 rounded-full bg-emerald-400 animate-bounce" style="animation-delay:0ms"></span>
                    <span class="h-2 w-2 rounded-full bg-harvest-500 animate-bounce" style="animation-delay:150ms"></span>
                    <span class="h-2 w-2 rounded-full bg-emerald-400 animate-bounce" style="animation-delay:300ms"></span>
                    <span class="ml-1.5 text-[11px] text-slate-400 font-medium">قمحة يفكر…</span>
                </div>
            </div>
        </div>

        {{-- Input --}}
        <form @submit.prevent="send()" class="shrink-0 border-t border-emerald-100 bg-white px-3 py-3 flex items-end gap-2">
            <input type="text"
                   x-model="input"
                   @keydown.enter.prevent="send()"
                   :disabled="isLoading"
                   placeholder="اكتب سؤالك هنا…"
                   class="flex-1 rounded-2xl border border-emerald-200 bg-emerald-50/50 px-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent disabled:opacity-60" />

            <button type="submit"
                    :disabled="isLoading || !input.trim()"
                    class="shrink-0 h-11 w-11 rounded-2xl bg-gradient-to-br from-emerald-500 to-forest-700 text-white flex items-center justify-center shadow-soft hover:scale-105 active:scale-95 transition-transform disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:scale-100"
                    aria-label="Sift">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
            </button>
        </form>

        <p class="shrink-0 bg-white text-center text-[10px] text-slate-400 pb-2 -mt-1">
            Ma3loumat agronomique selon les normes INGC &amp; COSEM 🌱
        </p>
    </div>
</div>

<script>
    function qamhaChat() {
        return {
            open: false,
            isLoading: false,
            input: '',
            messages: [
                {
                    role: 'assistant',
                    text: "عسلامة يا خويا وربي يعينك! أنا «قمحة» المستشار الفلاحي متاع COSEM، هاني بحذاك كان حاجتك بأي معلومة على الزريعة الممتازة، أوقات التبذير، ولا أناهي أحسن صنف يصلح بأرضك. تفضل اسألني!"
                }
            ],

            toggle() {
                this.open = !this.open;
                if (this.open) this.scrollToBottom();
            },

            scrollToBottom() {
                this.$nextTick(() => {
                    const el = this.$refs.scroll;
                    if (el) el.scrollTop = el.scrollHeight;
                });
            },

            async send() {
                const text = this.input.trim();
                if (!text || this.isLoading) return;

                this.messages.push({ role: 'user', text: text });
                this.input = '';
                this.isLoading = true;
                this.scrollToBottom();

                // Hard client-side stop: whatever happens below, the "قمحة يفكر…" bubble goes away.
                // 25s > the server's 18s budget, so a slow-but-valid answer is never cut off.
                const controller = new AbortController();
                const timer = setTimeout(() => controller.abort(), 25000);

                const FALLBACK = 'سامحني يا خويا، صارت تعطلة خفيفة في الكونكسيون. عاود اسألني توا!';

                try {
                    const res = await fetch('{{ url('/api/chat-qamha') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-CSRF': '{{ csrf_token() }}'
                        },
                        signal: controller.signal,
                        body: JSON.stringify({
                            messages: this.messages.slice(-12).map(m => ({
                                role: m.role,
                                content: m.text
                            }))
                        })
                    });

                    const data = await res.json().catch(() => ({}));

                    // 429 = our own throttle or an upstream Gemini quota; both are expected, not bugs.
                    const throttled = res.status === 429;

                    this.messages.push({
                        role: 'assistant',
                        text: data.reply
                            || (throttled
                                ? 'يا خويا، عدد الأسئلة في الوقت هذا بزّاف برشا. استنى شوية وعاود اسألني توّا.'
                                : FALLBACK)
                    });
                } catch (e) {
                    this.messages.push({
                        role: 'assistant',
                        text: e && e.name === 'AbortError'
                            ? 'واو، راه الرد يتأخر برشا. عاود اسألني توا ونديرلك جواب.'
                            : FALLBACK
                    });
                } finally {
                    // Guaranteed: no path can leave the typing bubble on screen.
                    clearTimeout(timer);
                    this.isLoading = false;
                    this.scrollToBottom();
                }
            }
        };
    }
</script>
