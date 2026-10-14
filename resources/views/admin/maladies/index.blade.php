@extends('layouts.admin')

@section('title', 'Guide Phytosanitaire')
@section('page-title', 'Guide Phytosanitaire')

@section('content')
    <div class="flex items-center justify-between gap-4 mb-6">
        <p class="text-sm text-slate-500">{{ $diseases->count() }} maladie(s) référencée(s)</p>
        <a href="{{ route('admin.maladies.create') }}" class="btn-primary py-2.5">
            <i data-lucide="plus" class="w-4 h-4"></i> Nouvelle maladie
        </a>
    </div>

    <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-5">
        @forelse($diseases as $disease)
            <div class="card p-5 flex flex-col">
                <div class="flex items-start justify-between gap-3 mb-3">
                    <div>
                        <h3 class="font-display text-base font-bold text-ink">{{ $disease->name }}</h3>
                        <p class="text-xs italic text-slate-400">{{ $disease->scientific_name ?? 'Nom scientifique non renseigné' }}</p>
                    </div>
                    @if($disease->image_path)
                        <img src="{{ asset($disease->image_path) }}" alt="{{ $disease->name }}" class="w-12 h-12 rounded-xl object-cover border border-emerald-100 shrink-0">
                    @else
                        <span class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center shrink-0">
                            <i data-lucide="bug" class="w-5 h-5 text-forest-600"></i>
                        </span>
                    @endif
                </div>

                <div class="flex flex-wrap gap-1.5 mb-4">
                    @foreach($disease->affected_crops ?? [] as $crop)
                        <span class="badge bg-slate-50 border border-slate-200 text-slate-600">{{ $crops[$crop] ?? $crop }}</span>
                    @endforeach
                </div>

                <p class="text-xs text-slate-500 line-clamp-3 mb-4 flex-1">{{ \Illuminate\Support\Str::limit($disease->symptoms, 140) }}</p>

                <div class="flex items-center gap-2 pt-3 border-t border-emerald-100">
                    <a href="{{ route('admin.maladies.edit', $disease) }}"
                       class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-emerald-200 text-sm font-semibold text-forest-700 hover:bg-emerald-50 transition">
                        <i data-lucide="pencil" class="w-4 h-4"></i> Modifier
                    </a>
                    <button type="button"
                            @click="$dispatch('confirm-delete', { url: '{{ route('admin.maladies.destroy', $disease) }}', label: '{{ $disease->name }}' })"
                            class="p-2.5 rounded-xl text-red-600 border border-red-100 hover:bg-red-50 transition" title="Supprimer">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
        @empty
            <div class="card p-10 text-center text-slate-400 text-sm md:col-span-2 xl:col-span-3">Aucune maladie référencée.</div>
        @endforelse
    </div>
@endsection
