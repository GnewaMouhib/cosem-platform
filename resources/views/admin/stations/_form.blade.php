@php
    $station = $station ?? null;
@endphp

<div class="grid lg:grid-cols-2 gap-5">
    <div class="lg:col-span-2">
        <label for="name" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Nom du site *</label>
        <input type="text" name="name" id="name" value="{{ old('name', $station?->name) }}" required
               class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
        @error('name')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="type" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Type *</label>
        <select name="type" id="type" required
                class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
            @foreach($types as $key => $label)
                <option value="{{ $key }}" @selected(old('type', $station?->type) === $key)>{{ $label }}</option>
            @endforeach
        </select>
        @error('type')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="city" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Ville *</label>
        <input type="text" name="city" id="city" value="{{ old('city', $station?->city) }}" required
               class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
        @error('city')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="governorate" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Gouvernorat *</label>
        <input type="text" name="governorate" id="governorate" value="{{ old('governorate', $station?->governorate) }}" required
               class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
        @error('governorate')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="installation_year" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Année d'installation</label>
        <input type="number" name="installation_year" id="installation_year" min="1900" max="2100" value="{{ old('installation_year', $station?->installation_year) }}"
               class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
        @error('installation_year')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="capacity" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Capacité (QX)</label>
        <input type="number" name="capacity" id="capacity" min="0" value="{{ old('capacity', $station?->capacity) }}"
               class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
        @error('capacity')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="surface" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Surface (m²)</label>
        <input type="number" name="surface" id="surface" min="0" value="{{ old('surface', $station?->surface) }}"
               class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
        @error('surface')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
    </div>

    <div class="lg:col-span-2">
        <label class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Localisation GPS — Sélecteur sur carte</label>

        {{-- Search bar --}}
        <div class="flex gap-2 mb-3">
            <input type="text" id="geo-search" placeholder="Rechercher une ville, région ou adresse en Tunisie..."
                   class="flex-1 px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
            <button type="button" id="geo-search-btn"
                    class="px-5 py-3 rounded-xl bg-forest-700 text-white text-sm font-bold hover:bg-forest-800 transition inline-flex items-center gap-2 shrink-0">
                <i data-lucide="search" class="w-4 h-4"></i> Rechercher
            </button>
        </div>
        <p id="geo-search-status" class="hidden mb-3 text-xs font-medium text-slate-400"></p>

        {{-- Mini map --}}
        <div id="station-map" class="rounded-2xl border border-emerald-200 overflow-hidden bg-slate-50"
             style="height: 320px; width: 100%; min-height: 320px;"></div>
        <p class="mt-2 text-xs text-slate-400">Cliquez directement sur la carte pour positionner la station ou déplacez le marqueur.</p>

        {{-- Confirmation badge + live readout --}}
        <div class="mt-3 flex flex-wrap items-center gap-4">
            <span id="geo-badge" class="hidden items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-50 border border-emerald-100 text-forest-700 text-xs font-bold">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Coordonnées capturées avec succès
            </span>
            <span class="text-xs text-slate-400">Lat : <span id="geo-lat" class="font-semibold text-ink">—</span> &nbsp;/&nbsp; Lon : <span id="geo-lon" class="font-semibold text-ink">—</span></span>
        </div>

        @error('latitude')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
        @error('longitude')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror

        <input type="hidden" name="latitude" id="station_lat" value="{{ old('latitude', $station?->latitude ?? 36.8080) }}">
        <input type="hidden" name="longitude" id="station_lon" value="{{ old('longitude', $station?->longitude ?? 10.0972) }}">
    </div>

    <div class="lg:col-span-2">
        <label for="description" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Description / lignes de conditionnement</label>
        <textarea name="description" id="description" rows="4"
                  class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">{{ old('description', $station?->description) }}</textarea>
        @error('description')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
    </div>

    <div class="lg:col-span-2">
        <label for="image" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Photographie de la station</label>
        <div class="flex items-start gap-5">
            <div class="shrink-0">
                @if($station?->image_path)
                    <img src="{{ asset($station->image_path) }}" alt="{{ $station->name }}"
                         class="w-28 h-20 rounded-xl object-cover border border-emerald-200" id="imagePreview"
                         onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=600&q=80';">
                @else
                    <div id="imagePreview" class="w-28 h-20 rounded-xl bg-slate-50 border border-dashed border-emerald-300 flex items-center justify-center">
                        <i data-lucide="image" class="w-6 h-6 text-slate-300"></i>
                    </div>
                @endif
            </div>
            <div class="flex-1">
                <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/webp"
                       class="block w-full text-sm text-slate-600 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-emerald-50 file:text-forest-700 hover:file:bg-emerald-100 cursor-pointer">
                <p class="mt-1.5 text-xs text-slate-400">JPG, PNG ou WebP — 10 Mo maximum. Laissez vide pour conserver l'image actuelle.</p>
                @error('image')<p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>
</div>

<div class="mt-8 flex items-center gap-3">
    <button type="submit" class="btn-primary py-3">
        <i data-lucide="save" class="w-4 h-4"></i>
        {{ $station ? 'Enregistrer les modifications' : 'Ajouter la station' }}
    </button>
    <a href="{{ route('admin.stations.index') }}" class="btn-outline py-3">Annuler</a>
</div>

@push('head')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script>
        (function () {
            var latInput = document.getElementById('station_lat');
            var lonInput = document.getElementById('station_lon');
            var mapEl = document.getElementById('station-map');
            if (!mapEl || !latInput || !lonInput || typeof L === 'undefined') return;

            var lat = parseFloat(latInput.value) || 36.8080;
            var lon = parseFloat(lonInput.value) || 10.0972;

            var map = L.map('station-map', { scrollWheelZoom: false }).setView([lat, lon], 11);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            var marker = L.marker([lat, lon], { draggable: true }).addTo(map);

            var badge = document.getElementById('geo-badge');
            var latOut = document.getElementById('geo-lat');
            var lonOut = document.getElementById('geo-lon');
            var badgeTimer = null;

            function syncOutputs() {
                var ll = marker.getLatLng();
                lat = ll.lat;
                lon = ll.lng;
                latInput.value = lat.toFixed(6);
                lonInput.value = lon.toFixed(6);
                if (latOut) latOut.textContent = lat.toFixed(6);
                if (lonOut) lonOut.textContent = lon.toFixed(6);
            }

            function showBadge() {
                if (!badge) return;
                badge.classList.remove('hidden');
                badge.classList.add('inline-flex');
                badge.style.transition = 'none';
                badge.style.opacity = '1';
                clearTimeout(badgeTimer);
                badgeTimer = setTimeout(function () {
                    badge.style.transition = 'opacity .4s';
                    badge.style.opacity = '0';
                    badgeTimer = setTimeout(function () {
                        badge.classList.add('hidden');
                        badge.classList.remove('inline-flex');
                        badge.style.transition = '';
                        badge.style.opacity = '';
                    }, 400);
                }, 2500);
            }

            function capture(withBadge) {
                syncOutputs();
                if (withBadge) showBadge();
            }

            marker.on('dragend', function () { capture(true); });
            map.on('click', function (e) {
                marker.setLatLng(e.latlng);
                capture(true);
            });

            syncOutputs();

            setTimeout(function () { map.invalidateSize(); }, 250);

            // ---- Nominatim geocoder (Tunisia only) ----
            var searchInput = document.getElementById('geo-search');
            var searchBtn = document.getElementById('geo-search-btn');
            var statusEl = document.getElementById('geo-search-status');

            function setStatus(msg, isError) {
                if (!statusEl) return;
                statusEl.textContent = msg;
                statusEl.classList.remove('hidden', 'text-red-600', 'text-slate-400');
                statusEl.classList.add(isError ? 'text-red-600' : 'text-slate-400');
            }

            function doSearch() {
                var q = (searchInput.value || '').trim();
                if (!q) return;
                setStatus('Recherche en cours…', false);
                fetch('https://nominatim.openstreetmap.org/search?format=json&countrycodes=tn&limit=1&q=' + encodeURIComponent(q))
                    .then(function (res) { if (!res.ok) throw new Error('HTTP ' + res.status); return res.json(); })
                    .then(function (results) {
                        if (!results.length) {
                            setStatus('Aucun résultat trouvé en Tunisie pour « ' + q + ' ».', true);
                            return;
                        }
                        var r = results[0];
                        var ll = [parseFloat(r.lat), parseFloat(r.lon)];
                        map.setView(ll, 13);
                        marker.setLatLng(ll);
                        capture(true);
                        setStatus('Résultat : ' + r.display_name, false);
                    })
                    .catch(function () {
                        setStatus('Service de géocodage indisponible. Réessayez dans un instant.', true);
                    });
            }

            if (searchBtn && searchInput) {
                searchBtn.addEventListener('click', doSearch);
                searchInput.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter') { e.preventDefault(); doSearch(); }
                });
            }
        })();
    </script>
@endpush
