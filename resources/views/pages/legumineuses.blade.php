@extends('layouts.app')

@section('title', 'Légumineuses — COSEM')

@section('content')
@php
    $pulseBadges = [
        'Poiche'      => ['Diversification céréalière', 'Fixateur d\'azote'],
        'Pois chiche' => ['Diversification céréalière', 'Fixateur d\'azote'],
        'Fève'        => ['Haute valeur protéique', 'Précédent cultural idéal'],
        'Fèves'       => ['Haute valeur protéique', 'Précédent cultural idéal'],
        'Féverole'    => ['Excellente valeur fourragère', 'Rustique'],
        'Féveroles'   => ['Excellente valeur fourragère', 'Rustique'],
        'Lentille'    => ['Riche en fer & minéraux', 'Sobriété hydrique'],
        'Lentilles'   => ['Riche en fer & minéraux', 'Sobriété hydrique'],
        'Haricot'     => ['Filière maraîchère & sèche', 'Cycle court'],
        'Haricots'    => ['Filière maraîchère & sèche', 'Cycle court'],
    ];

    $pulseDetails = [
        'Poiche' => [
            'species'    => 'Pois chiche (Cicer arietinum L.)',
            'precocite'  => 'Semi-précoce (90-110 jours)',
            'resistance' => 'Bonne tolérance à l\'Anthracnose (Ascochyta rabiei)',
            'zone'       => 'Nord et Centre céréalier (Béja, Bizerte, Siliana, Zaghouan)',
            'packaging'  => 'Sacs homologués 25 kg / 50 kg',
            'density'    => '90 à 110 kg/Ha',
            'reco'       => 'Excellent précédent pour le blé dur. Fixe l\'azote atmosphérique et améliore la structure du sol.',
            'image'      => 'https://images.unsplash.com/photo-1515543237350-b3eea1ec8082?auto=format&fit=crop&w=1000&q=80',
        ],
        'Pois chiche' => [
            'species'    => 'Pois chiche (Cicer arietinum L.)',
            'precocite'  => 'Semi-précoce (90-110 jours)',
            'resistance' => 'Bonne tolérance à l\'Anthracnose (Ascochyta rabiei)',
            'zone'       => 'Nord et Centre céréalier (Béja, Bizerte, Siliana, Zaghouan)',
            'packaging'  => 'Sacs homologués 25 kg / 50 kg',
            'density'    => '90 à 110 kg/Ha',
            'reco'       => 'Excellent précédent pour le blé dur. Fixe l\'azote atmosphérique et améliore la structure du sol.',
            'image'      => 'https://images.unsplash.com/photo-1515543237350-b3eea1ec8082?auto=format&fit=crop&w=1000&q=80',
        ],
        'Fève' => [
            'species'    => 'Fève commune (Vicia faba major)',
            'precocite'  => 'Moyenne à tardive (120-150 jours)',
            'resistance' => 'Tolérante au Botrytis et à la Rouille, surveillance Orobanche',
            'zone'       => 'Nord humide et sub-humide (Bizerte, Béja, Jendouba, Mateur)',
            'packaging'  => 'Sacs homologués 25 kg / 50 kg',
            'density'    => '130 à 160 kg/Ha',
            'reco'       => 'Plante nettoyante et améliorante majeure dans les rotations céréalières du Nord.',
            'image'      => 'https://images.unsplash.com/photo-1592417817098-8f3d6910985b?auto=format&fit=crop&w=1000&q=80',
        ],
        'Fèves' => [
            'species'    => 'Fève commune (Vicia faba major)',
            'precocite'  => 'Moyenne à tardive (120-150 jours)',
            'resistance' => 'Tolérante au Botrytis et à la Rouille, surveillance Orobanche',
            'zone'       => 'Nord humide et sub-humide (Bizerte, Béja, Jendouba, Mateur)',
            'packaging'  => 'Sacs homologués 25 kg / 50 kg',
            'density'    => '130 à 160 kg/Ha',
            'reco'       => 'Plante nettoyante et améliorante majeure dans les rotations céréalières du Nord.',
            'image'      => 'https://images.unsplash.com/photo-1592417817098-8f3d6910985b?auto=format&fit=crop&w=1000&q=80',
        ],
        'Féverole' => [
            'species'    => 'Féverole (Vicia faba minor)',
            'precocite'  => 'Semi-précoce (110-130 jours)',
            'resistance' => 'Bonne rusticité générale, tolérante au froid hivernal',
            'zone'       => 'Nord et Hauts-Plateaux (Béja, Siliana, Le Kef)',
            'packaging'  => 'Sacs homologués 25 kg / 50 kg',
            'density'    => '110 à 130 kg/Ha',
            'reco'       => 'Excellente source de protéines végétales, très appréciée pour l\'alimentation animale et la rotation.',
            'image'      => 'https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&w=1000&q=80',
        ],
        'Féveroles' => [
            'species'    => 'Féverole (Vicia faba minor)',
            'precocite'  => 'Semi-précoce (110-130 jours)',
            'resistance' => 'Bonne rusticité générale, tolérante au froid hivernal',
            'zone'       => 'Nord et Hauts-Plateaux (Béja, Siliana, Le Kef)',
            'packaging'  => 'Sacs homologués 25 kg / 50 kg',
            'density'    => '110 à 130 kg/Ha',
            'reco'       => 'Excellente source de protéines végétales, très appréciée pour l\'alimentation animale et la rotation.',
            'image'      => 'https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&w=1000&q=80',
        ],
        'Lentille' => [
            'species'    => 'Lentille cultivée (Lens culinaris)',
            'precocite'  => 'Moyenne (100-130 jours)',
            'resistance' => 'Tolérance élevée à la sécheresse et à la Fusariose',
            'zone'       => 'Semi-aride supérieur et moyen (Zaghouan, Siliana, Kairouan)',
            'packaging'  => 'Sacs homologués 25 kg / 50 kg',
            'density'    => '70 à 90 kg/Ha',
            'reco'       => 'Très sobre en eau, idéale pour valoriser les parcelles à pluviométrie modérée.',
            'image'      => 'https://images.unsplash.com/photo-1585994192701-f1a505c817ea?auto=format&fit=crop&w=1000&q=80',
        ],
        'Lentilles' => [
            'species'    => 'Lentille cultivée (Lens culinaris)',
            'precocite'  => 'Moyenne (100-130 jours)',
            'resistance' => 'Tolérance élevée à la sécheresse et à la Fusariose',
            'zone'       => 'Semi-aride supérieur et moyen (Zaghouan, Siliana, Kairouan)',
            'packaging'  => 'Sacs homologués 25 kg / 50 kg',
            'density'    => '70 à 90 kg/Ha',
            'reco'       => 'Très sobre en eau, idéale pour valoriser les parcelles à pluviométrie modérée.',
            'image'      => 'https://images.unsplash.com/photo-1585994192701-f1a505c817ea?auto=format&fit=crop&w=1000&q=80',
        ],
        'Haricot' => [
            'species'    => 'Haricot commun (Phaseolus vulgaris)',
            'precocite'  => 'Précoce à moyenne (90-120 jours)',
            'resistance' => 'Tolérant aux viroses courantes et à l\'Anthracnose',
            'zone'       => 'Cap Bon, Bizerte et vallées irriguées de la Medjerda',
            'packaging'  => 'Sacs homologués 25 kg / 50 kg',
            'density'    => '80 à 100 kg/Ha',
            'reco'       => 'Culture à cycle rapide valorisant les terres légères et l\'irrigation estivale ou d\'appoint.',
            'image'      => 'https://images.unsplash.com/photo-1551462147-ff29053bfc14?auto=format&fit=crop&w=1000&q=80',
        ],
        'Haricots' => [
            'species'    => 'Haricot commun (Phaseolus vulgaris)',
            'precocite'  => 'Précoce à moyenne (90-120 jours)',
            'resistance' => 'Tolérant aux viroses courantes et à l\'Anthracnose',
            'zone'       => 'Cap Bon, Bizerte et vallées irriguées de la Medjerda',
            'packaging'  => 'Sacs homologués 25 kg / 50 kg',
            'density'    => '80 à 100 kg/Ha',
            'reco'       => 'Culture à cycle rapide valorisant les terres légères et l\'irrigation estivale ou d\'appoint.',
            'image'      => 'https://images.unsplash.com/photo-1551462147-ff29053bfc14?auto=format&fit=crop&w=1000&q=80',
        ],
    ];
@endphp

<div x-data="{
    activeModal: null,
    searchQuery: '',
    items: {{ json_encode($pulses->map(fn($p) => [
        'search' => mb_strtolower(trim($p->name.' '.($p->variety ?? '').' '.($p->optimal_cycle ?? '').' '.($p->yield_potential ?? '').' '.($p->description ?? '').' '.($pulseDetails[$p->name]['species'] ?? '').' '.implode(' ', $pulseBadges[$p->name] ?? []).' sacs 25kg 50kg')),
    ])->values()) }},
    get matches() {
        const q = this.searchQuery.trim().toLowerCase();
        return this.items.filter(i => !q || i.search.includes(q));
    },
}">

    {{-- Header --}}
    <section class="page-header">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14 lg:py-16">
            <div class="section-eyebrow">
                <i data-lucide="leaf" class="w-4 h-4"></i>
                Catalogue des Semences
            </div>
            <h1 class="section-title mb-4">Nos <span class="text-gradient">Légumineuses</span> Certifiées</h1>
            <p class="text-slate-500 max-w-2xl">
                Pois chiches, fèves, féveroles, lentilles et haricots sélectionnés et certifiés par nos équipes techniques.
                Cliquez sur une variété pour agrandir sa photo et consulter sa fiche agronomique détaillée.
            </p>
        </div>
    </section>

    <section class="py-12 lg:py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Live search bar --}}
            <div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-8">
                <div class="relative flex-1 max-w-xl">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
                    </span>
                    <input type="search" x-model.live="searchQuery"
                           placeholder="Rechercher une légumineuse (Pois chiche, Fève, Féverole, Lentille...)"
                           class="w-full pl-11 pr-11 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
                    <button type="button" x-show="searchQuery.length > 0" x-cloak @click="searchQuery = ''"
                            x-transition.opacity.duration.150ms
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-forest-700 transition" title="Effacer la recherche">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <p class="text-xs text-slate-400 font-semibold sm:ml-auto" x-text="matches.length + ' variété(s) affichée(s)'"></p>
            </div>

            {{-- Pulses Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($pulses as $pulse)
                    @php
                        $details = $pulseDetails[$pulse->name] ?? [];
                        $cardBadges = $pulseBadges[$pulse->name] ?? ['Semence certifiée'];
                        $imageSrc = $pulse->image_path
                            ? asset($pulse->image_path)
                            : ($details['image'] ?? 'https://images.unsplash.com/photo-1515543237350-b3eea1ec8082?auto=format&fit=crop&w=1000&q=80');
                        $haystack = mb_strtolower(trim($pulse->name.' '.($pulse->variety ?? '').' '.($pulse->optimal_cycle ?? '').' '.($pulse->yield_potential ?? '').' '.($pulse->description ?? '').' '.($details['species'] ?? '').' '.implode(' ', $cardBadges).' sacs 25kg 50kg'));
                    @endphp
                    <button type="button"
                            x-show="searchQuery.trim() === '' || {{ json_encode($haystack) }}.includes(searchQuery.trim().toLowerCase())"
                            x-transition.opacity.duration.200ms
                            @click="activeModal = {{ json_encode([
                                'id' => $pulse->id,
                                'name' => $pulse->name,
                                'image' => $imageSrc,
                                'category' => 'Légumineuse Certifiée',
                                'species' => $details['species'] ?? 'Légumineuse (Fabaceae)',
                                'variety' => $pulse->variety ?? 'Sélection locale',
                                'cycle' => $pulse->optimal_cycle ?? $details['precocite'] ?? 'Moyen (90-120 jours)',
                                'yield' => $pulse->yield_potential ?? '15-25 qx/ha',
                                'quality' => $pulse->grain_quality ?? 'Excellente valeur alimentaire',
                                'resistance' => $pulse->disease_resistance ?? $details['resistance'] ?? 'Bonne rusticité et tolérance sanitaire',
                                'zones' => $pulse->targeted_zone ?? $details['zone'] ?? 'Nord et Centre de la Tunisie',
                                'packaging' => $details['packaging'] ?? 'Sacs homologués 25 kg / 50 kg',
                                'density' => $details['density'] ?? '100 à 120 kg/Ha',
                                'badges' => $cardBadges,
                                'reco' => $details['reco'] ?? 'Semences certifiées COSEM, idéales pour la rotation avec les céréales.',
                                'description' => $pulse->description,
                            ]) }}"
                            class="card card-hover overflow-hidden text-left group">
                        <div class="h-36 bg-gradient-to-br from-forest-700 to-forest-500 relative flex items-center justify-center overflow-hidden">
                            <img src="{{ $imageSrc }}"
                                 alt="{{ $pulse->name }}"
                                 loading="lazy"
                                 class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                 onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1515543237350-b3eea1ec8082?auto=format&fit=crop&w=800&q=80';">
                            <div class="absolute inset-0 grain-overlay opacity-20"></div>
                            <span class="absolute top-3 left-3 badge bg-white/95 text-forest-700 shadow-sm">
                                <i data-lucide="leaf" class="w-3 h-3 text-harvest-500"></i> Légumineuse
                            </span>
                            <span class="absolute top-3 right-3 badge bg-amber-400 text-forest-950 font-bold shadow-sm">
                                25 / 50 kg
                            </span>
                        </div>
                        <div class="p-5">
                            <div class="flex items-start justify-between gap-2">
                                <div>
                                    <h3 class="font-display text-lg font-bold text-ink group-hover:text-forest-700 transition">{{ $pulse->name }}</h3>
                                    <p class="text-xs font-semibold text-forest-600 uppercase tracking-wider mt-0.5">{{ $pulse->variety ?? 'Sélection locale' }}</p>
                                </div>
                                <span class="p-1.5 rounded-lg bg-emerald-50 text-forest-700 shrink-0 group-hover:bg-forest-700 group-hover:text-white transition" title="Agrandir et voir la fiche">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                                </span>
                            </div>

                            @if(count($cardBadges))
                                <div class="flex flex-wrap gap-1.5 mt-2.5">
                                    @foreach($cardBadges as $badge)
                                        <span class="px-2 py-0.5 rounded-full bg-emerald-50 border border-emerald-100 text-[10px] font-bold text-forest-700">{{ $badge }}</span>
                                    @endforeach
                                </div>
                            @endif

                            @if($pulse->description)
                                <p class="text-sm text-slate-400 leading-relaxed mt-2 line-clamp-2">{{ \Illuminate\Support\Str::limit($pulse->description, 80) }}</p>
                            @endif

                            <div class="mt-3 pt-3 border-t border-emerald-100 flex flex-wrap gap-x-3 gap-y-1 text-[10px] font-bold uppercase tracking-wider">
                                <span class="text-forest-600">Cycle : {{ $pulse->optimal_cycle ?? '90-120 j' }}</span>
                                <span class="text-slate-400">Rdt : {{ $pulse->yield_potential ?? '15-25 QX' }}</span>
                                <span class="text-harvest-600">Sacs : 25 &amp; 50 kg</span>
                            </div>

                            <span class="mt-3 inline-flex items-center gap-1.5 text-xs font-bold text-forest-600">
                                Voir la fiche complète &amp; zoom <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform"></i>
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
                <p class="text-sm text-slate-400 mb-6">Essayez un autre mot-clé (nom, cycle, rendement) ou réinitialisez la recherche.</p>
                <button type="button" @click="searchQuery = ''"
                        class="btn-primary inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Réinitialiser la recherche
                </button>
            </div>
        </div>
    </section>

    <!-- Single Global Modal for Légumineuses (Zoom & Fiche Détaillée) -->
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

            <!-- Hero image : Zoom sur la graine & la culture -->
            <div class="w-full h-52 sm:h-64 rounded-2xl overflow-hidden mb-6 bg-slate-100 shadow-inner relative group/zoom">
                <img :src="activeModal?.image || 'https://images.unsplash.com/photo-1515543237350-b3eea1ec8082?auto=format&fit=crop&w=1000&q=80'"
                     :alt="activeModal?.name"
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-white text-xs">
                    <span class="px-3 py-1 rounded-full bg-white/90 backdrop-blur-sm text-forest-800 font-bold inline-flex items-center gap-1.5 shadow-sm">
                        <svg class="w-3.5 h-3.5 text-forest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                        Zoom HD — Graine &amp; Culture
                    </span>
                    <span class="px-3 py-1 rounded-full bg-amber-400 text-forest-950 font-extrabold shadow-sm">
                        Homologué COSEM
                    </span>
                </div>
            </div>

            <!-- Header with Close Button -->
            <div class="flex items-start justify-between pb-4 border-b border-slate-100">
                <div>
                    <span class="inline-block px-3 py-1 bg-amber-100 text-amber-800 text-xs font-semibold rounded-full uppercase tracking-wider mb-2" x-text="activeModal?.category"></span>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-emerald-950" x-text="activeModal?.name"></h3>
                    <p class="text-sm font-semibold text-forest-700 mt-1" x-text="(activeModal?.species || 'Légumineuse') + ' — ' + (activeModal?.variety || 'Sélection locale')"></p>
                    <div class="flex flex-wrap gap-1.5 mt-2" x-show="(activeModal?.badges || []).length">
                        <template x-for="b in (activeModal?.badges || [])" :key="b">
                            <span class="px-2 py-0.5 rounded-full bg-emerald-50 border border-emerald-200 text-[10px] font-bold text-emerald-800" x-text="b"></span>
                        </template>
                    </div>
                </div>
                <button type="button" @click="activeModal = null" aria-label="Fermer" class="text-slate-400 hover:text-slate-700 bg-slate-100 hover:bg-slate-200 p-2.5 rounded-full transition shrink-0 ml-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Section 1: Identité & Conditionnement Officiel (25 kg / 50 kg) -->
            <div class="mt-6">
                <div class="flex items-center gap-2 mb-3">
                    <span class="w-7 h-7 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </span>
                    <h4 class="text-sm font-extrabold uppercase tracking-wider text-emerald-900">Identité &amp; Conditionnement Officiel</h4>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="text-[11px] uppercase text-slate-400 font-bold block mb-1">Espèce Botanique</span>
                        <span class="text-sm font-semibold text-slate-800" x-text="activeModal?.species || 'Légumineuse'"></span>
                    </div>
                    <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="text-[11px] uppercase text-slate-400 font-bold block mb-1">Variété Sélectionnée</span>
                        <span class="text-sm font-semibold text-slate-800" x-text="activeModal?.variety || 'Sélection locale'"></span>
                    </div>
                    <div class="p-3.5 bg-gradient-to-br from-amber-50 to-emerald-50 rounded-2xl border border-amber-200 sm:col-span-2">
                        <div class="flex items-start gap-3">
                            <span class="w-9 h-9 rounded-xl bg-amber-400/20 text-harvest-700 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-5 h-5 text-harvest-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                            </span>
                            <div>
                                <span class="text-[11px] uppercase text-harvest-800 font-bold block mb-0.5">Poids de Conditionnement Officiel</span>
                                <p class="text-sm font-extrabold text-forest-900" x-text="activeModal?.packaging || 'Sacs homologués 25 kg / 50 kg'"></p>
                                <p class="text-xs text-slate-500 mt-1">Sacs scellés homologués COSEM / DGSV avec étiquette officielle de certification, traçabilité et pureté garantie.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Caractéristiques Agronomiques & Sanitaires -->
            <div class="mt-6">
                <div class="flex items-center gap-2 mb-3">
                    <span class="w-7 h-7 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </span>
                    <h4 class="text-sm font-extrabold uppercase tracking-wider text-emerald-900">Caractéristiques Agronomiques</h4>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="text-[11px] uppercase text-slate-400 font-bold block mb-1">Précocité / Cycle</span>
                        <span class="text-sm font-semibold text-slate-800" x-text="activeModal?.cycle || '—'"></span>
                    </div>
                    <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="text-[11px] uppercase text-slate-400 font-bold block mb-1">Potentiel de Rendement</span>
                        <span class="text-sm font-semibold text-slate-800" x-text="activeModal?.yield || '—'"></span>
                    </div>
                    <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="text-[11px] uppercase text-slate-400 font-bold block mb-1">Qualité de Grain</span>
                        <span class="text-sm font-semibold text-slate-800" x-text="activeModal?.quality || 'Excellente'"></span>
                    </div>
                    <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="text-[11px] uppercase text-slate-400 font-bold block mb-1">Densité de Semis Conseillée</span>
                        <span class="text-sm font-semibold text-slate-800" x-text="activeModal?.density || '100 à 120 kg/Ha'"></span>
                    </div>
                </div>

                <div class="mt-3 p-3.5 bg-slate-50 rounded-2xl border border-slate-100">
                    <div class="flex items-center justify-between gap-3">
                        <span class="text-xs uppercase text-slate-400 font-bold">Résistance aux Maladies</span>
                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 border border-emerald-200 text-emerald-800 text-right"
                              x-text="activeModal?.resistance || 'Tolérant'"></span>
                    </div>
                </div>
            </div>

            <!-- Section 3: Zones Recommandées & Itinéraire Technique -->
            <div class="mt-6">
                <div class="flex items-center gap-2 mb-3">
                    <span class="w-7 h-7 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </span>
                    <h4 class="text-sm font-extrabold uppercase tracking-wider text-emerald-900">Zones Recommandées &amp; Conduite</h4>
                </div>
                <div class="p-3.5 bg-emerald-50 rounded-2xl border border-emerald-100 text-emerald-900 text-sm mb-3">
                    <strong class="font-bold">Territoires adaptés : </strong>
                    <span x-text="activeModal?.zones || 'Nord et Centre céréalier de Tunisie'"></span>
                </div>
                <div class="p-3.5 bg-gradient-to-br from-emerald-50 to-amber-50 rounded-2xl border border-emerald-100 text-slate-800 text-sm leading-relaxed">
                    <strong class="font-bold text-emerald-900">Recommandations agronomiques COSEM : </strong>
                    <span x-text="activeModal?.reco || 'Semences de haute pureté variétale. Précédent idéal pour enrichir le sol en azote avant une céréale.'"></span>
                </div>
            </div>

            <!-- Section 4: Action & Téléchargement -->
            <div class="mt-6 pt-5 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
                <button type="button" @click="activeModal = null"
                        class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold text-sm transition">
                    Fermer la fiche
                </button>
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('contact.index') }}" class="btn-primary">
                        <i data-lucide="send" class="w-4 h-4"></i> Demander un devis
                    </a>
                    @php($pdfBase = str_replace('/ID/pdf', '', route('legumineuses.pdf', ['legume' => 'ID'])))
                    <a :href="activeModal ? ('{{ $pdfBase }}/' + activeModal.id + '/pdf') : '#'" target="_blank" rel="noopener"
                       class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-800 text-white hover:bg-emerald-900 font-semibold text-sm transition shadow-sm">
                        <svg class="w-5 h-5 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Télécharger la Fiche Technique (PDF)
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
