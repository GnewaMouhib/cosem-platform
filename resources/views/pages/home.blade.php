@extends('layouts.app')

@section('title', 'COSEM — Semences Certifiées en Tunisie depuis 1947')

@section('content')

    {{-- ==================== HERO : VIDEO + HIGHLIGHTS ==================== --}}
    <section class="page-header">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14 lg:py-20">
            <div class="grid lg:grid-cols-2 gap-10 lg:gap-14 items-center">

                {{-- Left: pitch --}}
                <div class="animate-fade-in-up">
                    <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-white border border-emerald-200 text-xs font-bold text-forest-700 shadow-soft mb-6">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute h-full w-full rounded-full bg-harvest-400 opacity-75"></span>
                            <span class="relative rounded-full h-2 w-2 bg-harvest-400"></span>
                        </span>
                        Pionnier des Semences en Tunisie depuis 1947
                    </div>

                    <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-bold text-ink leading-[1.05] tracking-tight mb-6">
                        Semences <span class="text-gradient">Certifiées</span>,<br>
                        Récoltes d'Exception
                    </h1>

                    <p class="text-lg text-slate-500 leading-relaxed mb-8 max-w-xl">
                        La Coopérative des Semences du Ministère de l'Agriculture produit et distribue
                        des semences certifiées de blé dur, blé tendre, orge et légumineuses à travers
                        un réseau national de stations de conditionnement, au service des agriculteurs tunisiens depuis 1947.
                    </p>

                    <div class="flex flex-wrap gap-4 mb-10">
                        <a href="{{ route('cereales.index') }}" class="btn-primary">
                            <i data-lucide="sprout" class="w-4 h-4"></i>
                            Explorer nos Semences
                        </a>
                        <a href="{{ route('stations.index') }}" class="btn-outline">
                            <i data-lucide="map-pin" class="w-4 h-4"></i>
                            Localiser nos Stations
                        </a>
                    </div>

                    {{-- Cooperative highlights --}}
                    <div class="grid grid-cols-3 gap-4 max-w-lg">
                        <div class="card p-4 text-center">
                            <div class="font-display text-2xl font-bold text-forest-700" data-counter="78">0</div>
                            <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mt-1">Ans d'expertise</div>
                        </div>
                        <div class="card p-4 text-center">
                            <div class="font-display text-2xl font-bold text-forest-700"><span data-counter="1947">0</span></div>
                            <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mt-1">Année de fondation</div>
                        </div>
                        <div class="card p-4 text-center">
                            <div class="font-display text-2xl font-bold text-forest-700"><span data-counter="{{ (int) ($stats->total_multipliers ?? 100) }}">0</span></div>
                            <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mt-1">Multiplicateurs</div>
                        </div>
                    </div>
                </div>

                {{-- Right: Facebook video in framed card --}}
                <div class="animate-fade-in-up" style="animation-delay: .15s">
                    <div class="card p-3 sm:p-4 shadow-lift">
                        <div class="flex items-center gap-3 px-2 py-2.5 mb-3">
                            <img src="{{ asset('images/cosem-logo.png') }}"
                                 alt="COSEM Logo"
                                 class="w-8 h-8 rounded-lg object-contain bg-white shadow-sm p-0.5">
                            <div class="leading-tight">
                                <p class="text-sm font-bold text-ink">COSEM — Coopérative des Semences</p>
                                <p class="text-[11px] text-slate-400">Vidéo officielle · Réseau de semences certifiées</p>
                            </div>
                            <span class="ml-auto badge bg-emerald-50 text-forest-700 border border-emerald-100">Officiel</span>
                        </div>
                        <div class="relative rounded-xl overflow-hidden border border-emerald-100 bg-slate-900 aspect-video">
                            <iframe
                                src="https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Fwatch%2F%3Fv%3D674608733989339&show_text=false&width=800"
                                width="100%" height="100%" style="border:none;overflow:hidden"
                                scrolling="no" frameborder="0" allowfullscreen="true"
                                allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                                class="absolute inset-0 w-full h-full"
                                title="Vidéo officielle COSEM">
                            </iframe>
                        </div>
                        <div class="flex items-center justify-between px-2 pt-3">
                            <div class="flex gap-4 text-slate-400">
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold"><i data-lucide="play-circle" class="w-4 h-4 text-forest-600"></i> Lecture directe</span>
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold"><i data-lucide="calendar" class="w-4 h-4"></i> Campagne en cours</span>
                            </div>
                            <a href="https://www.facebook.com/watch/?v=674608733989339" target="_blank" rel="noopener" class="text-xs font-bold text-forest-600 hover:text-forest-700 inline-flex items-center gap-1">
                                Sur Facebook <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ==================== COOPERATIVE PRESENTATION + KEY FIGURES ==================== --}}
    <section class="py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-start">
                {{-- Presentation --}}
                <div class="animate-fade-in-up">
                    <div class="section-eyebrow">
                        <i data-lucide="landmark" class="w-4 h-4"></i>
                        La Coopérative
                    </div>
                    <h2 class="section-title mb-5">Un héritage agricole <span class="text-gradient">depuis 1947</span></h2>
                    <div class="space-y-4 text-slate-500 leading-relaxed">
                        <p>
                            Fondée en 1947, la COSEM est la coopérative des semences du Ministère de l'Agriculture tunisien.
                            Depuis plus de sept décennies, elle assure la sélection, la multiplication et le conditionnement
                            de semences certifiées de céréales pour l'ensemble du territoire national.
                        </p>
                        <p>
                            Répartie sur un réseau de stations de conditionnement et d'entrepôts, la coopérative accompagne
                            les agriculteurs de la parcelle à la récolte : conseil technique, fourniture de semences à haut
                            potentiel génétique et suivi phytosanitaire.
                        </p>
                    </div>

                    <div class="grid sm:grid-cols-3 gap-4 mt-8">
                        <div class="card p-4">
                            <i data-lucide="badge-check" class="w-5 h-5 text-forest-600 mb-2"></i>
                            <p class="text-sm font-bold text-ink">Certification officielle</p>
                            <p class="text-xs text-slate-400 mt-1">Semences contrôlées selon les normes nationales.</p>
                        </div>
                        <div class="card p-4">
                            <i data-lucide="network" class="w-5 h-5 text-forest-600 mb-2"></i>
                            <p class="text-sm font-bold text-ink">Réseau national</p>
                            <p class="text-xs text-slate-400 mt-1">Stations et dépôts couvrant les principales zones céréalières.</p>
                        </div>
                        <div class="card p-4">
                            <i data-lucide="microscope" class="w-5 h-5 text-forest-600 mb-2"></i>
                            <p class="text-sm font-bold text-ink">Recherche & sélection</p>
                            <p class="text-xs text-slate-400 mt-1">Variétés adaptées aux conditions agro-climatiques tunisiennes.</p>
                        </div>
                    </div>
                </div>

                {{-- Key figures --}}
                <div class="animate-fade-in-up" style="animation-delay: .1s">
                    <div class="card p-6 sm:p-8"
                         x-data="campaignSwitcher({{ json_encode($campaigns) }}, {{ $activeYear?->id ?? 0 }})">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <div class="section-eyebrow !mb-1">
                                    <i data-lucide="bar-chart-3" class="w-4 h-4"></i>
                                    Campagne <span id="cf-name">{{ $activeYear->name ?? '2025/2026' }}</span>
                                </div>
                                <h3 class="font-display text-xl font-bold text-ink">Chiffres Clés de la Récolte</h3>
                            </div>
                            <span class="badge bg-emerald-50 text-forest-700 border border-emerald-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-forest-600 animate-pulse"></span>
                                <span id="cf-status">{{ $activeYear?->is_active ? 'Live' : 'Archive' }}</span>
                            </span>
                        </div>

                        {{-- Campaign selector --}}
                        @if($years->count() > 1)
                            <div class="flex flex-wrap gap-2 mb-6" role="tablist" aria-label="Sélection de la campagne">
                                @foreach($years as $y)
                                    <button type="button" role="tab"
                                            @click="select({{ $y->id }})"
                                            :aria-selected="current === {{ $y->id }} ? 'true' : 'false'"
                                            class="px-3.5 py-1.5 rounded-full text-xs font-bold transition border cursor-pointer"
                                            :class="current === {{ $y->id }}
                                                ? 'bg-forest-700 text-white border-forest-700'
                                                : 'bg-white text-slate-500 border-emerald-200 hover:border-forest-600 hover:text-forest-700'">
                                        {{ $y->name }}
                                    </button>
                                @endforeach
                            </div>
                        @endif

                        @php
                            $cTotal = (float) (($stats?->durum_wheat_qx ?? 215000) + ($stats?->soft_wheat_qx ?? 8000) + ($stats?->barley_qx ?? 7000) + ($stats?->oats_qx ?? 3000));
                            $pTotal = (float) (($stats?->feves_qx ?? 850) + ($stats?->pois_chiches_qx ?? 650) + ($stats?->feveroles_qx ?? 350) + ($stats?->lentilles_qx ?? 150));
                            if ($pTotal <= 0 && ($stats?->pulses_qx ?? 0) > 0) $pTotal = (float) $stats->pulses_qx;
                        @endphp
                        {{-- Compteurs supérieurs dynamiques --}}
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-6">
                            <div class="rounded-2xl bg-emerald-50 border border-emerald-100 p-4">
                                <div class="flex items-center gap-1.5 mb-1 text-forest-700">
                                    <i data-lucide="wheat" class="w-4 h-4"></i>
                                    <span class="text-[10px] font-bold uppercase tracking-wider">Total Céréales</span>
                                </div>
                                <div class="font-display text-2xl font-bold text-ink"><span id="cf-cereals-total" data-counter="{{ (int) round($cTotal / 1000) }}">0</span>k <span class="text-xs font-sans text-slate-400 font-semibold">QX</span></div>
                                <div class="text-[11px] text-slate-500 mt-0.5">Collecte totale</div>
                            </div>
                            <div class="rounded-2xl bg-amber-50 border border-amber-100 p-4">
                                <div class="flex items-center gap-1.5 mb-1 text-harvest-700">
                                    <i data-lucide="leaf" class="w-4 h-4"></i>
                                    <span class="text-[10px] font-bold uppercase tracking-wider">Total Légumes</span>
                                </div>
                                <div class="font-display text-2xl font-bold text-ink"><span id="cf-pulses-total" data-counter="{{ (int) round($pTotal) }}">0</span> <span class="text-xs font-sans text-slate-400 font-semibold">QX</span></div>
                                <div class="text-[11px] text-slate-500 mt-0.5">Production certifiée</div>
                            </div>
                            <div class="rounded-2xl bg-sky-50 border border-sky-100 p-4 col-span-2 sm:col-span-1">
                                <div class="flex items-center gap-1.5 mb-1 text-sky-700">
                                    <i data-lucide="maximize-2" class="w-4 h-4"></i>
                                    <span class="text-[10px] font-bold uppercase tracking-wider">Superficie</span>
                                </div>
                                <div class="font-display text-2xl font-bold text-ink"><span id="cf-superficie" data-counter="{{ (int) round(($stats?->total_hectares ?? 11000) / 1000) }}">0</span>k <span class="text-xs font-sans text-slate-400 font-semibold">Ha</span></div>
                                <div class="text-[11px] text-slate-500 mt-0.5">Taux certif. : <strong id="cf-cert" class="text-forest-700">{{ rtrim(rtrim(number_format((float) ($stats?->certified_seed_pct ?? 85), 1, ',', ' '), '0'), ',') }}%</strong></div>
                            </div>
                        </div>

                        {{-- Deux Donuts distincts : Céréales & Légumineuses --}}
                        <div class="grid md:grid-cols-2 gap-5 mb-2">
                            {{-- Donut 1 : Céréales --}}
                            <div class="bg-slate-50/70 rounded-2xl p-4 border border-emerald-100 flex flex-col">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="text-xs font-bold uppercase tracking-wider text-forest-800 flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-forest-600"></span> Répartition Céréales
                                    </h4>
                                    <span class="text-[10px] font-extrabold text-forest-700 px-2 py-0.5 rounded-full bg-emerald-100/70" id="cf-durum-badge">{{ (int) round(($stats?->durum_wheat_qx ?? 215000) / 1000) }}k QX Blé Dur</span>
                                </div>
                                <div class="relative h-[200px] w-full">
                                    <canvas id="cerealsDonutChart"></canvas>
                                </div>
                                <div class="grid grid-cols-2 gap-1.5 mt-3 pt-2.5 border-t border-slate-200/60 text-[11px] text-slate-500">
                                    <div>Blé Tendre : <strong id="cf-soft" class="text-ink font-bold">{{ number_format($stats?->soft_wheat_qx ?? 8000, 0, ',', ' ') }}</strong> QX</div>
                                    <div>Orge : <strong id="cf-barley" class="text-ink font-bold">{{ number_format($stats?->barley_qx ?? 7000, 0, ',', ' ') }}</strong> QX</div>
                                </div>
                            </div>

                            {{-- Donut 2 : Légumineuses --}}
                            <div class="bg-slate-50/70 rounded-2xl p-4 border border-amber-100 flex flex-col">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="text-xs font-bold uppercase tracking-wider text-harvest-800 flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-amber-500"></span> Répartition Légumineuses
                                    </h4>
                                    <span class="text-[10px] font-extrabold text-harvest-800 px-2 py-0.5 rounded-full bg-amber-100/70" id="cf-pulses-badge">{{ number_format($pTotal, 0, ',', ' ') }} QX Total</span>
                                </div>
                                <div class="relative h-[200px] w-full">
                                    <canvas id="pulsesDonutChart"></canvas>
                                </div>
                                <div class="grid grid-cols-2 gap-1.5 mt-3 pt-2.5 border-t border-slate-200/60 text-[11px] text-slate-500">
                                    <div>Fèves : <strong id="cf-feves" class="text-ink font-bold">{{ number_format($stats?->feves_qx ?? 850, 0, ',', ' ') }}</strong> QX</div>
                                    <div>Pois chiches : <strong id="cf-chickpeas" class="text-ink font-bold">{{ number_format($stats?->pois_chiches_qx ?? 650, 0, ',', ' ') }}</strong> QX</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ==================== STATION TEASERS ==================== --}}
    <section class="py-16 lg:py-20 bg-slate-50 border-y border-emerald-100">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
                <div>
                    <div class="section-eyebrow">
                        <i data-lucide="factory" class="w-4 h-4"></i>
                        Réseau National
                    </div>
                    <h2 class="section-title">Nos <span class="text-gradient">Stations</span> &amp; Dépôts</h2>
                </div>
                <a href="{{ route('stations.index') }}" class="btn-outline self-start">
                    Voir toutes les stations <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $stationFallbacks = [
                        'Siège & Complexe Industriel Principal - Manouba' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=800&q=80',
                        'Plateforme de Stockage Stratégique - Manouba' => 'https://images.unsplash.com/photo-1553413077-190dd305871c?auto=format&fit=crop&w=800&q=80',
                        "Laboratoire Central d'Analyses & Qualité - Manouba" => 'https://images.unsplash.com/photo-1595246140625-573b715d11dc?auto=format&fit=crop&w=800&q=80',
                        'Station de Conditionnement Tébourba 1' => 'https://images.unsplash.com/photo-1595246140625-573b715d11dc?auto=format&fit=crop&w=800&q=80',
                        'Station Spécialisée Tébourba 2 (Pôle Légumineuses)' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=800&q=80',
                        'Centre de Stockage Régional - El Krib' => 'https://images.unsplash.com/photo-1553413077-190dd305871c?auto=format&fit=crop&w=800&q=80',
                    ];
                    $stationDefaultImage = 'https://images.unsplash.com/photo-1553413077-190dd305871c?auto=format&fit=crop&w=800&q=80';
                @endphp
                @foreach($stations as $station)
                    @php
                        $fallbackUrl = $stationFallbacks[$station->name] ?? $stationDefaultImage;
                    @endphp
                    <a href="{{ route('stations.index') }}#station-{{ $station->id }}" class="card card-hover overflow-hidden group">
                        <div class="relative h-48 w-full overflow-hidden rounded-t-2xl">
                            <img src="{{ $station->image_path ? asset($station->image_path) : $fallbackUrl }}"
                                 alt="{{ $station->name }}"
                                 loading="lazy"
                                 class="w-full h-full object-cover transition-transform duration-300 hover:scale-105"
                                 onerror="this.onerror=null;this.src='{{ $fallbackUrl }}';">
                            @if($station->installation_year)
                                <span class="absolute top-3 right-3 badge bg-white/95 text-forest-700">Depuis {{ $station->installation_year }}</span>
                            @endif
                        </div>
                        <div class="p-5">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-forest-600">
                                {{ $station->type === 'warehouse' ? 'Entrepôt' : ($station->type === 'multiplication_zone' ? 'Zone de multiplication' : 'Station de conditionnement') }}
                            </span>
                            <h3 class="font-display text-lg font-bold text-ink mt-1">{{ $station->name }}</h3>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $station->city }}, {{ $station->governorate }}</p>
                            <div class="flex gap-3 mt-3 text-xs font-semibold text-slate-500">
                                @if($station->capacity)<span class="inline-flex items-center gap-1"><i data-lucide="package" class="w-3.5 h-3.5 text-harvest-500"></i>{{ number_format($station->capacity) }} QX</span>@endif
                                @if($station->surface)<span class="inline-flex items-center gap-1"><i data-lucide="square" class="w-3.5 h-3.5 text-harvest-500"></i>{{ number_format($station->surface) }} m²</span>@endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ==================== VARIETIES TEASER ==================== --}}
    <section class="py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <div class="section-eyebrow justify-center">
                    <i data-lucide="wheat" class="w-4 h-4"></i>
                    Catalogue
                </div>
                <h2 class="section-title">Nos <span class="text-gradient">Variétés</span> de Semences</h2>
                <p class="mt-3 text-slate-500 max-w-2xl mx-auto">Variétés sélectionnées et certifiées, adaptées aux différentes zones agro-climatiques tunisiennes.</p>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-10">
                @php $cats = ['ble_dur' => 'Blé Dur', 'ble_tendre' => 'Blé Tendre', 'orge' => 'Orge', 'triticale' => 'Triticale']; @endphp
                @foreach($cats as $key => $label)
                    <a href="{{ route('cereales.index') }}#{{ $key }}" class="card card-hover p-5 text-center">
                        <div class="w-11 h-11 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center mx-auto mb-3">
                            <i data-lucide="wheat" class="w-5 h-5 text-forest-600"></i>
                        </div>
                        <p class="font-bold text-ink text-sm">{{ $label }}</p>
                        <p class="font-display text-2xl font-bold text-harvest-500 mt-1">{{ $varietyCounts[$key] ?? 0 }}</p>
                        <p class="text-[10px] font-bold uppercase text-slate-400">variétés</p>
                    </a>
                @endforeach
            </div>

            <div class="text-center">
                <a href="{{ route('cereales.index') }}" class="btn-primary">
                    Découvrir le catalogue complet <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
    /* ---------- Campaign switcher (Alpine) : swaps key figures + donuts without reload ---------- */
    function campaignSwitcher(campaigns, currentId) {
        return {
            campaigns: campaigns || [],
            current: currentId,
            get active() {
                return this.campaigns.find(c => c.id === this.current) || this.campaigns[0] || null;
            },
            select(id) {
                this.current = id;
                const c = this.active;
                if (!c) return;

                const nameEl = document.getElementById('cf-name');
                if (nameEl) nameEl.textContent = c.name;

                const statusEl = document.getElementById('cf-status');
                if (statusEl) statusEl.textContent = c.is_active ? 'Live' : 'Archive';

                const setCounter = (elId, value) => {
                    const el = document.getElementById(elId);
                    if (!el) return;
                    el.dataset.counter = String(value);
                    if (window.__animateCounter) window.__animateCounter(el);
                    else el.textContent = Number(value).toLocaleString('fr-FR');
                };

                setCounter('cf-cereals-total', c.cereals_k);
                setCounter('cf-pulses-total', c.pulses_total);
                setCounter('cf-superficie', c.hectares_k);

                const certEl = document.getElementById('cf-cert');
                if (certEl) certEl.textContent = c.cert_pct + '%';

                const durumBadge = document.getElementById('cf-durum-badge');
                if (durumBadge) durumBadge.textContent = Math.round(c.durum / 1000) + 'k QX Blé Dur';

                const pulsesBadge = document.getElementById('cf-pulses-badge');
                if (pulsesBadge) pulsesBadge.textContent = Number(c.pulses_total).toLocaleString('fr-FR') + ' QX Total';

                const softEl = document.getElementById('cf-soft');
                if (softEl) softEl.textContent = Number(c.soft).toLocaleString('fr-FR');

                const barleyEl = document.getElementById('cf-barley');
                if (barleyEl) barleyEl.textContent = Number(c.barley).toLocaleString('fr-FR');

                const fevesEl = document.getElementById('cf-feves');
                if (fevesEl) fevesEl.textContent = Number(c.feves).toLocaleString('fr-FR');

                const chickpeasEl = document.getElementById('cf-chickpeas');
                if (chickpeasEl) chickpeasEl.textContent = Number(c.chickpeas).toLocaleString('fr-FR');

                if (window.__cerealsChart) {
                    window.__cerealsChart.data.datasets[0].data = c.cereals_chart;
                    window.__cerealsChart.update();
                }

                if (window.__pulsesChart) {
                    window.__pulsesChart.data.datasets[0].data = c.pulses_chart;
                    window.__pulsesChart.update();
                }

                try {
                    history.replaceState(null, '', c.id ? '?campagne=' + c.id : location.pathname);
                } catch (e) {}
            }
        };
    }

document.addEventListener('DOMContentLoaded', () => {

    /* ---------- Animated counters (per-element, scroll-triggered, once) ---------- */
    const animateCounter = (el) => {
        const target = parseInt(el.dataset.counter, 10) || 0;
        const duration = parseInt(el.dataset.duration, 10) || 1800;
        const start = performance.now();
        const step = (now) => {
            const progress = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.round(target * eased).toLocaleString('fr-FR');
            if (progress < 1) requestAnimationFrame(step);
        };
        requestAnimationFrame(step);
    };

    const counterObserver = new IntersectionObserver((entries, obs) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                animateCounter(e.target);
                obs.unobserve(e.target);
            }
        });
    }, { threshold: 0.4 });

    document.querySelectorAll('[data-counter]').forEach(el => counterObserver.observe(el));
    window.__animateCounter = animateCounter;

    /* ---------- Chart.js : 2 Donuts (Céréales & Légumineuses) ---------- */
    @php
        $initCereals = [
            (float) ($stats->durum_wheat_qx ?? 215000),
            (float) ($stats->soft_wheat_qx ?? 8000),
            (float) ($stats->barley_qx ?? 7000),
            (float) ($stats->oats_qx ?? 3000),
        ];
        $initFeves = (float) ($stats?->feves_qx ?? 850);
        $initChickpeas = (float) ($stats?->pois_chiches_qx ?? 650);
        $initFeveroles = (float) ($stats?->feveroles_qx ?? 350);
        $initLentilles = (float) ($stats?->lentilles_qx ?? 150);
        $sumPulses = $initFeves + $initChickpeas + $initFeveroles + $initLentilles;
        if ($sumPulses <= 0 && ($stats?->pulses_qx ?? 0) > 0) {
            $pTot = (float) $stats->pulses_qx;
            $initFeves = round($pTot * 0.425, 2);
            $initChickpeas = round($pTot * 0.325, 2);
            $initFeveroles = round($pTot * 0.175, 2);
            $initLentilles = round($pTot - ($initFeves + $initChickpeas + $initFeveroles), 2);
        }
        $initPulses = [$initFeves, $initChickpeas, $initFeveroles, $initLentilles];
    @endphp

    const cerealsCanvas = document.getElementById('cerealsDonutChart');
    if (cerealsCanvas) {
        window.__cerealsChart = new Chart(cerealsCanvas, {
            type: 'doughnut',
            data: {
                labels: ['Blé Dur', 'Blé Tendre', 'Orge', 'Avoine'],
                datasets: [{
                    data: @json($initCereals),
                    backgroundColor: ['#166534', '#10B981', '#F59E0B', '#D97706'],
                    borderWidth: 3,
                    borderColor: '#FFFFFF',
                    hoverOffset: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '66%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: 10,
                            font: { family: 'Inter', size: 11, weight: '600' },
                            color: '#64748B',
                        }
                    },
                    tooltip: {
                        backgroundColor: '#0F172A',
                        padding: 10,
                        cornerRadius: 8,
                        titleFont: { family: 'Inter', weight: '700' },
                        bodyFont: { family: 'Inter' },
                        callbacks: {
                            label: (c) => ' ' + c.label + ' : ' + Number(c.parsed).toLocaleString('fr-FR') + ' QX'
                        }
                    }
                },
                animation: { animateRotate: true, duration: 1200, easing: 'easeOutQuart' }
            }
        });
    }

    const pulsesCanvas = document.getElementById('pulsesDonutChart');
    if (pulsesCanvas) {
        window.__pulsesChart = new Chart(pulsesCanvas, {
            type: 'doughnut',
            data: {
                labels: ['Fèves', 'Pois chiches', 'Féveroles', 'Lentilles'],
                datasets: [{
                    data: @json($initPulses),
                    backgroundColor: ['#B45309', '#F59E0B', '#0D9488', '#34D399'],
                    borderWidth: 3,
                    borderColor: '#FFFFFF',
                    hoverOffset: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '66%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: 10,
                            font: { family: 'Inter', size: 11, weight: '600' },
                            color: '#64748B',
                        }
                    },
                    tooltip: {
                        backgroundColor: '#0F172A',
                        padding: 10,
                        cornerRadius: 8,
                        titleFont: { family: 'Inter', weight: '700' },
                        bodyFont: { family: 'Inter' },
                        callbacks: {
                            label: (c) => ' ' + c.label + ' : ' + Number(c.parsed).toLocaleString('fr-FR') + ' QX'
                        }
                    }
                },
                animation: { animateRotate: true, duration: 1200, easing: 'easeOutQuart' }
            }
        });
    }
});
</script>
@endpush
