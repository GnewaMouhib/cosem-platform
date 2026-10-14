@extends('layouts.admin')

@section('title', 'Campagne '.$year->name)
@section('page-title', 'Campagne '.$year->name)

@section('content')
    <div class="flex items-center justify-between gap-4 mb-6">
        <a href="{{ route('admin.campagnes.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-forest-700 hover:text-forest-800 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Toutes les campagnes
        </a>
        <span class="badge {{ $year->is_active ? 'bg-emerald-50 border border-emerald-200 text-forest-700' : 'bg-slate-50 border border-slate-200 text-slate-500' }}">
            @if($year->is_active)
                <span class="w-1.5 h-1.5 rounded-full bg-forest-600 animate-pulse"></span> Campagne active
            @else
                <i data-lucide="archive" class="w-3.5 h-3.5"></i> Archivée
            @endif
        </span>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 card p-6 sm:p-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="font-display text-lg font-bold text-ink">Chiffres de la campagne {{ $year->name }}</h2>
                    <p class="text-sm text-slate-500 mt-0.5">Récolte campagne {{ $year->harvest_year }}</p>
                </div>
            </div>

            @if($year->notes)
                <p class="text-sm text-slate-500 mb-6 rounded-2xl bg-slate-50 border border-emerald-100 px-4 py-3">{{ $year->notes }}</p>
            @endif

            <form method="POST" action="{{ route('admin.campagnes.update', $year) }}">
                @csrf
                @method('PUT')

                <p class="text-xs font-bold uppercase tracking-wider text-forest-700 mb-3">Récoltes en quintaux (QX)</p>
                <div class="grid sm:grid-cols-2 gap-5 mb-6">
                    @foreach([
                        'durum_wheat_qx' => 'Blé dur (QX)',
                        'soft_wheat_qx' => 'Blé tendre (QX)',
                        'barley_qx' => 'Orge (QX)',
                        'pulses_qx' => 'Légumineuses (QX)',
                    ] as $field => $label)
                        <div>
                            <label for="{{ $field }}" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">{{ $label }} *</label>
                            <input type="number" step="0.01" min="0" name="{{ $field }}" id="{{ $field }}" required
                                   value="{{ old($field, $stats?->{$field}) }}"
                                   class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
                            @error($field)<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
                        </div>
                    @endforeach
                </div>

                <p class="text-xs font-bold uppercase tracking-wider text-forest-700 mb-3">Volumes & multiplicateurs</p>
                <div class="grid sm:grid-cols-3 gap-5 mb-6">
                    <div>
                        <label for="total_hectares" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Superficie totale (Ha) *</label>
                        <input type="number" step="0.01" min="0" name="total_hectares" id="total_hectares" required
                               value="{{ old('total_hectares', $stats?->total_hectares) }}"
                               class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
                        @error('total_hectares')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="total_multipliers" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Multiplicateurs total *</label>
                        <input type="number" min="0" name="total_multipliers" id="total_multipliers" required
                               value="{{ old('total_multipliers', $stats?->total_multipliers) }}"
                               class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
                        @error('total_multipliers')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="member_multipliers" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Multiplicateurs membres</label>
                        <input type="number" min="0" name="member_multipliers" id="member_multipliers"
                               value="{{ old('member_multipliers', $stats?->member_multipliers) }}"
                               class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
                        @error('member_multipliers')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <p class="text-xs font-bold uppercase tracking-wider text-forest-700 mb-3">Qualité & financement</p>
                <div class="grid sm:grid-cols-3 gap-5 mb-8">
                    <div>
                        <label for="certified_seed_pct" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Semences certifiées (%)</label>
                        <input type="number" step="0.01" min="0" max="100" name="certified_seed_pct" id="certified_seed_pct"
                               value="{{ old('certified_seed_pct', $stats?->certified_seed_pct) }}"
                               class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
                        @error('certified_seed_pct')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="prebasic_seed_pct" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Semences prébasiques (%)</label>
                        <input type="number" step="0.01" min="0" max="100" name="prebasic_seed_pct" id="prebasic_seed_pct"
                               value="{{ old('prebasic_seed_pct', $stats?->prebasic_seed_pct) }}"
                               class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
                        @error('prebasic_seed_pct')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="financing_partner" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Partenaire de financement</label>
                        <input type="text" name="financing_partner" id="financing_partner"
                               value="{{ old('financing_partner', $stats?->financing_partner) }}"
                               class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
                        @error('financing_partner')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit" class="btn-primary py-3">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Enregistrer les statistiques
                    </button>
                </div>
            </form>
        </div>

        <div class="card p-6 h-fit">
            <h2 class="font-display text-lg font-bold text-ink mb-4">Autres campagnes</h2>
            <ul class="space-y-2.5">
                @foreach(\App\Models\Year::orderByDesc('harvest_year')->get() as $y)
                    <li class="flex items-center justify-between rounded-xl border border-emerald-100 px-4 py-3 {{ $y->id === $year->id ? 'bg-emerald-50' : '' }}">
                        <a href="{{ route('admin.campagnes.edit', $y) }}"
                           class="text-sm font-semibold {{ $y->id === $year->id ? 'text-forest-700' : 'text-slate-600 hover:text-forest-700' }} transition">{{ $y->name }}</a>
                        @if($y->is_active)
                            <span class="badge bg-emerald-50 border border-emerald-200 text-forest-700">Active</span>
                        @else
                            <span class="badge bg-slate-50 border border-slate-200 text-slate-500">Archivée</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
