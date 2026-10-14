@extends('layouts.app')

@section('title', 'Légumineuses — COSEM')

@section('content')
<div x-data="{
    activeModal: null,
    searchQuery: '',
    items: {{ json_encode($pulses->map(fn($p) => [
        'search' => mb_strtolower(trim($p->name.' '.($p->variety ?? '').' '.($p->optimal_cycle ?? '').' '.($p->yield_potential ?? '').' '.($p->description ?? ''))),
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
            <h1 class="section-title mb-4">Nos <span class="text-gradient">Légumineuses</span></h1>
            <p class="text-slate-500 max-w-2xl">
                Pois chiche, fève, lentille et haricot — cultures de diversification cultivées dans les zones
                céréalières tunisiennes. Cliquez sur une variété pour afficher sa fiche agronomique détaillée.
            </p>
        </div>
    </section>

    <section class="py-12 lg:py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Live search bar --}}
            <div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-8">
                <div class="relative flex-1 max-w-xl">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-4.5 h-4.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
                    </span>
                    <input type="search" x-model.live="searchQuery"
                           placeholder="Rechercher une légumineuse (Pois chiche, Fève, Lentille...)"
                           class="w-full pl-11 pr-11 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
                    <button type="button" x-show="searchQuery.length > 0" x-cloak @click="searchQuery = ''"
                            x-transition.opacity.duration.150ms
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-forest-700 transition" title="Effacer la recherche">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <p class="text-xs text-slate-400 font-semibold sm:ml-auto" x-text="matches.length + ' variété(s) affichée(s)'"></p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($pulses as $pulse)
                    @php
                        $haystack = mb_strtolower(trim($pulse->name.' '.($pulse->variety ?? '').' '.($pulse->optimal_cycle ?? '').' '.($pulse->yield_potential ?? '').' '.($pulse->description ?? '')));
                    @endphp
                    <button type="button"
                            x-show="searchQuery.trim() === '' || {{ json_encode($haystack) }}.includes(searchQuery.trim().toLowerCase())"
                            x-transition.opacity.duration.200ms
                            @click="activeModal = {{ json_encode([
                                'id' => $pulse->id,
                                'name' => $pulse->name,
                                'category' => 'Légumineuse',
                                'variety' => $pulse->variety ?? 'Sélection locale',
                                'cycle' => $pulse->optimal_cycle ?? 'Moyen',
                                'yield' => $pulse->yield_potential ?? 'Élevé',
                                'quality' => $pulse->grain_quality ?? 'Excellente',
                                'resistance' => $pulse->disease_resistance ?? 'Tolérant',
                                'zones' => $pulse->targeted_zone ?? 'Nord et Centre',
                            ]) }}"
                            class="card overflow-hidden p-5 card-hover text-left group">
                        <div class="-mx-5 -mt-5 mb-4 h-32 relative overflow-hidden bg-harvest-50">
                            <img src="{{ $pulse->image_path ? asset($pulse->image_path) : 'https://images.unsplash.com/photo-1515543237350-b3eea1ec8082?auto=format&fit=crop&w=800&q=80' }}"
                                 alt="{{ $pulse->name }}"
                                 loading="lazy"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                 onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1515543237350-b3eea1ec8082?auto=format&fit=crop&w=800&q=80';">
                            <span class="absolute top-3 left-3 badge bg-white/95 text-forest-700">
                                <i data-lucide="leaf" class="w-3 h-3 text-harvest-500"></i> Légumineuse
                            </span>
                        </div>
                        <h4 class="font-display text-lg font-bold text-ink group-hover:text-forest-700 transition">{{ $pulse->name }}</h4>
                        <p class="text-xs text-slate-400 mb-4">{{ $pulse->variety }}</p>
                        <div class="space-y-2 text-xs text-slate-500">
                            @if($pulse->optimal_cycle)
                                <div class="flex items-center gap-2"><i data-lucide="clock" class="w-3.5 h-3.5 text-forest-600 shrink-0"></i>Cycle : {{ $pulse->optimal_cycle }}</div>
                            @endif
                            @if($pulse->yield_potential)
                                <div class="flex items-center gap-2"><i data-lucide="trending-up" class="w-3.5 h-3.5 text-harvest-500 shrink-0"></i>Rendement : {{ $pulse->yield_potential }}</div>
                            @endif
                        </div>
                        <span class="mt-4 inline-flex items-center gap-1.5 text-xs font-bold text-forest-600">
                            Voir la fiche <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform"></i>
                        </span>
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

    <!-- Single Global Modal for Légumineuses -->
    <div x-show="activeModal !== null"
         x-cloak
         style="display: none;"
         @keydown.escape.window="activeModal = null"
         class="fixed inset-0 z-[999999] flex items-center justify-center p-4 sm:p-6 overflow-y-auto">

        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/75 backdrop-blur-md transition-opacity"
             @click="activeModal = null"></div>

        <!-- Modal Card Content -->
        <div class="relative z-10 w-full max-w-2xl bg-white rounded-3xl shadow-2xl border border-slate-100 p-6 sm:p-8 text-slate-800 my-auto"
             @click.outside="activeModal = null">

            <!-- Header with Close Button -->
            <div class="flex items-start justify-between pb-4 border-b border-slate-100">
                <div>
                    <span class="inline-block px-3 py-1 bg-amber-100 text-amber-800 text-xs font-semibold rounded-full uppercase tracking-wider mb-2" x-text="activeModal?.category"></span>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-emerald-950" x-text="activeModal?.name"></h3>
                    <p class="text-sm text-slate-400 mt-1" x-text="activeModal?.variety"></p>
                </div>
                <button type="button" @click="activeModal = null" aria-label="Fermer" class="text-slate-400 hover:text-slate-700 bg-slate-100 hover:bg-slate-200 p-2 rounded-full transition shrink-0 ml-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Details Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 my-6">
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                    <span class="text-xs uppercase text-slate-400 font-bold block mb-1">Cycle Optimal</span>
                    <span class="text-base font-semibold text-slate-800" x-text="activeModal?.cycle"></span>
                </div>
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                    <span class="text-xs uppercase text-slate-400 font-bold block mb-1">Potentiel de Rendement</span>
                    <span class="text-base font-semibold text-slate-800" x-text="activeModal?.yield"></span>
                </div>
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                    <span class="text-xs uppercase text-slate-400 font-bold block mb-1">Qualité de Grain</span>
                    <span class="text-base font-semibold text-slate-800" x-text="activeModal?.quality"></span>
                </div>
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                    <span class="text-xs uppercase text-slate-400 font-bold block mb-1">Résistance aux Maladies</span>
                    <span class="text-base font-semibold text-slate-800" x-text="activeModal?.resistance"></span>
                </div>
            </div>

            <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-100 text-emerald-900 text-sm">
                <strong class="font-bold">Zones recommandées : </strong>
                <span x-text="activeModal?.zones"></span>
            </div>

            <div class="flex flex-wrap justify-end gap-3 mt-6">
                <a :href="'/legumineuses/' + activeModal.id + '/pdf'" target="_blank" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-800 text-white hover:bg-emerald-900 font-semibold text-sm transition shadow-sm">
                    <svg class="w-5 h-5 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Télécharger la Fiche Technique (PDF)
                </a>
                <a href="{{ route('contact.index') }}" class="btn-primary">
                    <i data-lucide="send" class="w-4 h-4"></i> Demander un devis
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
