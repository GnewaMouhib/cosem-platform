@extends('layouts.admin')

@section('title', 'Guide Phytosanitaire')
@section('page-title', 'Guide Phytosanitaire & Protection des Cultures')

@section('content')
    @php
        $ravageursCount = $diseases->filter(fn($d) => $d->isRavageur())->count();
        $maladiesCount = $diseases->filter(fn($d) => !$d->isRavageur())->count();
    @endphp

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6"
         x-data="{ filter: 'all' }">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="badge bg-emerald-50 text-forest-700 border border-emerald-100 font-bold">
                    {{ $maladiesCount }} maladies fongiques
                </span>
                <span class="badge bg-amber-50 text-amber-800 border border-amber-200 font-bold">
                    {{ $ravageursCount }} ravageurs
                </span>
            </div>
            <p class="text-xs text-slate-500">Gestion intégrée des bioagresseurs des céréales (symptômes, seuils et méthodes de lutte)</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.maladies.create') }}" class="btn-primary py-2.5">
                <i data-lucide="plus" class="w-4 h-4"></i> Nouvelle fiche (Maladie / Ravageur)
            </a>
        </div>
    </div>

    <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-5">
        @forelse($diseases as $disease)
            <div class="card p-5 flex flex-col {{ $disease->isRavageur() ? 'border-amber-200/80 bg-gradient-to-b from-white to-amber-50/20' : '' }}">
                <div class="flex items-start justify-between gap-3 mb-3">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            @if($disease->isRavageur())
                                <span class="badge bg-amber-100 text-amber-800 text-[10px] font-extrabold uppercase tracking-wider">
                                    <i data-lucide="bug" class="w-3 h-3"></i> Ravageur
                                </span>
                            @else
                                <span class="badge bg-emerald-100 text-forest-800 text-[10px] font-extrabold uppercase tracking-wider">
                                    <i data-lucide="shield-alert" class="w-3 h-3"></i> Maladie
                                </span>
                            @endif
                        </div>
                        <h3 class="font-display text-base font-bold text-ink">{{ $disease->name }}</h3>
                        <p class="text-xs italic text-slate-400">{{ $disease->scientific_name ?? 'Nom scientifique non renseigné' }}</p>
                    </div>
                    @if($disease->image_path)
                        <img src="{{ asset($disease->image_path) }}" alt="{{ $disease->name }}" class="w-12 h-12 rounded-xl object-cover border border-emerald-100 shrink-0"
                             onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1574323347407-f5e1ad6d020b?auto=format&fit=crop&w=200&q=80';">
                    @else
                        <span class="w-12 h-12 rounded-xl {{ $disease->isRavageur() ? 'bg-amber-50 border-amber-200 text-amber-600' : 'bg-emerald-50 border-emerald-100 text-forest-600' }} border flex items-center justify-center shrink-0">
                            <i data-lucide="bug" class="w-5 h-5"></i>
                        </span>
                    @endif
                </div>

                @if($disease->period)
                    <div class="mb-3 px-2.5 py-1.5 rounded-lg bg-slate-50 border border-slate-200/70 text-[11px] font-medium text-slate-600 flex items-center gap-1.5">
                        <i data-lucide="calendar" class="w-3 h-3 text-slate-400"></i>
                        <span>{{ $disease->period }}</span>
                    </div>
                @endif

                <div class="flex flex-wrap gap-1.5 mb-3">
                    @if($disease->target_crops)
                        @foreach(explode(',', $disease->target_crops) as $cropName)
                            <span class="badge bg-slate-50 border border-slate-200 text-slate-600">{{ trim($cropName) }}</span>
                        @endforeach
                    @else
                        @foreach($disease->affected_crops ?? [] as $crop)
                            <span class="badge bg-slate-50 border border-slate-200 text-slate-600">{{ $crops[$crop] ?? $crop }}</span>
                        @endforeach
                    @endif
                </div>

                <p class="text-xs text-slate-500 line-clamp-3 mb-4 flex-1">{{ \Illuminate\Support\Str::limit($disease->symptoms, 140) }}</p>

                <div class="flex items-center gap-2 pt-3 border-t border-slate-100">
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
            <div class="card p-10 text-center text-slate-400 text-sm md:col-span-2 xl:col-span-3">Aucune fiche phytosanitaire référencée.</div>
        @endforelse
    </div>
@endsection
