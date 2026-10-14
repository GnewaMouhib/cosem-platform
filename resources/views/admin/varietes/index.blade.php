@extends('layouts.admin')

@section('title', 'Céréales')
@section('page-title', 'Céréales')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <p class="text-sm text-slate-500">{{ $cereals->count() }} variété(s) céréalière(s)</p>
        <div class="flex flex-wrap gap-2">
            @php
                $tabs = [
                    'tous' => 'Toutes',
                    'ble_dur' => 'Blé Dur',
                    'ble_tendre' => 'Blé Tendre',
                    'orge' => 'Orge',
                    'triticale' => 'Triticale',
                ];
            @endphp
            @foreach($tabs as $key => $label)
                <a href="{{ route('admin.cereales.index', $key === 'tous' ? [] : ['categorie' => $key]) }}"
                   @class([
                       'px-4 py-2 rounded-xl text-sm font-semibold transition',
                       'bg-forest-700 text-white shadow-soft' => $filter === $key,
                       'bg-white border border-emerald-200 text-slate-600 hover:bg-emerald-50' => $filter !== $key,
                   ])>{{ $label }}</a>
            @endforeach
        </div>
        <a href="{{ route('admin.cereales.create') }}" class="btn-primary py-2.5">
            <i data-lucide="plus" class="w-4 h-4"></i> Nouvelle variété
        </a>
    </div>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-emerald-100 text-left">
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Variété</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Catégorie</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Obtenteur</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Cycle</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Rendement</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-emerald-100">
                    @forelse($cereals as $cereal)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    @if($cereal->image_path)
                                        <img src="{{ asset($cereal->image_path) }}" alt="{{ $cereal->name }}" class="w-9 h-9 rounded-lg object-cover border border-emerald-100">
                                    @else
                                        <span class="w-9 h-9 rounded-lg bg-emerald-50 border border-emerald-100 flex items-center justify-center">
                                            <i data-lucide="sprout" class="w-4 h-4 text-forest-600"></i>
                                        </span>
                                    @endif
                                    <div>
                                        <p class="font-bold text-ink">{{ $cereal->name }}</p>
                                        <p class="text-xs text-slate-400">{{ $cereal->type }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="badge bg-emerald-50 border border-emerald-200 text-forest-700">{{ $categories[$cereal->category] ?? $cereal->category }}</span>
                            </td>
                            <td class="px-5 py-4 text-slate-600">{{ $cereal->breeder ?? '—' }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $cereal->optimal_cycle ?? '—' }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $cereal->yield_potential ?? '—' }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.cereales.edit', $cereal) }}"
                                       class="p-2 rounded-lg text-forest-700 hover:bg-emerald-50 transition" title="Modifier">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <button type="button"
                                            @click="$dispatch('confirm-delete', { url: '{{ route('admin.cereales.destroy', $cereal) }}', label: '{{ $cereal->name }}' })"
                                            class="p-2 rounded-lg text-red-600 hover:bg-red-50 transition" title="Supprimer">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-slate-400 text-sm">Aucune variété dans cette catégorie.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
