@php
    $disease = $disease ?? null;
@endphp

<div class="grid lg:grid-cols-2 gap-5">
    <div>
        <label for="name" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Nom de la maladie *</label>
        <input type="text" name="name" id="name" value="{{ old('name', $disease?->name) }}" required
               class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
        @error('name')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="scientific_name" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Nom scientifique</label>
        <input type="text" name="scientific_name" id="scientific_name" value="{{ old('scientific_name', $disease?->scientific_name) }}" placeholder="Puccinia striiformis…"
               class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
        @error('scientific_name')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
    </div>

    <div class="lg:col-span-2">
        <span class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Céréales sensibles *</span>
        <div class="flex flex-wrap gap-3">
            @foreach($crops as $key => $label)
                <label class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-xl border border-emerald-200 bg-white cursor-pointer hover:bg-emerald-50 transition">
                    <input type="checkbox" name="affected_crops[]" value="{{ $key }}"
                           @checked(in_array($key, old('affected_crops', $disease?->affected_crops ?? [])))
                           class="w-4 h-4 rounded border-emerald-300 text-forest-700 focus:ring-forest-600/30">
                    <span class="text-sm font-semibold text-slate-700">{{ $label }}</span>
                </label>
            @endforeach
        </div>
        @error('affected_crops')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
    </div>

    <div class="lg:col-span-2">
        <label for="symptoms" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Symptômes visibles au champ</label>
        <textarea name="symptoms" id="symptoms" rows="3"
                  class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">{{ old('symptoms', $disease?->symptoms) }}</textarea>
        @error('symptoms')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="cultural_practices" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Pratiques culturelles préventives</label>
        <textarea name="cultural_practices" id="cultural_practices" rows="4"
                  class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">{{ old('cultural_practices', $disease?->cultural_practices) }}</textarea>
        @error('cultural_practices')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="chemical_treatment" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Traitement chimique</label>
        <textarea name="chemical_treatment" id="chemical_treatment" rows="4"
                  class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">{{ old('chemical_treatment', $disease?->chemical_treatment) }}</textarea>
        @error('chemical_treatment')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
    </div>

    <div class="lg:col-span-2">
        <label for="image" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Photo des symptômes (JPG, PNG, WebP — 10 Mo max)</label>
        <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/webp"
               class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:bg-emerald-50 file:text-forest-700 file:text-sm file:font-bold hover:file:bg-emerald-100">
        @error('image')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
        @if($disease?->image_path)
            <div class="mt-3 flex items-center gap-3">
                <img src="{{ asset($disease->image_path) }}" alt="{{ $disease->name }}" class="w-14 h-14 rounded-xl object-cover border border-emerald-100">
                <p class="text-xs text-slate-400">Image actuelle — importer un fichier pour la remplacer.</p>
            </div>
        @endif
    </div>
</div>

<div class="mt-8 flex items-center gap-3">
    <button type="submit" class="btn-primary py-3">
        <i data-lucide="save" class="w-4 h-4"></i>
        {{ $disease ? 'Enregistrer les modifications' : 'Ajouter la maladie' }}
    </button>
    <a href="{{ route('admin.maladies.index') }}" class="btn-outline py-3">Annuler</a>
</div>
