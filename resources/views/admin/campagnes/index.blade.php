@extends('layouts.admin')

@section('title', 'Campagnes & Chiffres')
@section('page-title', 'Campagnes & Chiffres')

@section('content')

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
