@extends('layouts.admin')

@section('title', 'Stations & Dépôts')
@section('page-title', 'Stations & Dépôts')

@section('content')
    <div class="flex items-center justify-between gap-4 mb-6">
        <p class="text-sm text-slate-500">{{ $stations->count() }} site(s) enregistré(s)</p>
        <a href="{{ route('admin.stations.create') }}" class="btn-primary py-2.5">
            <i data-lucide="plus" class="w-4 h-4"></i> Nouvelle station
        </a>
    </div>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-emerald-100 text-left">
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Site</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Type</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Localisation</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Capacité / Surface</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Installation</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">GPS</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-emerald-100">
                    @forelse($stations as $station)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    @if($station->image_path)
                                        <img src="{{ asset($station->image_path) }}" alt="{{ $station->name }}" class="w-11 h-11 rounded-lg object-cover border border-emerald-100 shrink-0"
                                             onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=200&q=80';">
                                    @else
                                        <span class="w-11 h-11 rounded-lg bg-slate-50 border border-dashed border-emerald-200 flex items-center justify-center shrink-0">
                                            <i data-lucide="image" class="w-4 h-4 text-slate-300"></i>
                                        </span>
                                    @endif
                                    <span class="font-bold text-ink">{{ $station->name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="badge bg-emerald-50 border border-emerald-200 text-forest-700">{{ $types[$station->type] ?? $station->type }}</span>
                            </td>
                            <td class="px-5 py-4 text-slate-600">{{ $station->city }}, {{ $station->governorate }}</td>
                            <td class="px-5 py-4 text-slate-600">
                                @if($station->capacity) {{ number_format($station->capacity) }} QX @endif
                                @if($station->capacity && $station->surface) / @endif
                                @if($station->surface) {{ number_format($station->surface) }} m² @endif
                                @if(!$station->capacity && !$station->surface) — @endif
                            </td>
                            <td class="px-5 py-4 text-slate-600">{{ $station->installation_year ?? '—' }}</td>
                            <td class="px-5 py-4 text-xs text-slate-500">
                                @if($station->latitude && $station->longitude)
                                    {{ $station->latitude }}, {{ $station->longitude }}
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.stations.edit', $station) }}"
                                       class="p-2 rounded-lg text-forest-700 hover:bg-emerald-50 transition" title="Modifier">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <button type="button"
                                            @click="$dispatch('confirm-delete', { url: '{{ route('admin.stations.destroy', $station) }}', label: '{{ $station->name }}' })"
                                            class="p-2 rounded-lg text-red-600 hover:bg-red-50 transition" title="Supprimer">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-10 text-center text-slate-400 text-sm">Aucune station enregistrée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
