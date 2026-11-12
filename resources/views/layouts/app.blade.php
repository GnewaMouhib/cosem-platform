<!DOCTYPE html>
<html lang="fr" x-data="{ mobileOpen: false }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'COSEM — Semences Certifiées en Tunisie')</title>
    <meta name="description" content="COSEM, coopérative des semences du Ministère de l'Agriculture, pionnier des semences certifiées en Tunisie depuis 1947.">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">

    {{-- Vite assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Leaflet CSS (after Vite so Leaflet styles are not overridden) --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    @stack('head')
</head>
<body class="min-h-screen flex flex-col">

    {{-- ==================== NAVBAR ==================== --}}
    <header class="fixed top-0 inset-x-0 z-50 bg-white/95 backdrop-blur border-b border-emerald-100 transition-shadow"
            x-data="{ scrolled: false }"
            x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 8)"
            :class="scrolled ? 'shadow-soft' : ''">
        <nav class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-[72px]">

                {{-- Brand: COSEM diamond logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 group shrink-0">
                    <img src="{{ asset('images/cosem-logo.png') }}" alt="Logo COSEM" height="48"
                         class="h-12 w-auto object-contain group-hover:scale-105 transition-transform">
                    <span class="leading-none">
                        <span class="block font-display text-xl font-bold text-ink">COSEM</span>
                        <span class="block text-[9px] font-bold uppercase tracking-[0.18em] text-forest-600 mt-0.5">Semences Certifiées</span>
                    </span>
                </a>

                {{-- Desktop links --}}
                <div class="hidden lg:flex items-center gap-1">
                    @php $navLinks = [
                        ['route' => 'home', 'label' => 'Accueil'],
                        ['route' => 'cereales.index', 'label' => 'Céréales'],
                        ['route' => 'legumineuses.index', 'label' => 'Légumineuses'],
                        ['route' => 'stations.index', 'label' => 'Stations & Dépôts'],
                        ['route' => 'maladies.index', 'label' => 'Guide Phytosanitaire'],
                        ['route' => 'contact.index', 'label' => 'Contact'],
                    ]; @endphp
                    @foreach($navLinks as $link)
                        <a href="{{ route($link['route']) }}"
                           @class([
                               'px-4 py-2 rounded-lg text-sm font-semibold transition',
                               'text-forest-700 bg-emerald-50' => request()->routeIs($link['route']),
                               'text-slate-600 hover:text-forest-700 hover:bg-emerald-50/70' => !request()->routeIs($link['route']),
                           ])>{{ $link['label'] }}</a>
                    @endforeach
                </div>

                {{-- Mobile toggle --}}
                <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2 rounded-lg text-slate-600 hover:bg-emerald-50" aria-label="Menu">
                    <span x-show="!mobileOpen"><i data-lucide="menu" class="w-6 h-6"></i></span>
                    <span x-show="mobileOpen" x-cloak><i data-lucide="x" class="w-6 h-6"></i></span>
                </button>
            </div>

            {{-- Mobile menu --}}
            <div x-show="mobileOpen" x-cloak x-transition.opacity.duration.200ms
                 class="lg:hidden pb-4 flex flex-col gap-1 border-t border-emerald-100 pt-3">
                @foreach($navLinks as $link)
                    <a href="{{ route($link['route']) }}" @click="mobileOpen=false"
                       @class([
                           'px-4 py-3 rounded-xl font-semibold text-sm',
                           'text-forest-700 bg-emerald-50' => request()->routeIs($link['route']),
                           'text-slate-600 hover:bg-emerald-50' => !request()->routeIs($link['route']),
                       ])>{{ $link['label'] }}</a>
                @endforeach
            </div>
        </nav>
    </header>

    {{-- Offset for fixed header --}}
    <div class="h-16 lg:h-[72px] shrink-0"></div>

    {{-- ==================== FLASH ALERTS ==================== --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             x-transition.opacity.duration.300ms
             class="fixed top-20 right-4 z-[60] max-w-md">
            <div class="bg-white rounded-2xl p-4 flex items-start gap-3 border border-emerald-200 shadow-lift">
                <div class="w-9 h-9 rounded-full bg-emerald-50 flex items-center justify-center shrink-0">
                    <i data-lucide="check-circle" class="w-5 h-5 text-forest-600"></i>
                </div>
                <div>
                    <p class="font-bold text-forest-700 text-sm">Succès</p>
                    <p class="text-sm text-slate-600">{{ session('success') }}</p>
                </div>
                <button @click="show=false" class="ml-auto text-slate-400 hover:text-slate-600"><i data-lucide="x" class="w-4 h-4"></i></button>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
             x-transition.opacity.duration.300ms
             class="fixed top-20 right-4 z-[60] max-w-md">
            <div class="bg-white rounded-2xl p-4 flex items-start gap-3 border border-red-200 shadow-lift">
                <div class="w-9 h-9 rounded-full bg-red-50 flex items-center justify-center shrink-0">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-red-500"></i>
                </div>
                <div>
                    <p class="font-bold text-red-600 text-sm">Erreur</p>
                    <p class="text-sm text-slate-600">{{ session('error') }}</p>
                </div>
                <button @click="show=false" class="ml-auto text-slate-400 hover:text-slate-600"><i data-lucide="x" class="w-4 h-4"></i></button>
            </div>
        </div>
    @endif

    {{-- ==================== MAIN ==================== --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- ==================== FOOTER ==================== --}}
    <footer class="relative bg-emerald-950 text-slate-300 overflow-hidden mt-auto border-t border-emerald-900">
        {{-- Top accent: harvest gold / emerald --}}
        <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-harvest-500 via-emerald-600 to-harvest-500"></div>

        <div class="mx-auto max-w-7xl px-6 py-14 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">

            {{-- Column 1: À Propos & Identité --}}
            <div>
                <div class="inline-flex items-center gap-3 mb-5 bg-white/95 rounded-2xl px-4 py-3 shadow-lg">
                    <img src="{{ asset('images/cosem-logo.png') }}" alt="Logo COSEM" height="48"
                         class="h-10 w-auto object-contain">
                    <div class="leading-tight">
                        <span class="block font-display text-lg font-bold text-ink">COSEM</span>
                        <span class="block text-[9px] font-bold uppercase tracking-[0.18em] text-forest-600">Depuis 1947</span>
                    </div>
                </div>
                <p class="text-sm leading-relaxed text-slate-400">
                    Pionnier national de la production et du conditionnement de semences certifiées de céréales
                    et légumineuses en Tunisie depuis 1947.
                </p>
                <span class="mt-5 inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-emerald-900 border border-emerald-700/60 text-emerald-300 text-[11px] font-bold uppercase tracking-wider">
                    <svg class="w-4 h-4 text-harvest-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Semences Certifiées sous contrôle officiel
                </span>
            </div>

            {{-- Column 2: Semences & Outils --}}
            <div>
                <h3 class="font-display text-base font-bold mb-5 text-white">Semences &amp; Outils</h3>
                <ul class="space-y-3 text-sm">
                    <li>
                        <a href="{{ route('cereales.index') }}" class="inline-flex items-center gap-2.5 text-slate-300 hover:text-emerald-400 transition">
                            <svg class="w-3.5 h-3.5 text-harvest-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                            Céréales d'élite <span class="text-slate-500">(Blé Dur, Blé Tendre, Orge)</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('legumineuses.index') }}" class="inline-flex items-center gap-2.5 text-slate-300 hover:text-emerald-400 transition">
                            <svg class="w-3.5 h-3.5 text-harvest-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                            Légumineuses alimentaires
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('maladies.index') }}" class="inline-flex items-center gap-2.5 text-slate-300 hover:text-emerald-400 transition">
                            <svg class="w-3.5 h-3.5 text-harvest-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            Guide de protection phytosanitaire
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Column 3: Réseau Territorial --}}
            <div>
                @php
                    // These three links must survive an admin creating or deleting a station,
                    // so the anchors are resolved by name instead of hardcoded ids. A failure
                    // here must never take the page down: the links degrade to the index.
                    $stationIds = rescue(
                        fn () => \Illuminate\Support\Facades\Cache::remember(
                            'layout.station_ids',
                            3600,
                            fn () => \App\Models\Station::query()->orderBy('id')->pluck('name', 'id')
                        ),
                        collect(),
                        false
                    );
                    $stationUrl = function (?string $needle) use ($stationIds) {
                        // first() hands the closure the value, unlike search() which hands it the key
                        $match = $stationIds->first(
                            fn ($name) => \Illuminate\Support\Str::contains(
                                \Illuminate\Support\Str::lower(\Illuminate\Support\Str::ascii((string) $name)),
                                \Illuminate\Support\Str::lower(\Illuminate\Support\Str::ascii($needle))
                            )
                        );

                        return route('stations.index').($match ? '#station-'.$stationIds->search($match) : '');
                    };
                @endphp
                <h3 class="font-display text-base font-bold mb-5 text-white">Réseau Territorial</h3>
                <ul class="space-y-3 text-sm">
                    <li>
                        <a href="{{ $stationUrl('manouba') }}" class="inline-flex items-center gap-2.5 text-slate-300 hover:text-emerald-400 transition">
                            <svg class="w-3.5 h-3.5 text-harvest-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-4h6v4"/></svg>
                            Station centrale de conditionnement <span class="text-slate-500">(Manouba)</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ $stationUrl('tebourba') }}" class="inline-flex items-center gap-2.5 text-slate-300 hover:text-emerald-400 transition">
                            <svg class="w-3.5 h-3.5 text-harvest-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-4h6v4"/></svg>
                            Station de triage et traitement <span class="text-slate-500">(Tébourba)</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ $stationUrl('el krib') }}" class="inline-flex items-center gap-2.5 text-slate-300 hover:text-emerald-400 transition">
                            <svg class="w-3.5 h-3.5 text-harvest-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-4h6v4"/></svg>
                            Dépôts de distribution régionaux
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('stations.index') }}" class="inline-flex items-center gap-2.5 text-slate-300 hover:text-emerald-400 transition">
                            <svg class="w-3.5 h-3.5 text-harvest-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Localisation interactive sur carte
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Column 4: Contact & Permanence --}}
            <div>
                <h3 class="font-display text-base font-bold mb-5 text-white">Contact &amp; Permanence</h3>
                <ul class="space-y-3.5 text-sm">
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 mt-0.5 text-harvest-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span><span class="block text-[10px] font-bold uppercase tracking-wider text-emerald-500 mb-0.5">Siège Social</span>
                        Avenue de la Liberté, Tunis</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 mt-0.5 text-harvest-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span><span class="block text-[10px] font-bold uppercase tracking-wider text-emerald-500 mb-0.5">Téléphone</span>
                        <a href="tel:+21671747000" class="text-slate-300 hover:text-emerald-400 transition">+216 71 747 000</a></span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 mt-0.5 text-harvest-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span><span class="block text-[10px] font-bold uppercase tracking-wider text-emerald-500 mb-0.5">Email officiel</span>
                        <a href="mailto:contact@cosem.tn" class="text-slate-300 hover:text-emerald-400 transition">contact@cosem.tn</a></span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 mt-0.5 text-harvest-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span><span class="block text-[10px] font-bold uppercase tracking-wider text-emerald-500 mb-0.5">Horaires</span>
                        Lun - Ven : 08h00 - 16h30</span>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Bottom copyright bar --}}
        <div class="mx-auto max-w-7xl px-6">
            <div class="border-t border-emerald-900/80 pt-6 mt-10 flex flex-col md:flex-row items-center justify-between gap-4 pb-2">
                <p class="text-xs text-slate-400">&copy; {{ date('Y') }} COSEM — Société Coopérative Centrale des Semences. Tous droits réservés.</p>
                <div class="flex flex-wrap justify-center gap-6 text-xs">
                    <a href="{{ route('mentions-legales') }}" class="text-slate-300 hover:text-emerald-400 transition">Mentions légales</a>
                    <a href="{{ route('politique-confidentialite') }}" class="text-slate-300 hover:text-emerald-400 transition">Politique de confidentialité</a>
                    <a href="{{ route('admin.login') }}" class="text-slate-300 hover:text-emerald-400 transition">Accès Administration</a>
                </div>
            </div>
        </div>
    </footer>

    {{-- ==================== SCRIPTS ==================== --}}
    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@0.468.0/dist/umd/lucide.min.js"></script>
    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) lucide.createIcons();
        });
    </script>
    @stack('scripts')
</body>
</html>
