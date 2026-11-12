@php
    $cereal = $cereal ?? null;
@endphp

<div class="grid lg:grid-cols-2 gap-5">
    <div>
        <label for="name" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Nom de la variété *</label>
        <input type="text" name="name" id="name" value="{{ old('name', $cereal?->name) }}" required
               class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
        @error('name')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="category" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Catégorie *</label>
        <select name="category" id="category" required
                class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
            @foreach($categories as $key => $label)
                <option value="{{ $key }}" @selected(old('category', $cereal?->category) === $key)>{{ $label }}</option>
            @endforeach
        </select>
        @error('category')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="type" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Type</label>
        <input type="text" name="type" id="type" value="{{ old('type', $cereal?->type) }}" placeholder="Semoulier, Pain…"
               class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
        @error('type')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="breeder" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Obtenteur</label>
        <input type="text" name="breeder" id="breeder" value="{{ old('breeder', $cereal?->breeder) }}" placeholder="INRAT…"
               class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
        @error('breeder')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="optimal_cycle" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Cycle optimal</label>
        <input type="text" name="optimal_cycle" id="optimal_cycle" value="{{ old('optimal_cycle', $cereal?->optimal_cycle) }}" placeholder="Ex. 120-140 jours"
               class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
        @error('optimal_cycle')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="yield_potential" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Potentiel de rendement</label>
        <input type="text" name="yield_potential" id="yield_potential" value="{{ old('yield_potential', $cereal?->yield_potential) }}" placeholder="Ex. 35-45 qx/ha"
               class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
        @error('yield_potential')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="disease_resistance" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Résistance aux maladies</label>
        <input type="text" name="disease_resistance" id="disease_resistance" value="{{ old('disease_resistance', $cereal?->disease_resistance) }}"
               class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
        @error('disease_resistance')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="grain_quality" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Qualité du grain</label>
        <input type="text" name="grain_quality" id="grain_quality" value="{{ old('grain_quality', $cereal?->grain_quality) }}"
               class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
        @error('grain_quality')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="targeted_zone" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Zone ciblée</label>
        <input type="text" name="targeted_zone" id="targeted_zone" value="{{ old('targeted_zone', $cereal?->targeted_zone) }}"
               class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
        @error('targeted_zone')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="order_index" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Ordre d'affichage</label>
        <input type="number" name="order_index" id="order_index" min="0" value="{{ old('order_index', $cereal?->order_index ?? 0) }}"
               class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
        @error('order_index')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
    </div>

    <div class="lg:col-span-2">
        <label for="description" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Description</label>
        <textarea name="description" id="description" rows="3"
                  class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">{{ old('description', $cereal?->description) }}</textarea>
        @error('description')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="image" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Image (JPG, PNG, WebP — 10 Mo max)</label>
        <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/webp"
               class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:bg-emerald-50 file:text-forest-700 file:text-sm file:font-bold hover:file:bg-emerald-100">
        @error('image')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
        @if($cereal?->image_path)
            <div class="mt-3 flex items-center gap-3">
                <img src="{{ asset($cereal->image_path) }}" alt="{{ $cereal->name }}" class="w-14 h-14 rounded-xl object-cover border border-emerald-100"
                     onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1574323347407-f5e1ad6d020b?auto=format&fit=crop&w=200&q=80';">
                <p class="text-xs text-slate-400">Image actuelle — importer un fichier pour la remplacer.</p>
            </div>
        @endif
    </div>
</div>

<div class="mt-8 flex items-center gap-3">
    <button type="submit" class="btn-primary py-3">
        <i data-lucide="save" class="w-4 h-4"></i>
        {{ $cereal ? 'Enregistrer les modifications' : 'Ajouter la variété' }}
    </button>
    <a href="{{ route('admin.cereales.index') }}" class="btn-outline py-3">Annuler</a>
</div>
