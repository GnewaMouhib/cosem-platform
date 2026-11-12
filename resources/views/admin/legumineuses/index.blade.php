@extends('layouts.admin')

@section('title', 'Légumineuses')
@section('page-title', 'Légumineuses')

@section('content')
    <div class="flex items-center justify-between gap-4 mb-6">
        <p class="text-sm text-slate-500">{{ $pulses->count() }} légumineuse(s) enregistrée(s)</p>
        <a href="{{ route('admin.legumineuses.create') }}" class="btn-primary py-2.5">
            <i data-lucide="plus" class="w-4 h-4"></i> Nouvelle légumineuse
        </a>
    </div>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-emerald-100 text-left">
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Nom</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Variété</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Cycle optimal</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Rendement</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Description</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-emerald-100">
                    @forelse($pulses as $pulse)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    @if($pulse->image_path)
                                        <img src="{{ asset($pulse->image_path) }}" alt="{{ $pulse->name }}" class="w-9 h-9 rounded-lg object-cover border border-emerald-100"
                                             onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1515543237350-b3eea1ec8082?auto=format&fit=crop&w=200&q=80';">
                                    @else
                                        <span class="w-9 h-9 rounded-lg bg-yellow-50 border border-yellow-100 flex items-center justify-center">
                                            <i data-lucide="leaf" class="w-4 h-4 text-harvest-500"></i>
                                        </span>
                                    @endif
                                    <p class="font-bold text-ink">{{ $pulse->name }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-slate-600">{{ $pulse->variety ?? '—' }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $pulse->optimal_cycle ?? '—' }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $pulse->yield_potential ?? '—' }}</td>
                            <td class="px-5 py-4 text-slate-500 max-w-xs truncate">{{ \Illuminate\Support\Str::limit($pulse->description ?? '', 60) }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.legumineuses.edit', $pulse) }}"
                                       class="p-2 rounded-lg text-forest-700 hover:bg-emerald-50 transition" title="Modifier">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <button type="button"
                                            @click="$dispatch('confirm-delete', { url: '{{ route('admin.legumineuses.destroy', $pulse) }}', label: '{{ $pulse->name }}' })"
                                            class="p-2 rounded-lg text-red-600 hover:bg-red-50 transition" title="Supprimer">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-slate-400 text-sm">Aucune légumineuse enregistrée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
