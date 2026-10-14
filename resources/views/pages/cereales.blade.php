@extends('layouts.app')

@section('title', 'Céréales — COSEM')

@section('content')
@php
    $varietyBadges = [
        'Karim'     => ['Variété de référence', 'Sensible Septoriose'],
        'Razzak'    => ['Résistant à la verse', "Tolère l'échaudage"],
        'Khiar'     => ["Valorise l'irrigation d'appoint", 'Sols fertiles'],
        'Salim'     => ['Haute qualité industrielle', 'Tolérant maladies'],
        'Maali'     => ['Fort potentiel irrigué', 'Semoulerie'],
        'INRAT 100' => ['Rustique & Régulier'],
        'Dhahbi'    => ['Adapté au semi-aride'],
        'Utique'    => ['Blé panifiable', 'Bon tallage'],
        'Maktaris'  => ['Bonne valeur boulangère'],
        'Tahent'    => ['Productivité pluviale'],
        'Rihane'    => ["Orge d'élite polyvalente", 'Résistant sécheresse'],
        'Kounouz'   => ['Haut calibrage', 'Zone favorable'],
        'El Khir'   => ['Rustique fourragère & grainière'],
    ];
    $sowingPeriod = '15 nov - 10 déc';
    $modalDetails = [
        'Karim' => [
            'precocite' => 'Précoce à moyenne (80-100 jours)',
            'height'    => '80-100 cm, très bon enracinement',
            'lodging'   => 'Moyenne',
            'septoria'  => 'Sensible — Surveillance stricte',
            'septoria_level' => 'sensible',
            'rusts'     => 'Sensibilité moyenne (brune et jaune)',
            'oidium'    => 'Tolérance moyenne',
            'production'=> 'Bour favorable / Bon potentiel irrigué',
            'reco'      => 'Surveillance et traitement fongicide impératif au stade 2 nœuds à la dernière feuille étalée.',
        ],
        'Razzak' => [
            'precocite' => 'Moyen',
            'height'    => '80-90 cm, très bon enracinement',
            'lodging'   => 'Résistance élevée (paille courte et solide)',
            'septoria'  => 'Sensible — Surveillance stricte',
            'septoria_level' => 'sensible',
            'rusts'     => 'Sensibilité moyenne (brune et jaune)',
            'oidium'    => 'Tolérance moyenne',
            'production'=> 'Bour favorable',
            'reco'      => 'Paille courte et solide résistant à la verse; tolère le stress hydrique et l\'échaudage de fin de cycle.',
        ],
        'Khiar' => [
            'precocite' => 'Moyen',
            'height'    => '80-150 cm selon conduite, très bon enracinement',
            'lodging'   => 'Moyenne',
            'septoria'  => 'Sensible — Surveillance stricte',
            'septoria_level' => 'sensible',
            'rusts'     => 'Sensibilité moyenne (brune et jaune)',
            'oidium'    => 'Tolérance moyenne',
            'production'=> 'Bour favorable / Excellente réponse à l\'irrigation d\'appoint',
            'reco'      => 'Excellente réponse à l\'irrigation d\'appoint, valorise les sols profonds du Nord.',
        ],
        'Salim' => [
            'precocite' => 'Moyen',
            'height'    => '90-110 cm, très bon enracinement',
            'lodging'   => 'Bonne résistance',
            'septoria'  => 'Tolérant',
            'septoria_level' => 'tolerant',
            'rusts'     => 'Tolérant (brune et jaune)',
            'oidium'    => 'Tolérance moyenne',
            'production'=> 'Bour favorable / Haut potentiel irrigué',
            'reco'      => 'Haute qualité industrielle semoulière; tolérant aux maladies principales du blé dur.',
        ],
        'Maali' => [
            'precocite' => 'Semi-précoce',
            'height'    => '80-100 cm',
            'lodging'   => 'Bonne résistance',
            'septoria'  => 'Tolérance moyenne',
            'septoria_level' => 'moyen',
            'rusts'     => 'Sensibilité faible (brune et jaune)',
            'oidium'    => 'Tolérance moyenne',
            'production'=> 'Fort potentiel irrigué',
            'reco'      => 'Fort potentiel en irrigation d\'appoint; semoulerie de référence, sols fertiles valorisés.',
        ],
        'INRAT 100' => [
            'precocite' => 'Moyen',
            'height'    => '80-100 cm',
            'lodging'   => 'Résistance élevée (rustique & régulier)',
            'septoria'  => 'Tolérance moyenne',
            'septoria_level' => 'moyen',
            'rusts'     => 'Tolérant (brune et jaune)',
            'oidium'    => 'Tolérance moyenne',
            'production'=> 'Bour favorable, régulier',
            'reco'      => 'Rustique et régulière; adaptée aux conditions pluviales du Centre.',
        ],
        'Dhahbi' => [
            'precocite' => 'Précoce',
            'height'    => '70-90 cm',
            'lodging'   => 'Bonne résistance',
            'septoria'  => 'Tolérance moyenne',
            'septoria_level' => 'moyen',
            'rusts'     => 'Sensibilité faible (brune et jaune)',
            'oidium'    => 'Tolérance moyenne',
            'production'=> 'Bour favorable semi-aride',
            'reco'      => 'Adapté au semi-aride; tolère les sols pauvres et le déficit hydrique de fin de cycle.',
        ],
        'Utique' => [
            'precocite' => 'Semi-précoce',
            'height'    => '80-110 cm, bon tallage',
            'lodging'   => 'Résistance moyenne',
            'septoria'  => 'Tolérance moyenne',
            'septoria_level' => 'moyen',
            'rusts'     => 'Sensibilité moyenne (brune et jaune)',
            'oidium'    => 'Tolérance moyenne',
            'production'=> 'Bour favorable / Blé panifiable',
            'reco'      => 'Blé panifiable de bon tallage; meunerie de première qualité.',
        ],
        'Maktaris' => [
            'precocite' => 'Moyen',
            'height'    => '90-120 cm',
            'lodging'   => 'Bonne résistance',
            'septoria'  => 'Tolérance moyenne',
            'septoria_level' => 'moyen',
            'rusts'     => 'Sensibilité moyenne (brune et jaune)',
            'oidium'    => 'Tolérance moyenne',
            'production'=> 'Bour favorable',
            'reco'      => 'Bonne valeur boulangère; semis dans la fenêtre optimale pour sécuriser le rendement.',
        ],
        'Tahent' => [
            'precocite' => 'Moyen',
            'height'    => '80-110 cm',
            'lodging'   => 'Bonne résistance',
            'septoria'  => 'Tolérance moyenne',
            'septoria_level' => 'moyen',
            'rusts'     => 'Sensibilité faible (brune et jaune)',
            'oidium'    => 'Tolérance moyenne',
            'production'=> 'Bour favorable / Régime pluvial',
            'reco'      => 'Productivité en pluvial; limites en irrigation excessive.',
        ],
        'Rihane' => [
            'precocite' => 'Semi-précoce',
            'height'    => '70-100 cm',
            'lodging'   => 'Résistance élevée',
            'septoria'  => 'Résistant',
            'septoria_level' => 'resistant',
            'rusts'     => 'Tolérant (brune et jaune)',
            'oidium'    => 'Tolérance moyenne',
            'production'=> 'Bour favorable / Double aptitude grain & fourrage',
            'reco'      => 'Adaptation remarquable à la sécheresse et double aptitude grain/fourrage.',
        ],
        'Kounouz' => [
            'precocite' => 'Précoce à moyenne',
            'height'    => '80-110 cm, haut calibrage',
            'lodging'   => 'Bonne résistance',
            'septoria'  => 'Résistant',
            'septoria_level' => 'resistant',
            'rusts'     => 'Tolérant (brune et jaune)',
            'oidium'    => 'Tolérance moyenne',
            'production'=> 'Bour favorable / Grainière de zone favorable',
            'reco'      => 'Adaptation remarquable à la sécheresse et double aptitude grain/fourrage.',
        ],
        'El Khir' => [
            'precocite' => 'Moyen',
            'height'    => '90-130 cm',
            'lodging'   => 'Rustique, bonne tenue de la paille',
            'septoria'  => 'Tolérant',
            'septoria_level' => 'tolerant',
            'rusts'     => 'Tolérant (brune et jaune)',
            'oidium'    => 'Tolérance moyenne',
            'production'=> 'Bour favorable / Fourragère & grainière',
            'reco'      => 'Rustique fourragère & grainière; adaptation au semi-aride.',
        ],
    ];
    $tabLabels = ['all' => 'Toutes', 'ble_dur' => 'Blé Dur', 'ble_tendre' => 'Blé Tendre', 'orge' => 'Orge', 'triticale' => 'Triticale'];
    $tabCounts = [
        'all'        => $cereals->count(),
        'ble_dur'    => $cereals->where('category', 'ble_dur')->count(),
        'ble_tendre' => $cereals->where('category', 'ble_tendre')->count(),
        'orge'       => $cereals->where('category', 'orge')->count(),
        'triticale'  => $cereals->where('category', 'triticale')->count(),
    ];
@endphp
<div x-data="{
    activeModal: null,
    activeTab: 'all',
    searchQuery: '',
    items: {{ json_encode($cereals->map(fn($c) => [
        'category' => $c->category,
        'search' => mb_strtolower(trim($c->name.' '.$c->type.' '.$c->category_label.' '.($c->breeder ?? '').' '.($c->description ?? '').' '.($c->yield_potential ?? '').' '.($c->grain_quality ?? '').' '.implode(' ', $varietyBadges[$c->name] ?? []))),
    ])->values()) }},
    get matches() {
        const q = this.searchQuery.trim().toLowerCase();
        return this.items.filter(i =>
            (this.activeTab === 'all' || i.category === this.activeTab)
            && (!q || i.search.includes(q))
        );
    },
}">

    {{-- Header --}}
    <section class="page-header">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14 lg:py-16">
            <div class="section-eyebrow">
                <i data-lucide="wheat" class="w-4 h-4"></i>
                Catalogue des Semences
            </div>
            <h1 class="section-title mb-4">Nos <span class="text-gradient">Céréales</span> Certifiées</h1>
            <p class="text-slate-500 max-w-2xl">
                Variétés de blé dur, blé tendre, orge et triticale sélectionnées et certifiées par nos équipes techniques.
                Cliquez sur une variété pour afficher sa fiche détaillée complète.
            </p>

            <a href="#calculateur" class="mt-6 inline-flex items-center gap-2.5 px-5 py-3 rounded-xl bg-white border border-emerald-200 shadow-soft text-sm font-bold text-forest-700 hover:border-forest-600 hover:text-forest-800 hover:shadow-lift transition-all duration-200 group">
                <span class="w-9 h-9 rounded-lg bg-emerald-50 border border-emerald-100 flex items-center justify-center group-hover:bg-forest-700 group-hover:border-forest-700 transition-colors">
                    <i data-lucide="calculator" class="w-4 h-4 text-forest-600 group-hover:text-white transition-colors"></i>
                </span>
                Simuler vos besoins en semences
                <i data-lucide="arrow-down" class="w-4 h-4 text-forest-600 group-hover:translate-y-0.5 transition-transform"></i>
            </a>
        </div>
    </section>

    <section class="py-12 lg:py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Live search bar --}}
            <div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-6">
                <div class="relative flex-1 max-w-xl">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
                    </span>
                    <input type="search" x-model.live="searchQuery"
                           placeholder="Rechercher une variété de céréale (ex: Karim, Razzak, Blé Dur...)"
                           class="w-full pl-11 pr-11 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
                    <button type="button" x-show="searchQuery.length > 0" x-cloak @click="searchQuery = ''"
                            x-transition.opacity.duration.150ms
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-forest-700 transition" title="Effacer la recherche">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <p class="text-xs text-slate-400 font-semibold sm:ml-auto" x-text="matches.length + ' variété(s) affichée(s)'"></p>
            </div>

            {{-- Filter tabs --}}
            <div class="flex flex-wrap gap-2.5 mb-10">
                @foreach($tabLabels as $key => $label)
                    <button type="button" @click="activeTab = '{{ $key }}'"
                            :class="activeTab === '{{ $key }}' ? 'bg-forest-700 text-white border-forest-700 shadow-soft' : 'bg-white text-slate-600 border-emerald-200 hover:border-emerald-300 hover:text-forest-700'"
                            class="px-5 py-2.5 rounded-xl text-sm font-bold border transition-all duration-200 inline-flex items-center gap-2">
                        {{ $label }}
                        <span :class="activeTab === '{{ $key }}' ? 'bg-white/20 text-white' : 'bg-emerald-50 text-forest-700 border border-emerald-100'"
                              class="min-w-[22px] h-[22px] px-1.5 rounded-full text-[11px] font-extrabold inline-flex items-center justify-center">
                            {{ $tabCounts[$key] }}
                        </span>
                    </button>
                @endforeach
            </div>

            {{-- Cereals grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @foreach($cereals as $cereal)
                    @php
                        $cardBadges = $varietyBadges[$cereal->name] ?? [];
                        $haystack = mb_strtolower(trim($cereal->name.' '.$cereal->type.' '.$cereal->category_label.' '.($cereal->breeder ?? '').' '.($cereal->description ?? '').' '.($cereal->yield_potential ?? '').' '.($cereal->grain_quality ?? '').' '.implode(' ', $cardBadges)));
                    @endphp
                    <button type="button"
                            x-show="(activeTab === 'all' || activeTab === '{{ $cereal->category }}') && (searchQuery.trim() === '' || {{ json_encode($haystack) }}.includes(searchQuery.trim().toLowerCase()))"
                            x-transition.opacity.duration.200ms
                            @click="activeModal = {{ json_encode([
                                'id' => $cereal->id,
                                'name' => $cereal->name,
                                'image' => $cereal->image_path ? asset($cereal->image_path) : null,
                                'category' => $cereal->category_label ?? $cereal->category,
                                'cycle' => $cereal->optimal_cycle ?? 'Moyen',
                                'yield' => $cereal->yield_potential ?? 'Élevé',
                                'quality' => $cereal->grain_quality ?? 'Excellente',
                                'zones' => $cereal->targeted_zone ?? 'Nord et Centre',
                                'badges' => $cardBadges,
                                'semis' => $sowingPeriod,
                                'details' => $modalDetails[$cereal->name] ?? [],
                            ]) }}"
                            class="card card-hover overflow-hidden text-left group">
                        <div class="h-32 bg-gradient-to-br from-forest-700 to-forest-500 relative flex items-center justify-center overflow-hidden">
                            @if($cereal->image_path)
                                <img src="{{ asset($cereal->image_path) }}" alt="{{ $cereal->name }}"
                                     loading="lazy"
                                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                     onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1574323347407-f5e1ad6d020b?auto=format&fit=crop&w=800&q=80';">
                            @else
                                <i data-lucide="wheat" class="w-12 h-12 text-yellow-300/50 group-hover:scale-110 transition-transform"></i>
                            @endif
                            <div class="absolute inset-0 grain-overlay opacity-20"></div>
                            <span class="absolute top-3 left-3 badge bg-white/95 text-forest-700">{{ $cereal->category_label }}</span>
                            @if($cereal->breeder)
                                <span class="absolute top-3 right-3 badge bg-yellow-300/95 text-forest-900">{{ $cereal->breeder }}</span>
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="font-display text-lg font-bold text-ink group-hover:text-forest-700 transition">{{ $cereal->name }}</h3>
                            @if($cereal->type)
                                <p class="text-xs font-semibold text-forest-600 uppercase tracking-wider mt-0.5">{{ $cereal->type }}</p>
                            @endif
                            @if(count($cardBadges))
                                <div class="flex flex-wrap gap-1.5 mt-2.5">
                                    @foreach($cardBadges as $badge)
                                        <span class="px-2 py-0.5 rounded-full bg-emerald-50 border border-emerald-100 text-[10px] font-bold text-forest-700">{{ $badge }}</span>
                                    @endforeach
                                </div>
                            @endif
                            <p class="text-sm text-slate-400 leading-relaxed mt-2 line-clamp-2">{{ \Illuminate\Support\Str::limit($cereal->description, 80) }}</p>
                            <div class="mt-3 pt-3 border-t border-emerald-100 flex flex-wrap gap-x-3 gap-y-1 text-[10px] font-bold uppercase tracking-wider">
                                <span class="text-forest-600">{{ $cereal->category_label }}</span>
                                <span class="text-slate-400">Rendement : {{ $cereal->yield_potential ?? '—' }}</span>
                                <span class="text-harvest-600">Semis : {{ $sowingPeriod }}</span>
                            </div>
                            <span class="mt-3 inline-flex items-center gap-1.5 text-xs font-bold text-forest-600">
                                Voir la fiche complète <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform"></i>
                            </span>
                        </div>
                    </button>
                @endforeach
            </div>

            {{-- Empty state --}}
            <div x-show="matches.length === 0" x-cloak
                 x-transition.opacity.duration.200ms
                 class="card p-12 text-center">
                <div class="w-16 h-16 rounded-2xl bg-slate-50 border border-emerald-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
                </div>
                <h3 class="font-display text-xl font-bold text-ink mb-1">Aucune variété trouvée pour votre recherche.</h3>
                <p class="text-sm text-slate-400 mb-6">Essayez un autre mot-clé, ou réinitialisez les filtres pour afficher tout le catalogue.</p>
                <button type="button" @click="searchQuery = ''; activeTab = 'all'"
                        class="btn-primary inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Réinitialiser la recherche
                </button>
            </div>
        </div>
    </section>

    {{-- ==================== SEED DOSAGE CALCULATOR ==================== --}}
    <section id="calculateur" class="py-12 lg:py-16 bg-slate-50 border-y border-emerald-100 scroll-mt-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="max-w-2xl mb-10">
                <div class="section-eyebrow">
                    <i data-lucide="calculator" class="w-4 h-4"></i>
                    Outil Agronomique
                </div>
                <h2 class="section-title mb-3">Calculateur de <span class="text-gradient">Semences</span></h2>
                <p class="text-slate-500">
                    Estimez en temps réel votre besoin en semences certifiées selon l'espèce,
                    la superficie de votre parcelle et votre zone de conduite.
                </p>
            </div>

            <div x-data="seedCalculator()" class="card rounded-3xl shadow-xl border border-emerald-100 overflow-hidden">
                <div class="grid lg:grid-cols-5 gap-0">

                    {{-- Inputs --}}
                    <div class="lg:col-span-2 p-6 sm:p-8 bg-white border-b lg:border-b-0 lg:border-r border-emerald-100">
                        <h3 class="font-display text-lg font-bold text-ink mb-6 inline-flex items-center gap-2">
                            <i data-lucide="sliders-horizontal" class="w-5 h-5 text-forest-600"></i>
                            Paramètres de la parcelle
                        </h3>

                        <div class="space-y-5">
                            <div>
                                <label for="calc-culture" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Culture / Catégorie</label>
                                <select id="calc-culture" x-model="culture" @change="pmg = pmgDefaults[culture]"
                                        class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
                                    <option value="ble_dur">Blé Dur</option>
                                    <option value="ble_tendre">Blé Tendre</option>
                                    <option value="orge">Orge</option>
                                    <option value="triticale">Triticale</option>
                                </select>
                            </div>

                            <div>
                                <label for="calc-zone" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Zone Bioclimatique</label>
                                <select id="calc-zone" x-model="zone"
                                        class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
                                    <option value="favourable">Nord humide / sub-humide (Favorable)</option>
                                    <option value="moyen">Semi-aride supérieur (Moyen)</option>
                                    <option value="irrigue">Régime Irrigué d'appoint</option>
                                </select>
                            </div>

                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label for="calc-surface" class="block text-xs font-bold uppercase tracking-wider text-forest-700">Superficie (Hectares)</label>
                                    <span class="text-xs font-bold text-forest-700 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded-full" x-text="(parseFloat(surface) || 0).toLocaleString('fr-FR') + ' Ha'"></span>
                                </div>
                                <input id="calc-surface" type="number" min="0.1" step="0.5" x-model.number="surface"
                                       class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition mb-2">
                                <input type="range" min="0.5" max="100" step="0.5" x-model.number="surface"
                                       class="w-full accent-forest-700 cursor-pointer" aria-label="Curseur superficie">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="calc-pmg" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">PMG — Poids de mille grains (g)</label>
                                    <input id="calc-pmg" type="number" min="20" max="80" step="1" x-model.number="pmg"
                                           class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
                                    <p class="text-[10px] text-slate-400 font-semibold mt-1">Réf. COSEM : 48 g (Blé Dur) · 42 g (Blé Tendre) · 44 g (Orge)</p>
                                </div>
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <label for="calc-fg" class="block text-xs font-bold uppercase tracking-wider text-forest-700">Faculté germinative (%)</label>
                                        <span class="text-xs font-bold text-forest-700 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded-full" x-text="fg + '%'"></span>
                                    </div>
                                    <input id="calc-fg" type="range" min="90" max="95" step="1" x-model.number="fg"
                                           class="w-full accent-forest-700 cursor-pointer mt-3" aria-label="Faculté germinative">
                                    <p class="text-[10px] text-slate-400 font-semibold mt-1">Standard semences certifiées COSEM : 90 % – 95 %</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 rounded-2xl bg-emerald-50 border border-emerald-100 p-4 flex items-start gap-3">
                            <i data-lucide="info" class="w-4 h-4 text-forest-600 mt-0.5 shrink-0"></i>
                            <p class="text-xs text-forest-800 leading-relaxed">
                                Calcul basé sur la formule officielle INGC :
                                <strong>Dose (kg/Ha) = (Densité grains/m² × PMG) ÷ Faculté germinative (%)</strong>,
                                appliquée à la densité cible de votre zone bioclimatique.
                            </p>
                        </div>
                    </div>

                    {{-- Live outputs --}}
                    <div class="lg:col-span-3 p-6 sm:p-8">
                        <h3 class="font-display text-lg font-bold text-ink mb-6 inline-flex items-center gap-2">
                            <i data-lucide="package-check" class="w-5 h-5 text-harvest-500"></i>
                            Résultats en direct
                        </h3>

                        <div class="rounded-2xl bg-gradient-to-br from-forest-700 to-forest-600 p-5 mb-4 text-white flex flex-wrap items-center justify-between gap-4">
                            <div>
                                <div class="text-[10px] font-bold uppercase tracking-wider text-yellow-300 mb-1">Dose recommandée à l'Hectare</div>
                                <div class="font-display text-4xl font-extrabold leading-none" x-text="doseKgHa.toLocaleString('fr-FR')"></div>
                                <div class="text-xs font-bold text-white/70 mt-1">kg / Ha</div>
                            </div>
                            <div class="text-right">
                                <div class="text-[10px] font-bold uppercase tracking-wider text-white/60 mb-1">Densité cible INGC</div>
                                <div class="text-lg font-bold" x-text="densiteCible + ' grains/m²'"></div>
                                <div class="text-xs text-white/70" x-text="rangeLabel"></div>
                            </div>
                        </div>

                        <div class="grid sm:grid-cols-3 gap-4 mb-6">
                            <div class="rounded-2xl bg-slate-50 border border-emerald-100 p-5 text-center">
                                <i data-lucide="scale" class="w-5 h-5 text-forest-600 mx-auto mb-2"></i>
                                <div class="font-display text-2xl font-bold text-ink" x-text="totalKg.toLocaleString('fr-FR') + ' kg'"></div>
                                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mt-1">Quantité totale parcelle</div>
                            </div>
                            <div class="rounded-2xl bg-emerald-50 border border-emerald-100 p-5 text-center">
                                <i data-lucide="wheat" class="w-5 h-5 text-forest-600 mx-auto mb-2"></i>
                                <div class="font-display text-2xl font-bold text-ink" x-text="totalQx"></div>
                                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mt-1">Quintaux (QX) nécessaires</div>
                            </div>
                            <div class="rounded-2xl bg-yellow-50 border border-yellow-100 p-5 text-center">
                                <i data-lucide="package" class="w-5 h-5 text-harvest-500 mx-auto mb-2"></i>
                                <div class="font-display text-2xl font-bold text-ink" x-text="sacs50"></div>
                                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mt-1">Sacs de 50 kg recommandés</div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-emerald-100 overflow-hidden mb-4">
                            <div class="px-5 py-3 bg-slate-50 border-b border-emerald-100 text-xs font-bold uppercase tracking-wider text-forest-700">
                                Détail du calcul (formule INGC)
                            </div>
                            <table class="w-full text-sm">
                                <tbody>
                                    <tr class="border-b border-emerald-100">
                                        <td class="px-5 py-3 font-semibold text-slate-500">Culture / Catégorie</td>
                                        <td class="px-5 py-3 text-ink font-medium text-right" x-text="cultureLabel"></td>
                                    </tr>
                                    <tr class="border-b border-emerald-100">
                                        <td class="px-5 py-3 font-semibold text-slate-500">Zone bioclimatique</td>
                                        <td class="px-5 py-3 text-ink font-medium text-right" x-text="zoneLabel"></td>
                                    </tr>
                                    <tr class="border-b border-emerald-100">
                                        <td class="px-5 py-3 font-semibold text-slate-500">Densité cible</td>
                                        <td class="px-5 py-3 text-ink font-medium text-right" x-text="densiteCible + ' grains/m²'"></td>
                                    </tr>
                                    <tr class="border-b border-emerald-100">
                                        <td class="px-5 py-3 font-semibold text-slate-500">PMG (Poids de mille grains)</td>
                                        <td class="px-5 py-3 text-ink font-medium text-right" x-text="pmg + ' g'"></td>
                                    </tr>
                                    <tr class="border-b border-emerald-100">
                                        <td class="px-5 py-3 font-semibold text-slate-500">Faculté germinative</td>
                                        <td class="px-5 py-3 text-ink font-medium text-right" x-text="fg + ' %'"></td>
                                    </tr>
                                    <tr class="border-b border-emerald-100">
                                        <td class="px-5 py-3 font-semibold text-slate-500">Superficie</td>
                                        <td class="px-5 py-3 text-ink font-medium text-right" x-text="surface + ' Ha'"></td>
                                    </tr>
                                    <tr class="border-b border-emerald-100">
                                        <td class="px-5 py-3 font-semibold text-slate-500">Dose calculée</td>
                                        <td class="px-5 py-3 text-forest-700 font-bold text-right" x-text="doseKgHa.toLocaleString('fr-FR') + ' kg/ha'"></td>
                                    </tr>
                                    <tr>
                                        <td class="px-5 py-3 font-semibold text-slate-500">Besoin total</td>
                                        <td class="px-5 py-3 text-ink font-bold text-right" x-text="totalKg.toLocaleString('fr-FR') + ' kg  ·  ' + totalQx + ' QX  ·  ' + sacs50 + ' sacs'"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="rounded-2xl bg-gradient-to-br from-amber-50 to-yellow-50 border border-amber-200 p-5">
                            <div class="flex items-center gap-2 mb-3">
                                <i data-lucide="lightbulb" class="w-4 h-4 text-harvest-600"></i>
                                <span class="text-xs font-bold uppercase tracking-wider text-harvest-700">Repères techniques INGC</span>
                            </div>
                            <ul class="space-y-2.5 text-sm text-slate-700">
                                <li class="flex items-start gap-2.5">
                                    <span class="shrink-0 mt-0.5">📅</span>
                                    <span><strong class="font-bold text-ink">Période optimale de semis :</strong> Du 15 novembre au 10 décembre pour une implantation vigoureuse.</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <span class="shrink-0 mt-0.5">📏</span>
                                    <span><strong class="font-bold text-ink">Profondeur de semis :</strong> 3 à 5 cm maximum pour garantir une levée rapide et homogène.</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <span class="shrink-0 mt-0.5">🌾</span>
                                    <span><strong class="font-bold text-ink">Semences Certifiées :</strong> Les semences COSEM garantissent une pureté variétale supérieure à 99% et une germination certifiée.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Single Global Modal for Cereals -->
    <div x-show="activeModal !== null"
         x-cloak
         style="display: none;"
         @keydown.escape.window="activeModal = null"
         class="fixed inset-0 z-[999999] flex items-center justify-center p-4 sm:p-6 overflow-y-auto">

        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/75 backdrop-blur-md transition-opacity duration-300 ease-out"
             x-show="activeModal !== null"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="activeModal = null"></div>

        <!-- Modal Card Content -->
        <div class="relative z-10 w-full max-w-2xl bg-white rounded-3xl shadow-2xl border border-slate-100 p-6 sm:p-8 text-slate-800 my-auto max-h-[92vh] overflow-y-auto"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 scale-95"
             @click.outside="activeModal = null">

            <!-- Hero image -->
            <div class="w-full h-48 md:h-56 rounded-2xl overflow-hidden mb-6 bg-slate-100 shadow-inner">
                <img :src="activeModal?.image || 'https://images.unsplash.com/photo-1574323347407-f5e1ad6d020b?auto=format&fit=crop&w=1000&q=80'"
                     :alt="activeModal?.name"
                     class="w-full h-full object-cover">
            </div>

            <!-- Header with Close Button -->
            <div class="flex items-start justify-between pb-4 border-b border-slate-100">
                <div>
                    <span class="inline-block px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-semibold rounded-full uppercase tracking-wider mb-2" x-text="activeModal?.category"></span>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-emerald-950" x-text="activeModal?.name"></h3>
                    <div class="flex flex-wrap gap-1.5 mt-2" x-show="(activeModal?.badges || []).length">
                        <template x-for="b in (activeModal?.badges || [])" :key="b">
                            <span class="px-2 py-0.5 rounded-full bg-emerald-50 border border-emerald-200 text-[10px] font-bold text-emerald-800" x-text="b"></span>
                        </template>
                        <span class="px-2 py-0.5 rounded-full bg-amber-50 border border-amber-200 text-[10px] font-bold text-amber-800" x-show="activeModal?.semis" x-text="'Semis : ' + (activeModal?.semis || '')"></span>
                    </div>
                </div>
                <button type="button" @click="activeModal = null" aria-label="Fermer" class="text-slate-400 hover:text-slate-700 bg-slate-100 hover:bg-slate-200 p-2 rounded-full transition shrink-0 ml-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Section 1: Identité & Cycle Végétatif -->
            <div class="mt-6">
                <div class="flex items-center gap-2 mb-3">
                    <span class="w-7 h-7 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </span>
                    <h4 class="text-sm font-extrabold uppercase tracking-wider text-emerald-900">Identité & Cycle Végétatif</h4>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="text-[11px] uppercase text-slate-400 font-bold block mb-1">Espèce / Catégorie</span>
                        <span class="text-sm font-semibold text-slate-800" x-text="activeModal?.category"></span>
                    </div>
                    <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="text-[11px] uppercase text-slate-400 font-bold block mb-1">Précocité</span>
                        <span class="text-sm font-semibold text-slate-800" x-text="activeModal?.details?.precocite || '—'"></span>
                    </div>
                    <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="text-[11px] uppercase text-slate-400 font-bold block mb-1">Hauteur de la tige & Enracinement</span>
                        <span class="text-sm font-semibold text-slate-800" x-text="activeModal?.details?.height || '—'"></span>
                    </div>
                    <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="text-[11px] uppercase text-slate-400 font-bold block mb-1">Résistance à la verse</span>
                        <span class="text-sm font-semibold text-slate-800" x-text="activeModal?.details?.lodging || '—'"></span>
                    </div>
                </div>
            </div>

            <!-- Section 2: Profil Phytosanitaire & Tolérance aux Maladies (INGC) -->
            <div class="mt-6">
                <div class="flex items-center gap-2 mb-3">
                    <span class="w-7 h-7 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    </span>
                    <h4 class="text-sm font-extrabold uppercase tracking-wider text-emerald-900">Profil Phytosanitaire & Tolérance aux Maladies (INGC)</h4>
                </div>
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-sm text-slate-600 font-semibold">Septoriose <span class="text-xs text-slate-400 font-normal">(Zymoseptoria tritici)</span></span>
                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold border shrink-0"
                              :class="{
                                  'bg-red-50 border-red-200 text-red-700': (activeModal?.details?.septoria_level || '') === 'sensible',
                                  'bg-emerald-50 border-emerald-200 text-emerald-700': ['tolerant','resistant'].includes(activeModal?.details?.septoria_level || ''),
                                  'bg-amber-50 border-amber-200 text-amber-700': (activeModal?.details?.septoria_level || '') === 'moyen',
                              }"
                              x-text="activeModal?.details?.septoria || '—'"></span>
                    </div>
                    <div class="flex items-center justify-between gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-sm text-slate-600 font-semibold">Rouilles <span class="text-xs text-slate-400 font-normal">(Brune et Jaune)</span></span>
                        <span class="text-sm font-semibold text-slate-800 text-right" x-text="activeModal?.details?.rusts || '—'"></span>
                    </div>
                    <div class="flex items-center justify-between gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-sm text-slate-600 font-semibold">Oïdium</span>
                        <span class="text-sm font-semibold text-slate-800 text-right" x-text="activeModal?.details?.oidium || '—'"></span>
                    </div>
                    <div class="flex items-start gap-2.5 p-3 bg-emerald-50 rounded-xl border border-emerald-100 text-emerald-900 text-sm">
                        <svg class="w-4 h-4 mt-0.5 text-emerald-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span><strong class="font-bold">Note officielle :</strong> Semences traitées et certifiées COSEM contre le Charbon et la Carie.</span>
                    </div>
                </div>
            </div>

            <!-- Section 3: Itinéraire Technique & Potentiel de Rendement -->
            <div class="mt-6">
                <div class="flex items-center gap-2 mb-3">
                    <span class="w-7 h-7 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    </span>
                    <h4 class="text-sm font-extrabold uppercase tracking-wider text-emerald-900">Itinéraire Technique & Potentiel de Rendement</h4>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="text-[11px] uppercase text-slate-400 font-bold block mb-1">Potentiel de production</span>
                        <span class="text-sm font-semibold text-slate-800" x-text="activeModal?.details?.production || '—'"></span>
                    </div>
                    <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="text-[11px] uppercase text-slate-400 font-bold block mb-1">Potentiel de rendement</span>
                        <span class="text-sm font-semibold text-slate-800" x-text="activeModal?.yield"></span>
                    </div>
                    <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="text-[11px] uppercase text-slate-400 font-bold block mb-1">Période optimale de semis</span>
                        <span class="text-sm font-semibold text-slate-800">15 Novembre au 10 Décembre</span>
                    </div>
                    <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="text-[11px] uppercase text-slate-400 font-bold block mb-1">Profondeur de semis conseillée</span>
                        <span class="text-sm font-semibold text-slate-800">3 à 5 cm</span>
                    </div>
                </div>
                <div class="mt-3 p-3.5 bg-gradient-to-br from-emerald-50 to-amber-50 rounded-2xl border border-emerald-100 text-slate-800 text-sm leading-relaxed">
                    <strong class="font-bold text-emerald-900">Recommandations spécifiques INGC : </strong>
                    <span x-text="activeModal?.details?.reco || '—'"></span>
                </div>
                <div class="mt-3 p-3.5 bg-slate-50 rounded-2xl border border-slate-100 text-sm flex flex-wrap gap-x-4 gap-y-1">
                    <span class="text-slate-600"><span class="text-[11px] uppercase text-slate-400 font-bold">Cycle optimal : </span><span class="font-semibold text-slate-800" x-text="activeModal?.cycle"></span></span>
                    <span class="text-slate-600"><span class="text-[11px] uppercase text-slate-400 font-bold">Qualité de grain : </span><span class="font-semibold text-slate-800" x-text="activeModal?.quality"></span></span>
                    <span class="text-slate-600"><span class="text-[11px] uppercase text-slate-400 font-bold">Zones recommandées : </span><span class="font-semibold text-slate-800" x-text="activeModal?.zones"></span></span>
                </div>
            </div>

            <!-- Section 4: Action & Téléchargement -->
            <div class="mt-6 pt-5 border-t border-slate-100">
                <div class="flex flex-wrap justify-end gap-3">
                    <a href="{{ route('contact.index') }}" class="btn-primary">
                        <i data-lucide="send" class="w-4 h-4"></i> Demander un devis
                    </a>
                    <a :href="'/cereales/' + activeModal.id + '/pdf'" target="_blank" rel="noopener"
                       class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-800 text-white hover:bg-emerald-900 font-semibold text-sm transition shadow-sm">
                        <svg class="w-5 h-5 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Télécharger la Fiche Technique Officielle (PDF)
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function seedCalculator() {
        return {
            culture: 'ble_dur',
            surface: 5,
            zone: 'favourable',
            pmg: 48,
            fg: 90,

            pmgDefaults: {
                ble_dur: 48, ble_tendre: 42, orge: 44, triticale: 42,
            },

            // Densités cibles INGC (grains/m²) par culture et zone bioclimatique
            densities: {
                ble_dur: {
                    favourable: { target: 300, min: 280, max: 320 },
                    moyen:      { target: 265, min: 250, max: 280 },
                    irrigue:    { target: 335, min: 320, max: 350 },
                },
                ble_tendre: {
                    favourable: { target: 300, min: 280, max: 320, note: 'fourchette 140-160 kg/ha' },
                    moyen:      { target: 300, min: 280, max: 320, note: 'fourchette 140-160 kg/ha' },
                    irrigue:    { target: 300, min: 280, max: 320, note: 'fourchette 140-160 kg/ha' },
                },
                orge: {
                    favourable: { target: 250, min: 230, max: 270, note: 'fourchette 110-130 kg/ha' },
                    moyen:      { target: 250, min: 230, max: 270, note: 'fourchette 110-130 kg/ha' },
                    irrigue:    { target: 250, min: 230, max: 270, note: 'fourchette 110-130 kg/ha' },
                },
                triticale: {
                    favourable: { target: 300, min: 280, max: 320, note: 'fourchette 140-150 kg/ha' },
                    moyen:      { target: 300, min: 280, max: 320, note: 'fourchette 140-150 kg/ha' },
                    irrigue:    { target: 300, min: 280, max: 320, note: 'fourchette 140-150 kg/ha' },
                },
            },

            labels: {
                ble_dur: 'Blé Dur', ble_tendre: 'Blé Tendre', orge: 'Orge', triticale: 'Triticale',
            },

            zoneLabels: {
                favourable: 'Nord humide / sub-humide (Favorable)',
                moyen: 'Semi-aride supérieur (Moyen)',
                irrigue: "Régime Irrigué d'appoint",
            },

            get density() {
                return this.densities[this.culture][this.zone];
            },

            get densiteCible() {
                return this.density.target;
            },

            get rangeLabel() {
                const d = this.density;
                return d.note
                    ? d.min + '-' + d.max + ' grains/m² · ' + d.note
                    : d.min + '-' + d.max + ' grains/m²';
            },

            // Formule officielle INGC :
            // Dose (kg/ha) = (grains/m² × 10 000 × PMG/1000) ÷ (FG/100) ÷ 1000
            //              = (densité grains/m² × PMG) ÷ FG(%)
            get doseKgHa() {
                const fg = Math.min(95, Math.max(90, parseFloat(this.fg) || 90));
                const pmg = Math.min(80, Math.max(20, parseFloat(this.pmg) || 48));
                const raw = (this.densiteCible * pmg) / fg;
                return Math.round(raw * 10) / 10;
            },

            get totalKg() {
                const s = Math.max(0.1, parseFloat(this.surface) || 0);
                return Math.round(s * this.doseKgHa);
            },

            get totalQx() {
                return (this.totalKg / 100).toLocaleString('fr-FR', { maximumFractionDigits: 1 });
            },

            get sacs50() {
                return Math.ceil(this.totalKg / 50).toLocaleString('fr-FR');
            },

            get cultureLabel() {
                return this.labels[this.culture];
            },

            get zoneLabel() {
                return this.zoneLabels[this.zone];
            },
        };
    }
</script>
@endpush
