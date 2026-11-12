@extends('layouts.admin')

@section('title', 'Tableau de Bord')
@section('page-title', 'Tableau de Bord')

@section('content')
    {{-- KPI cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-5 mb-8">
        @php
            $kpis = [
                ['label' => 'Céréales', 'value' => $cerealCount, 'sub' => 'Variétés certifiées', 'icon' => 'sprout', 'color' => 'bg-emerald-50 text-forest-700 border-emerald-100', 'route' => 'admin.cereales.index'],
                ['label' => 'Légumineuses', 'value' => $pulseCount, 'sub' => 'Pois chiche, fève, lentille…', 'icon' => 'leaf', 'color' => 'bg-amber-50 text-harvest-700 border-amber-100', 'route' => 'admin.legumineuses.index'],
                ['label' => 'Stations & dépôts', 'value' => $stationCount, 'sub' => 'Sites COSEM', 'icon' => 'warehouse', 'color' => 'bg-sky-50 text-sky-700 border-sky-100', 'route' => 'admin.stations.index'],
                ['label' => 'Guide Phyto', 'value' => $diseaseCount, 'sub' => 'Maladies & ravageurs', 'icon' => 'bug', 'color' => 'bg-red-50 text-red-700 border-red-100', 'route' => 'admin.maladies.index'],
                ['label' => 'Messages non lus', 'value' => $unreadCount, 'sub' => 'Boîte de réception', 'icon' => 'inbox', 'color' => 'bg-slate-50 text-slate-700 border-slate-200', 'route' => 'admin.messages.index'],
            ];
        @endphp
        @foreach($kpis as $kpi)
            <a href="{{ route($kpi['route']) }}" class="card card-hover p-5 flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">{{ $kpi['label'] }}</p>
                    <p class="font-display text-3xl font-bold text-ink mt-1">{{ $kpi['value'] }}</p>
                    <p class="text-xs text-slate-500 mt-1">{{ $kpi['sub'] }}</p>
                </div>
                <span class="w-11 h-11 rounded-2xl border flex items-center justify-center shrink-0 {{ $kpi['color'] }}">
                    <i data-lucide="{{ $kpi['icon'] }}" class="w-5 h-5"></i>
                </span>
            </a>
        @endforeach
    </div>

    {{-- Current campaign + quick actions --}}
    <div class="grid lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2 card p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="font-display text-lg font-bold text-ink">Campagne en cours</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Données affichées sur le site public pour la campagne active</p>
                </div>
                @if($activeYear)
                    <span class="badge bg-emerald-50 border border-emerald-200 text-forest-700">
                        <i data-lucide="calendar-check" class="w-3.5 h-3.5"></i>
                        {{ $activeYear->name }}
                    </span>
                @endif
            </div>
            @if($stats)
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3.5 mb-3.5">
                    <div class="rounded-2xl bg-emerald-50/70 border border-emerald-100 p-3.5">
                        <p class="text-[11px] font-bold uppercase text-forest-700">Blé dur</p>
                        <p class="font-display text-lg font-bold text-ink mt-0.5">{{ number_format((float) ($stats->durum_wheat_qx ?? 0), 0, ',', ' ') }} <span class="text-xs font-sans font-semibold text-slate-400">QX</span></p>
                    </div>
                    <div class="rounded-2xl bg-emerald-50/70 border border-emerald-100 p-3.5">
                        <p class="text-[11px] font-bold uppercase text-forest-700">Blé tendre</p>
                        <p class="font-display text-lg font-bold text-ink mt-0.5">{{ number_format((float) ($stats->soft_wheat_qx ?? 0), 0, ',', ' ') }} <span class="text-xs font-sans font-semibold text-slate-400">QX</span></p>
                    </div>
                    <div class="rounded-2xl bg-emerald-50/70 border border-emerald-100 p-3.5">
                        <p class="text-[11px] font-bold uppercase text-forest-700">Orge</p>
                        <p class="font-display text-lg font-bold text-ink mt-0.5">{{ number_format((float) ($stats->barley_qx ?? 0), 0, ',', ' ') }} <span class="text-xs font-sans font-semibold text-slate-400">QX</span></p>
                    </div>
                    <div class="rounded-2xl bg-emerald-50/70 border border-emerald-100 p-3.5">
                        <p class="text-[11px] font-bold uppercase text-forest-700">Avoine</p>
                        <p class="font-display text-lg font-bold text-ink mt-0.5">{{ number_format((float) ($stats->oats_qx ?? 0), 0, ',', ' ') }} <span class="text-xs font-sans font-semibold text-slate-400">QX</span></p>
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3.5 mb-4">
                    <div class="rounded-2xl bg-amber-50/70 border border-amber-100 p-3.5">
                        <p class="text-[11px] font-bold uppercase text-harvest-700">Fèves</p>
                        <p class="font-display text-lg font-bold text-ink mt-0.5">{{ number_format((float) ($stats->feves_qx ?? 0), 0, ',', ' ') }} <span class="text-xs font-sans font-semibold text-slate-400">QX</span></p>
                    </div>
                    <div class="rounded-2xl bg-amber-50/70 border border-amber-100 p-3.5">
                        <p class="text-[11px] font-bold uppercase text-harvest-700">Pois chiches</p>
                        <p class="font-display text-lg font-bold text-ink mt-0.5">{{ number_format((float) ($stats->pois_chiches_qx ?? 0), 0, ',', ' ') }} <span class="text-xs font-sans font-semibold text-slate-400">QX</span></p>
                    </div>
                    <div class="rounded-2xl bg-amber-50/70 border border-amber-100 p-3.5">
                        <p class="text-[11px] font-bold uppercase text-harvest-700">Féveroles</p>
                        <p class="font-display text-lg font-bold text-ink mt-0.5">{{ number_format((float) ($stats->feveroles_qx ?? 0), 0, ',', ' ') }} <span class="text-xs font-sans font-semibold text-slate-400">QX</span></p>
                    </div>
                    <div class="rounded-2xl bg-amber-50/70 border border-amber-100 p-3.5">
                        <p class="text-[11px] font-bold uppercase text-harvest-700">Lentilles</p>
                        <p class="font-display text-lg font-bold text-ink mt-0.5">{{ number_format((float) ($stats->lentilles_qx ?? 0), 0, ',', ' ') }} <span class="text-xs font-sans font-semibold text-slate-400">QX</span></p>
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 pt-3.5 border-t border-slate-100">
                    <div class="rounded-2xl bg-slate-50 border border-slate-200 p-3.5">
                        <p class="text-xs font-semibold text-slate-500">Superficie totale</p>
                        <p class="font-display text-xl font-bold text-ink mt-0.5">{{ number_format((float) $stats->total_hectares, 0, ',', ' ') }} <span class="text-xs font-sans font-semibold text-slate-400">Ha</span></p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 border border-slate-200 p-3.5">
                        <p class="text-xs font-semibold text-slate-500">Semences certifiées</p>
                        <p class="font-display text-xl font-bold text-ink mt-0.5">{{ rtrim(rtrim(number_format((float) $stats->certified_seed_pct, 1, ',', ' '), '0'), ',') }} %</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 border border-slate-200 p-3.5 col-span-2 sm:col-span-1">
                        <p class="text-xs font-semibold text-slate-500">Multiplicateurs</p>
                        <p class="font-display text-xl font-bold text-ink mt-0.5">{{ $stats->total_multipliers }}</p>
                    </div>
                </div>
            @else
                <p class="text-sm text-slate-500">Aucune statistique enregistrée pour la campagne active.</p>
            @endif
        </div>

        <div class="card p-6">
            <h2 class="font-display text-lg font-bold text-ink mb-4">Actions rapides</h2>
            <div class="space-y-2.5">
                <a href="{{ route('admin.cereales.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl border border-emerald-100 hover:bg-emerald-50 transition text-sm font-semibold text-slate-700">
                    <i data-lucide="plus-circle" class="w-4 h-4 text-forest-600"></i> Ajouter une variété céréalière
                </a>
                <a href="{{ route('admin.legumineuses.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl border border-emerald-100 hover:bg-emerald-50 transition text-sm font-semibold text-slate-700">
                    <i data-lucide="plus-circle" class="w-4 h-4 text-harvest-600"></i> Ajouter une légumineuse
                </a>
                <a href="{{ route('admin.stations.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl border border-emerald-100 hover:bg-emerald-50 transition text-sm font-semibold text-slate-700">
                    <i data-lucide="plus-circle" class="w-4 h-4 text-forest-600"></i> Ajouter une station
                </a>
                <a href="{{ route('admin.maladies.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl border border-emerald-100 hover:bg-emerald-50 transition text-sm font-semibold text-slate-700">
                    <i data-lucide="plus-circle" class="w-4 h-4 text-forest-600"></i> Ajouter une fiche (Maladie / Ravageur)
                </a>
                <a href="{{ route('admin.campagnes.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl border border-emerald-100 hover:bg-emerald-50 transition text-sm font-semibold text-slate-700">
                    <i data-lucide="pencil" class="w-4 h-4 text-harvest-600"></i> Modifier les chiffres de campagne
                </a>
                <a href="{{ route('admin.messages.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl border border-emerald-100 hover:bg-emerald-50 transition text-sm font-semibold text-slate-700">
                    <i data-lucide="inbox" class="w-4 h-4 text-harvest-600"></i> Consulter les messages
                </a>
            </div>
        </div>
    </div>

    {{-- Formulaire d'Administration Dynamique des Chiffres de Récolte --}}
    <div class="card p-6 sm:p-7 mb-8" x-data="{ currentCamp: {{ $activeYear->id ?? ($years->first()->id ?? 1) }} }">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-emerald-100">
            <div>
                <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-forest-700 mb-1">
                    <i data-lucide="sliders" class="w-4 h-4"></i> Configuration Dynamique
                </div>
                <h2 class="font-display text-lg font-bold text-ink">Chiffres de Récolte par Campagne (Accueil &amp; Donut Charts)</h2>
                <p class="text-xs text-slate-400 mt-0.5">Saisissez les quintaux Céréales &amp; Légumineuses, superficies et certification — les 2 Donuts et compteurs du site s'actualisent instantanément.</p>
            </div>
            {{-- Tabs de sélection de campagne --}}
            <div class="flex flex-wrap gap-2 shrink-0">
                @foreach($years as $y)
                    <button type="button" @click="currentCamp = {{ $y->id }}"
                            :class="currentCamp === {{ $y->id }}
                                ? 'bg-forest-700 text-white border-forest-700 shadow-sm'
                                : 'bg-white text-slate-600 border-emerald-200 hover:border-forest-600 hover:text-forest-700'"
                            class="px-3.5 py-1.5 rounded-xl text-xs font-bold border transition inline-flex items-center gap-1.5 cursor-pointer">
                        <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                        {{ $y->name }}
                        @if($y->is_active)
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        @endif
                    </button>
                @endforeach
            </div>
        </div>

        @foreach($years as $y)
            @php($yStats = $y->annualStats->first())
            <div x-show="currentCamp === {{ $y->id }}" x-cloak x-transition.opacity.duration.150ms>
                <form method="POST" action="{{ route('admin.campagnes.update', $y) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid lg:grid-cols-2 gap-6 mb-6">
                        {{-- Bloc 1 : Céréales (Blé Dur, Blé Tendre, Orge, Avoine) --}}
                        <div class="rounded-2xl p-5 bg-emerald-50/50 border border-emerald-100">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-forest-800 flex items-center gap-2">
                                    <i data-lucide="wheat" class="w-4 h-4 text-forest-600"></i>
                                    Donut 1 — Répartition Céréales (Quintaux QX)
                                </h3>
                                <span class="badge bg-emerald-100 text-forest-800 text-[10px]">4 cultures</span>
                            </div>
                            <div class="grid grid-cols-2 gap-3.5">
                                <div>
                                    <label class="block text-[11px] font-bold uppercase text-slate-600 mb-1.5">Blé Dur (QX) *</label>
                                    <input type="number" step="0.01" min="0" name="durum_wheat_qx" required
                                           value="{{ old('durum_wheat_qx', $yStats?->durum_wheat_qx ?? 215000) }}"
                                           class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-emerald-200 text-sm font-semibold text-ink focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold uppercase text-slate-600 mb-1.5">Blé Tendre (QX) *</label>
                                    <input type="number" step="0.01" min="0" name="soft_wheat_qx" required
                                           value="{{ old('soft_wheat_qx', $yStats?->soft_wheat_qx ?? 8000) }}"
                                           class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-emerald-200 text-sm font-semibold text-ink focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold uppercase text-slate-600 mb-1.5">Orge (QX) *</label>
                                    <input type="number" step="0.01" min="0" name="barley_qx" required
                                           value="{{ old('barley_qx', $yStats?->barley_qx ?? 7000) }}"
                                           class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-emerald-200 text-sm font-semibold text-ink focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold uppercase text-slate-600 mb-1.5">Avoine (QX) *</label>
                                    <input type="number" step="0.01" min="0" name="oats_qx" required
                                           value="{{ old('oats_qx', $yStats?->oats_qx ?? 3000) }}"
                                           class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-emerald-200 text-sm font-semibold text-ink focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
                                </div>
                            </div>
                        </div>

                        {{-- Bloc 2 : Légumineuses découpé par variété (Fèves, Pois chiches, Féveroles, Lentilles) --}}
                        <div class="rounded-2xl p-5 bg-amber-50/50 border border-amber-100">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-harvest-800 flex items-center gap-2">
                                    <i data-lucide="leaf" class="w-4 h-4 text-harvest-600"></i>
                                    Donut 2 — Répartition Légumineuses (Quintaux QX)
                                </h3>
                                <span class="badge bg-amber-100 text-harvest-800 text-[10px]">4 variétés</span>
                            </div>
                            <div class="grid grid-cols-2 gap-3.5">
                                <div>
                                    <label class="block text-[11px] font-bold uppercase text-slate-600 mb-1.5">Fèves (QX) *</label>
                                    <input type="number" step="0.01" min="0" name="feves_qx" required
                                           value="{{ old('feves_qx', $yStats?->feves_qx ?? 850) }}"
                                           class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-amber-200 text-sm font-semibold text-ink focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500 transition">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold uppercase text-slate-600 mb-1.5">Pois chiches (QX) *</label>
                                    <input type="number" step="0.01" min="0" name="pois_chiches_qx" required
                                           value="{{ old('pois_chiches_qx', $yStats?->pois_chiches_qx ?? 650) }}"
                                           class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-amber-200 text-sm font-semibold text-ink focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500 transition">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold uppercase text-slate-600 mb-1.5">Féveroles (QX) *</label>
                                    <input type="number" step="0.01" min="0" name="feveroles_qx" required
                                           value="{{ old('feveroles_qx', $yStats?->feveroles_qx ?? 350) }}"
                                           class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-amber-200 text-sm font-semibold text-ink focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500 transition">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold uppercase text-slate-600 mb-1.5">Lentilles (QX) *</label>
                                    <input type="number" step="0.01" min="0" name="lentilles_qx" required
                                           value="{{ old('lentilles_qx', $yStats?->lentilles_qx ?? 150) }}"
                                           class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-amber-200 text-sm font-semibold text-ink focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500 transition">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Bloc 3 : Superficie totale & Taux de certification --}}
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-200 mb-2">
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-slate-600 mb-1">Superficie totale semée (Ha) *</label>
                            <input type="number" step="0.01" min="0" name="total_hectares" required
                                   value="{{ old('total_hectares', $yStats?->total_hectares ?? 11000) }}"
                                   class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-slate-300 text-sm font-semibold text-ink focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-slate-600 mb-1">Taux de certification (%) *</label>
                            <input type="number" step="0.01" min="0" max="100" name="certified_seed_pct" required
                                   value="{{ old('certified_seed_pct', $yStats?->certified_seed_pct ?? 85) }}"
                                   class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-slate-300 text-sm font-semibold text-ink focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
                        </div>
                        <div class="sm:col-span-2 lg:col-span-1 flex items-end">
                            <button type="submit" class="btn-primary w-full justify-center py-2.5 shadow-sm">
                                <i data-lucide="save" class="w-4 h-4"></i> Enregistrer pour {{ $y->name }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        @endforeach
    </div>

    {{-- Latest messages --}}
    <div class="card p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-display text-lg font-bold text-ink">Derniers messages reçus</h2>
            <a href="{{ route('admin.messages.index') }}" class="text-sm font-semibold text-forest-700 hover:text-forest-800 transition">Tout voir →</a>
        </div>
        @if($latestMessages->isEmpty())
            <p class="text-sm text-slate-500">Aucun message pour le moment.</p>
        @else
            <div class="divide-y divide-emerald-100">
                @foreach($latestMessages as $message)
                    <a href="{{ route('admin.messages.show', $message) }}" class="flex items-center gap-4 py-3.5 hover:bg-slate-50 rounded-xl px-3 -mx-3 transition">
                        <span class="w-2 h-2 rounded-full shrink-0 {{ $message->is_read ? 'bg-slate-300' : 'bg-red-500' }}"></span>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm {{ $message->is_read ? 'text-slate-600' : 'font-bold text-ink' }} truncate">
                                {{ $message->full_name }} — <span class="font-medium">{{ $message->subject ?? 'Sans sujet' }}</span>
                            </p>
                            <p class="text-xs text-slate-400 truncate">{{ \Illuminate\Support\Str::limit($message->message, 90) }}</p>
                        </div>
                        <span class="text-xs text-slate-400 shrink-0">{{ $message->created_at->diffForHumans(short: true) }}</span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection
