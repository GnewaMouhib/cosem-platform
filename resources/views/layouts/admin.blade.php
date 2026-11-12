<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Administration') — COSEM</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    @stack('head')
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-100 text-ink font-sans antialiased min-h-screen"
      x-data="{ sidebarOpen: false }">

    @php
        $unreadCount = \App\Models\ContactsMessage::where('is_read', false)->count();
    @endphp

    <div class="flex min-h-screen">

        {{-- Sidebar overlay (mobile) --}}
        <div x-show="sidebarOpen" x-cloak x-transition.opacity
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-ink/40 z-40 lg:hidden"></div>

        {{-- Sidebar --}}
        <aside class="fixed lg:sticky top-0 z-50 h-screen w-72 bg-white border-r border-emerald-100 flex flex-col shrink-0
                      transition-transform duration-200 lg:translate-x-0"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <div class="px-5 py-5 border-b border-emerald-100 flex items-center gap-3">
                <img src="{{ asset('images/cosem-logo.png') }}" alt="Logo COSEM" height="48"
                     class="h-12 w-auto object-contain">
                <div class="leading-tight">
                    <p class="font-display text-lg font-bold text-ink">COSEM</p>
                    <p class="text-[11px] font-semibold uppercase tracking-wider text-forest-600">Administration</p>
                </div>
            </div>

            <div class="px-5 py-4 border-b border-emerald-100">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-full bg-forest-700 text-white flex items-center justify-center font-bold text-sm shrink-0">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 2)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-bold text-ink truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email ?? '' }}</p>
                    </div>
                </div>
                <div class="mt-3 inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-50 border border-emerald-200">
                    <span class="w-2 h-2 rounded-full bg-forest-600 animate-pulse"></span>
                    <span class="text-[11px] font-bold text-forest-700">
                        {{ $unreadCount }} message(s) non lu(s)
                    </span>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
                    @php
                    $adminLinks = [
                        ['route' => 'admin.dashboard', 'label' => 'Tableau de Bord', 'icon' => 'layout-dashboard'],
                        ['route' => 'admin.campagnes.index', 'label' => 'Campagnes & Chiffres', 'icon' => 'bar-chart-3'],
                        ['route' => 'admin.cereales.index', 'label' => 'Céréales', 'icon' => 'sprout'],
                        ['route' => 'admin.legumineuses.index', 'label' => 'Légumineuses', 'icon' => 'leaf'],
                        ['route' => 'admin.stations.index', 'label' => 'Stations & Dépôts', 'icon' => 'warehouse'],
                        ['route' => 'admin.maladies.index', 'label' => 'Guide Phytosanitaire', 'icon' => 'bug'],
                        ['route' => 'admin.messages.index', 'label' => 'Messages Reçus', 'icon' => 'inbox'],
                    ];
                @endphp
                @foreach($adminLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       @click="sidebarOpen = false"
                       @class([
                           'flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition',
                           'bg-forest-700 text-white shadow-soft' => request()->routeIs($link['route']),
                           'text-slate-600 hover:bg-emerald-50 hover:text-forest-700' => !request()->routeIs($link['route']),
                       ])>
                        <i data-lucide="{{ $link['icon'] }}" class="w-4 h-4 shrink-0"></i>
                        {{ $link['label'] }}
                        @if($link['route'] === 'admin.messages.index' && $unreadCount > 0)
                            <span class="ml-auto min-w-[22px] h-[22px] px-1.5 rounded-full bg-red-500 text-white text-[11px] font-bold flex items-center justify-center">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </a>
                @endforeach
            </nav>

            <div class="px-5 py-4 border-t border-emerald-100 space-y-2">
                <a href="{{ route('home') }}" target="_blank"
                   class="flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-forest-700 transition">
                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                    Voir le site public
                </a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-red-600 hover:text-red-700 hover:bg-red-50 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main column --}}
        <div class="flex-1 flex flex-col min-w-0">

            {{-- Topbar --}}
            <header class="sticky top-0 z-30 bg-white border-b border-emerald-100">
                <div class="flex items-center justify-between gap-4 px-4 sm:px-6 lg:px-8 h-16">
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-lg text-slate-600 hover:bg-emerald-50" aria-label="Menu">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>

                    <h1 class="font-display text-lg font-bold text-ink truncate">@yield('page-title', 'Tableau de Bord')</h1>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.messages.index') }}" class="relative p-2 rounded-lg text-slate-600 hover:bg-emerald-50 transition" title="Messages non lus">
                            <i data-lucide="bell" class="w-5 h-5"></i>
                            @if($unreadCount > 0)
                                <span class="absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] px-1 rounded-full bg-red-500 text-white text-[10px] font-bold flex items-center justify-center">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </a>

                        <a href="{{ route('home') }}" target="_blank"
                           class="hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-emerald-200 text-sm font-semibold text-forest-700 hover:bg-emerald-50 transition">
                            <i data-lucide="external-link" class="w-4 h-4"></i>
                            Voir le site public
                        </a>

                        {{-- User dropdown --}}
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" type="button" class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-slate-100 transition">
                                <span class="w-8 h-8 rounded-full bg-emerald-800 text-white font-bold flex items-center justify-center text-xs">{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 2)) }}</span>
                                <svg class="w-4 h-4 text-slate-500 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" @click.outside="open = false" x-cloak x-transition.origin.top.right class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 py-1.5 z-50">
                                <div class="px-4 py-2 border-b border-slate-100">
                                    <p class="text-xs font-semibold text-slate-800">Administrateur COSEM</p>
                                    <p class="text-xs text-slate-400 truncate">{{ Auth::user()->email ?? 'admin@cosem.tn' }}</p>
                                </div>
                                <form method="POST" action="{{ route('admin.logout') }}" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-xs font-medium text-red-600 hover:bg-red-50 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Flash messages --}}
            @if(session('success'))
                <div class="px-4 sm:px-6 lg:px-8 pt-6"
                     x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition.opacity>
                    <div class="flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-forest-700 shadow-soft">
                        <i data-lucide="check-circle-2" class="w-5 h-5 text-forest-600 shrink-0"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="px-4 sm:px-6 lg:px-8 pt-6"
                     x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition.opacity>
                    <div class="flex items-center gap-3 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-700 shadow-soft">
                        <i data-lucide="alert-circle" class="w-5 h-5 text-red-500 shrink-0"></i>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            {{-- Page content --}}
            <main class="flex-1 px-4 sm:px-6 lg:px-8 py-8">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Shared delete-confirmation modal --}}
    <div x-data="{ open: false, url: '', label: '' }"
         @confirm-delete.window="url = $event.detail.url; label = $event.detail.label; open = true"
         x-show="open" x-cloak x-transition.opacity class="fixed inset-0 z-[60] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-ink/50" @click="open = false"></div>
        <div x-show="open" x-transition.scale.95
             class="relative bg-white rounded-2xl border border-emerald-100 shadow-lift w-full max-w-md p-6">
            <div class="w-12 h-12 rounded-2xl bg-red-50 border border-red-100 flex items-center justify-center mb-4">
                <i data-lucide="trash-2" class="w-6 h-6 text-red-500"></i>
            </div>
            <h3 class="font-display text-lg font-bold text-ink mb-1">Confirmer la suppression</h3>
            <p class="text-sm text-slate-500 mb-6">
                Voulez-vous vraiment supprimer <span class="font-bold text-ink" x-text="label"></span> ?
                Cette action est irréversible.
            </p>
            <form method="POST" :action="url" class="flex justify-end gap-3">
                @csrf
                @method('DELETE')
                <button type="button" @click="open = false"
                        class="px-5 py-2.5 rounded-xl border border-emerald-200 text-sm font-semibold text-slate-600 hover:bg-emerald-50 transition">
                    Annuler
                </button>
                <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-red-600 text-white text-sm font-bold hover:bg-red-700 transition">
                    Supprimer
                </button>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/lucide@0.468.0/dist/umd/lucide.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
    </script>
    @stack('scripts')
</body>
</html>
