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
                ['label' => 'Maladies référencées', 'value' => $diseaseCount, 'sub' => 'Guide phytosanitaire', 'icon' => 'bug', 'color' => 'bg-red-50 text-red-700 border-red-100', 'route' => 'admin.maladies.index'],
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
                <h2 class="font-display text-lg font-bold text-ink">Campagne en cours</h2>
                @if($activeYear)
                    <span class="badge bg-emerald-50 border border-emerald-200 text-forest-700">
                        <i data-lucide="calendar-check" class="w-3.5 h-3.5"></i>
                        {{ $activeYear->name }}
                    </span>
                @endif
            </div>
            @if($stats)
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @foreach([
                        ['Blé dur', $stats->durum_wheat_qx],
                        ['Blé tendre', $stats->soft_wheat_qx],
                        ['Orge', $stats->barley_qx],
                        ['Légumineuses', $stats->pulses_qx],
                    ] as [$label, $value])
                        <div class="rounded-2xl bg-slate-50 border border-emerald-100 p-4">
                            <p class="text-xs font-semibold text-slate-500">{{ $label }}</p>
                            <p class="font-display text-xl font-bold text-ink mt-0.5">{{ number_format((float) $value, 0, ',', ' ') }} <span class="text-xs font-sans font-semibold text-slate-400">QX</span></p>
                        </div>
                    @endforeach
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mt-4">
                    <div class="rounded-2xl bg-slate-50 border border-emerald-100 p-4">
                        <p class="text-xs font-semibold text-slate-500">Superficie totale</p>
                        <p class="font-display text-xl font-bold text-ink mt-0.5">{{ number_format((float) $stats->total_hectares, 0, ',', ' ') }} <span class="text-xs font-sans font-semibold text-slate-400">Ha</span></p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 border border-emerald-100 p-4">
                        <p class="text-xs font-semibold text-slate-500">Multiplicateurs</p>
                        <p class="font-display text-xl font-bold text-ink mt-0.5">{{ $stats->total_multipliers }}</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 border border-emerald-100 p-4">
                        <p class="text-xs font-semibold text-slate-500">Semences certifiées</p>
                        <p class="font-display text-xl font-bold text-ink mt-0.5">{{ rtrim(rtrim(number_format((float) $stats->certified_seed_pct, 1, ',', ' '), '0'), ',') }} %</p>
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
                    <i data-lucide="plus-circle" class="w-4.5 h-4.5 text-forest-600"></i> Ajouter une variété céréalière
                </a>
                <a href="{{ route('admin.legumineuses.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl border border-emerald-100 hover:bg-emerald-50 transition text-sm font-semibold text-slate-700">
                    <i data-lucide="plus-circle" class="w-4.5 h-4.5 text-harvest-600"></i> Ajouter une légumineuse
                </a>
                <a href="{{ route('admin.stations.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl border border-emerald-100 hover:bg-emerald-50 transition text-sm font-semibold text-slate-700">
                    <i data-lucide="plus-circle" class="w-4.5 h-4.5 text-forest-600"></i> Ajouter une station
                </a>
                <a href="{{ route('admin.maladies.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl border border-emerald-100 hover:bg-emerald-50 transition text-sm font-semibold text-slate-700">
                    <i data-lucide="plus-circle" class="w-4.5 h-4.5 text-forest-600"></i> Ajouter une maladie
                </a>
                <a href="{{ route('admin.campagnes.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl border border-emerald-100 hover:bg-emerald-50 transition text-sm font-semibold text-slate-700">
                    <i data-lucide="pencil" class="w-4.5 h-4.5 text-harvest-600"></i> Modifier les chiffres de campagne
                </a>
                <a href="{{ route('admin.messages.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl border border-emerald-100 hover:bg-emerald-50 transition text-sm font-semibold text-slate-700">
                    <i data-lucide="inbox" class="w-4.5 h-4.5 text-harvest-600"></i> Consulter les messages
                </a>
            </div>
        </div>
    </div>

    {{-- Campaign analytics preview --}}
    @if(count($analytics['labels']) > 0)
        <div class="card p-6 mb-8">
            <div class="flex items-center justify-between mb-1">
                <h2 class="font-display text-lg font-bold text-ink">Évolution &amp; Analyse Comparative des Campagnes</h2>
                <a href="{{ route('admin.campagnes.index') }}" class="text-sm font-semibold text-forest-700 hover:text-forest-800 transition">Analyse complète →</a>
            </div>
            <p class="text-xs text-slate-400 mb-4">Production collectée par culture (QX) — aperçu comparatif toutes campagnes.</p>
            <div class="relative" style="height: 300px;">
                <canvas id="dashProdChart"></canvas>
            </div>
        </div>
    @endif

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

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <script>
        (function () {
            if (typeof Chart === 'undefined') return;

            var data = @json($analytics);
            var el = document.getElementById('dashProdChart');
            if (!el || !data.labels.length) return;

            Chart.defaults.font.family = "'Inter', sans-serif";
            Chart.defaults.color = '#64748B';

            var fmt = function (n) { return new Intl.NumberFormat('fr-FR').format(n); };

            new Chart(el, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [
                        { label: 'Blé Dur',      data: data.durum,  backgroundColor: '#047857', borderRadius: 5, maxBarThickness: 40 },
                        { label: 'Blé Tendre',   data: data.soft,   backgroundColor: '#10b981', borderRadius: 5, maxBarThickness: 40 },
                        { label: 'Orge',         data: data.barley, backgroundColor: '#f59e0b', borderRadius: 5, maxBarThickness: 40 },
                        { label: 'Légumineuses', data: data.pulses, backgroundColor: '#06b6d4', borderRadius: 5, maxBarThickness: 40 },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { position: 'bottom', labels: { usePointStyle: true, boxHeight: 8, padding: 14 } },
                        tooltip: { callbacks: { label: function (ctx) { return ' ' + ctx.dataset.label + ' : ' + fmt(ctx.parsed.y) + ' QX'; } } },
                    },
                    scales: {
                        x: { grid: { display: false } },
                        y: { beginAtZero: true, ticks: { callback: function (v) { return fmt(v); } } },
                    },
                },
            });
        })();
    </script>
@endpush
