@extends('layouts.admin')

@section('title', 'Campagnes & Chiffres')
@section('page-title', 'Campagnes & Chiffres')

@section('content')

    {{-- ==================== CAMPAIGN ANALYTICS ==================== --}}
    @if(count($analytics['labels']) > 0)
        <div class="mb-8">
            <div class="mb-4">
                <h2 class="font-display text-lg font-bold text-ink">Évolution &amp; Analyse Comparative des Campagnes</h2>
                <p class="text-sm text-slate-500 mt-0.5">Production collectée par culture, superficies et taux de certification — toutes campagnes confondues.</p>
            </div>

            <div class="grid xl:grid-cols-2 gap-6">
                {{-- Chart 1: Production par culture --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                    <h3 class="font-display text-base font-bold text-ink mb-1">Production Collectée par Culture (Quintaux)</h3>
                    <p class="text-xs text-slate-400 mb-4">Blé dur, blé tendre, orge et légumineuses — comparaison campagne par campagne.</p>
                    <div class="relative" style="height: 360px;">
                        <canvas id="prodChart"></canvas>
                    </div>
                </div>

                {{-- Chart 2: Superficies & certification --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                    <h3 class="font-display text-base font-bold text-ink mb-1">Superficies (Hectares) &amp; Taux de Certification (%)</h3>
                    <p class="text-xs text-slate-400 mb-4">Superficie totale semée (axe gauche) et part des semences certifiées (axe droit).</p>
                    <div class="relative" style="height: 360px;">
                        <canvas id="areaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-6">

        {{-- Campaign list --}}
        <div class="lg:col-span-2 card overflow-hidden">
            <div class="px-6 pt-6 pb-4">
                <h2 class="font-display text-lg font-bold text-ink">Toutes les campagnes</h2>
                <p class="text-sm text-slate-500 mt-0.5">{{ $years->count() }} campagne(s) enregistrée(s) — cliquez sur une campagne pour éditer ses statistiques.</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-y border-emerald-100 text-left">
                            <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Campagne</th>
                            <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Statistiques</th>
                            <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Statut</th>
                            <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-emerald-100">
                        @forelse($years as $y)
                            <tr class="hover:bg-slate-50 transition {{ $y->is_active ? 'bg-emerald-50/40' : '' }}">
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.campagnes.edit', $y) }}" class="font-bold text-ink hover:text-forest-700 transition">{{ $y->name }}</a>
                                    @if($y->notes)
                                        <p class="text-xs text-slate-400 mt-0.5 max-w-[240px] truncate">{{ $y->notes }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-slate-600">
                                    @if($y->annual_stats_count > 0)
                                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-forest-700">
                                            <i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i> Renseignées
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-600">
                                            <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> À compléter
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($y->is_active)
                                        <span class="badge bg-emerald-50 border border-emerald-200 text-forest-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-forest-600 animate-pulse"></span> Active
                                        </span>
                                    @else
                                        <span class="badge bg-slate-50 border border-slate-200 text-slate-500">Archivée</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('admin.campagnes.edit', $y) }}"
                                           class="p-2 rounded-lg text-forest-700 hover:bg-emerald-50 transition" title="Modifier les statistiques">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.campagnes.toggle', $y) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="p-2 rounded-lg {{ $y->is_active ? 'text-amber-600 hover:bg-amber-50' : 'text-forest-700 hover:bg-emerald-50' }} transition"
                                                    title="{{ $y->is_active ? 'Désactiver (archiver)' : 'Définir comme campagne active' }}">
                                                <i data-lucide="{{ $y->is_active ? 'pause-circle' : 'play-circle' }}" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                        <button type="button"
                                                @click="$dispatch('confirm-delete', { url: '{{ route('admin.campagnes.destroy', $y) }}', label: '{{ $y->name }}' })"
                                                class="p-2 rounded-lg text-red-600 hover:bg-red-50 transition" title="Supprimer">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-slate-400 text-sm">Aucune campagne enregistrée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Create form --}}
        <div class="card p-6 h-fit">
            <h2 class="font-display text-lg font-bold text-ink mb-1">Nouvelle campagne</h2>
            <p class="text-sm text-slate-500 mb-5">Ajoutez une année de campagne (ex. 2026-2027), puis renseignez ses statistiques.</p>

            <form method="POST" action="{{ route('admin.campagnes.store') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Libellé *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="2026-2027" required maxlength="20"
                               class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
                        @error('name')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="harvest_year" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Année de récolte *</label>
                        <input type="number" name="harvest_year" id="harvest_year" min="1950" max="2100" value="{{ old('harvest_year', now()->year) }}" required
                               class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
                        @error('harvest_year')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="notes" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Notes</label>
                        <textarea name="notes" id="notes" rows="2" maxlength="500" placeholder="Facultatif"
                                  class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">{{ old('notes') }}</textarea>
                        @error('notes')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" @checked(old('is_active')) class="w-4 h-4 rounded border-emerald-300 text-forest-600 focus:ring-forest-600/30">
                        <span class="text-sm font-semibold text-slate-600">Définir comme campagne active</span>
                    </label>
                    <p class="text-xs text-slate-400">Un seul onglet « Active » à la fois — les autres passeront en archivé.</p>
                </div>
                <button type="submit" class="btn-primary w-full justify-center py-3 mt-5">
                    <i data-lucide="plus" class="w-4 h-4"></i> Créer la campagne
                </button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <script>
        (function () {
            if (typeof Chart === 'undefined') return;

            var data = @json($analytics);
            if (!data.labels.length) return;

            Chart.defaults.font.family = "'Inter', sans-serif";
            Chart.defaults.color = '#64748B';

            var fmt = function (n) { return new Intl.NumberFormat('fr-FR').format(n); };

            var prodEl = document.getElementById('prodChart');
            if (prodEl) {
                new Chart(prodEl, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [
                            { label: 'Blé Dur',        data: data.durum,    backgroundColor: '#047857', borderRadius: 6, maxBarThickness: 48 },
                            { label: 'Blé Tendre',     data: data.soft,     backgroundColor: '#10b981', borderRadius: 6, maxBarThickness: 48 },
                            { label: 'Orge',           data: data.barley,   backgroundColor: '#f59e0b', borderRadius: 6, maxBarThickness: 48 },
                            { label: 'Légumineuses',   data: data.pulses,   backgroundColor: '#06b6d4', borderRadius: 6, maxBarThickness: 48 },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        plugins: {
                            legend: { position: 'bottom', labels: { usePointStyle: true, boxHeight: 8, padding: 16 } },
                            tooltip: { callbacks: { label: function (ctx) { return ' ' + ctx.dataset.label + ' : ' + fmt(ctx.parsed.y) + ' QX'; } } },
                        },
                        scales: {
                            x: { grid: { display: false } },
                            y: { beginAtZero: true, ticks: { callback: function (v) { return fmt(v); } }, title: { display: true, text: 'Quintaux (QX)' } },
                        },
                    },
                });
            }

            var areaEl = document.getElementById('areaChart');
            if (areaEl) {
                new Chart(areaEl, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [
                            {
                                label: 'Superficie totale (Ha)',
                                data: data.hectares,
                                borderColor: '#f59e0b',
                                backgroundColor: 'rgba(245, 158, 11, 0.12)',
                                fill: true,
                                tension: 0.35,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                pointBackgroundColor: '#f59e0b',
                                yAxisID: 'y',
                            },
                            {
                                label: 'Taux de certification (%)',
                                data: data.cert,
                                borderColor: '#047857',
                                backgroundColor: '#047857',
                                fill: false,
                                tension: 0.35,
                                pointRadius: 5,
                                pointHoverRadius: 8,
                                pointStyle: 'rectRot',
                                yAxisID: 'y1',
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        plugins: {
                            legend: { position: 'bottom', labels: { usePointStyle: true, padding: 16 } },
                            tooltip: { callbacks: { label: function (ctx) {
                                return ctx.datasetIndex === 0
                                    ? ' Superficie : ' + fmt(ctx.parsed.y) + ' Ha'
                                    : ' Certification : ' + (ctx.parsed.y === null ? '—' : ctx.parsed.y.toFixed(1) + ' %');
                            } } },
                        },
                        scales: {
                            x: { grid: { display: false } },
                            y: {
                                beginAtZero: true, position: 'left',
                                title: { display: true, text: 'Hectares (Ha)' },
                                ticks: { callback: function (v) { return fmt(v); } },
                            },
                            y1: {
                                beginAtZero: true, max: 100, position: 'right',
                                grid: { drawOnChartArea: false },
                                title: { display: true, text: 'Taux cert. (%)' },
                                ticks: { callback: function (v) { return v + ' %'; } },
                            },
                        },
                    },
                });
            }
        })();
    </script>
@endpush
