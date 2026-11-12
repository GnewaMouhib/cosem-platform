@extends('layouts.app')

@section('title', 'Stations & Dépôts — COSEM')

@section('content')

    {{-- Header --}}
    <section class="page-header">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14 lg:py-16">
            <div class="section-eyebrow">
                <i data-lucide="factory" class="w-4 h-4"></i>
                Réseau National
            </div>
            <h1 class="section-title mb-4">Nos <span class="text-gradient">Stations</span> &amp; Dépôts</h1>
            <p class="text-slate-500 max-w-2xl">
                Un maillage territorial au service des agriculteurs : stations de conditionnement,
                entrepôts de stockage et zones de multiplication répartis sur le territoire tunisien.
            </p>

            {{-- Summary chips --}}
            <div class="flex flex-wrap gap-3 mt-6">
                <span class="badge bg-white border border-emerald-200 text-forest-700">
                    <i data-lucide="factory" class="w-3.5 h-3.5"></i>
                    {{ $stations->where('type', 'conditioning_station')->count() }} station(s) de conditionnement
                </span>
                <span class="badge bg-white border border-emerald-200 text-forest-700">
                    <i data-lucide="warehouse" class="w-3.5 h-3.5"></i>
                    {{ $stations->where('type', 'warehouse')->count() }} dépôt(s) / entrepôt(s)
                </span>
                <span class="badge bg-harvest-50 border border-yellow-200 text-harvest-600">
                    <i data-lucide="package" class="w-3.5 h-3.5"></i>
                    {{ number_format($stations->sum('capacity')) }} QX de capacité cumulée
                </span>
            </div>
        </div>
    </section>

    {{-- Interactive Map + Weather --}}
    <section class="py-12 lg:py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Weather widget --}}
            <div x-data="weatherWidget()" class="bg-white rounded-2xl p-5 border border-emerald-100 shadow-sm mb-8">
                <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                    <h3 class="font-display text-lg font-bold text-ink inline-flex items-center gap-2">
                        🌦️ Météo Agricole en Direct
                    </h3>
                    <span class="badge bg-emerald-50 border border-emerald-100 text-forest-700">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-forest-600"></span>
                        </span>
                        <span x-text="zones[zone].label"></span>
                    </span>
                </div>

                {{-- Zone tabs --}}
                <div class="flex flex-wrap gap-2 mb-5">
                    <template x-for="(z, key) in zones" :key="key">
                        <button type="button" @click="select(key)"
                                :class="zone === key
                                    ? 'bg-forest-700 text-white border-forest-700'
                                    : 'bg-white text-forest-700 border-emerald-200 hover:border-forest-600'"
                                class="px-4 py-2 rounded-xl border text-sm font-semibold transition-colors duration-150"
                                x-text="z.label"></button>
                    </template>
                </div>

                {{-- Metrics --}}
                <div x-show="loading" class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-4">
                    <div class="rounded-xl bg-slate-50 border border-emerald-100 p-3.5 text-center text-xs text-slate-400 font-semibold sm:col-span-4">
                        Chargement des données météo…
                    </div>
                </div>

                <div x-show="!loading && error" class="rounded-xl bg-yellow-50 border border-yellow-200 p-4 text-sm text-harvest-700 font-semibold mb-4" x-text="error"></div>

                <div x-show="!loading && current" x-transition:opacity.duration.200ms class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-4">
                    <div class="rounded-xl bg-slate-50 border border-emerald-100 p-3.5 text-center">
                        <svg class="w-4 h-4 text-forest-600 mx-auto mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6a2 2 0 00-2-2H7a2 2 0 00-2 2v13a3 3 0 106 0zm0 0h.01M15 6a2 2 0 012-2h0a2 2 0 012 2v5a6 6 0 11-12 0V6z"/></svg>
                        <div class="font-bold text-ink text-sm" x-text="current ? current.temperature_2m.toFixed(1) + ' °C' : '—'"></div>
                        <div class="text-[9px] font-bold uppercase text-slate-400">Température</div>
                    </div>
                    <div class="rounded-xl bg-slate-50 border border-emerald-100 p-3.5 text-center">
                        <svg class="w-4 h-4 text-forest-600 mx-auto mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3s6 6.5 6 10.5a6 6 0 11-12 0C6 9.5 12 3 12 3z"/></svg>
                        <div class="font-bold text-ink text-sm" x-text="current ? Math.round(current.relative_humidity_2m) + ' %' : '—'"></div>
                        <div class="text-[9px] font-bold uppercase text-slate-400">Humidité relative</div>
                    </div>
                    <div class="rounded-xl bg-slate-50 border border-emerald-100 p-3.5 text-center">
                        <svg class="w-4 h-4 text-harvest-500 mx-auto mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.646.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <div class="font-bold text-ink text-sm" x-text="current ? Math.round(current.wind_speed_10m) + ' km/h' : '—'"></div>
                        <div class="text-[9px] font-bold uppercase text-slate-400">Vitesse du vent</div>
                    </div>
                    <div class="rounded-xl bg-slate-50 border border-emerald-100 p-3.5 text-center">
                        <svg class="w-4 h-4 text-forest-600 mx-auto mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 16.58A5 5 0 0018 7h-1.26A8 8 0 104 15.25"/></svg>
                        <div class="font-bold text-ink text-sm" x-text="current ? current.precipitation.toFixed(1) + ' mm' : '—'"></div>
                        <div class="text-[9px] font-bold uppercase text-slate-400">Précipitations</div>
                    </div>
                </div>

                {{-- Conseil agronomique --}}
                <div x-show="!loading && advice"
                     x-transition:opacity.duration.200ms
                     :class="advice && advice.tone === 'good' ? 'bg-emerald-50 border-emerald-100' : 'bg-yellow-50 border-yellow-200'"
                     class="rounded-xl border p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 mt-0.5 shrink-0"
                         :class="advice && advice.tone === 'good' ? 'text-forest-600' : 'text-harvest-500'"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider mb-0.5"
                             :class="advice && advice.tone === 'good' ? 'text-forest-700' : 'text-harvest-600'">Conseil Agronomique</div>
                        <p class="text-sm text-slate-700 font-medium" x-text="advice ? advice.text : ''"></p>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl overflow-hidden border border-emerald-100 shadow-soft" style="height: 520px; width: 100%; min-height: 520px;">
                <div id="cosemMap" class="h-full w-full rounded-2xl"></div>
            </div>
            <p class="text-xs text-slate-400 mt-3 text-center">Cliquez sur un marqueur pour rejoindre la fiche détaillée de la station.</p>
        </div>
    </section>

    {{-- Dedicated station cards --}}
    <section class="pb-16 lg:pb-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="space-y-8">
                {{-- Badge text is stored per station: two sites share the
                     'Station de Conditionnement' type yet carry different roles,
                     so the badge cannot be derived from type alone. --}}
                @php
                    $typeLabels = [
                        'conditioning_station' => 'Station de Conditionnement',
                        'storage_center' => 'Centre de Stockage',
                        'central_lab' => 'Laboratoire Central',
                        'specialized_station' => 'Station Spécialisée',
                        'regional_depot' => 'Dépôt Régional',
                        'warehouse' => 'Entrepôt / Dépôt',
                        'multiplication_zone' => 'Zone de Multiplication',
                    ];
                @endphp
                @foreach($stations as $station)
                    <article id="station-{{ $station->id }}" class="card overflow-hidden scroll-mt-24 animate-fade-in-up"
                             style="animation-delay: {{ $loop->index * 0.08 }}s">

                        <div class="grid lg:grid-cols-5 gap-0">

                            {{-- Photo --}}
                            <div class="lg:col-span-2 relative bg-gradient-to-br from-forest-700 via-forest-600 to-forest-500 min-h-[220px] lg:min-h-full flex items-center justify-center overflow-hidden">
                                <img src="{{ $station->image_path ? asset($station->image_path) : 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=1200&q=80' }}"
                                     alt="Photographie de {{ $station->name }}"
                                     loading="lazy"
                                     class="absolute inset-0 w-full h-full object-cover rounded-2xl"
                                     onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=1200&q=80';">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-black/20"></div>
                                <div class="absolute top-4 left-4 flex flex-col gap-2">
                                    <span class="badge bg-white/95 text-forest-700">
                                        {{ $station->badge ?? ($typeLabels[$station->type] ?? $station->type) }}
                                    </span>
                                    @if($station->installation_year)
                                        <span class="badge bg-yellow-300/95 text-forest-900">Depuis {{ $station->installation_year }}</span>
                                    @endif
                                </div>
                                <div class="absolute bottom-0 inset-x-0 h-16 bg-gradient-to-t from-black/20 to-transparent"></div>
                            </div>

                            {{-- Technical sheet --}}
                            <div class="lg:col-span-3 p-6 sm:p-8">
                                <div class="flex flex-wrap items-start justify-between gap-3 mb-4">
                                    <div>
                                        <span class="text-[10px] font-bold uppercase tracking-[0.15em] text-forest-600">Fiche technique</span>
                                        <h2 class="font-display text-2xl font-bold text-ink mt-1">{{ $station->name }}</h2>
                                        <p class="text-sm text-slate-400 mt-1 inline-flex items-center gap-1.5">
                                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-forest-600"></i>
                                            {{ $station->city }}, Gouvernorat de {{ $station->governorate }}
                                        </p>
                                    </div>
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ $station->latitude ?? '36.808100' }},{{ $station->longitude ?? '10.097200' }}"
                                       target="_blank" rel="noopener noreferrer"
                                       onclick="if (typeof cosemShowOnMap === 'function' && cosemShowOnMap(event, {{ $station->id }})) return false;"
                                       class="badge bg-emerald-50 border border-emerald-100 text-forest-700 hover:bg-forest-700 hover:text-white hover:border-forest-700 focus:ring-2 focus:ring-forest-600/40 transition cursor-pointer">
                                        <i data-lucide="navigation" class="w-3.5 h-3.5"></i> Sur la carte
                                    </a>
                                </div>

                                {{-- Key metrics --}}
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-5">
                                    @if($station->installation_year)
                                        <div class="rounded-xl bg-slate-50 border border-emerald-100 p-3.5 text-center">
                                            <i data-lucide="calendar-days" class="w-4 h-4 text-forest-600 mx-auto mb-1.5"></i>
                                            <div class="font-bold text-ink text-sm">{{ $station->installation_year }}</div>
                                            <div class="text-[9px] font-bold uppercase text-slate-400">Année d'installation</div>
                                        </div>
                                    @endif
                                    @if($station->capacity)
                                        <div class="rounded-xl bg-slate-50 border border-emerald-100 p-3.5 text-center">
                                            <i data-lucide="package" class="w-4 h-4 text-harvest-500 mx-auto mb-1.5"></i>
                                            <div class="font-bold text-ink text-sm">{{ number_format($station->capacity) }} QX</div>
                                            <div class="text-[9px] font-bold uppercase text-slate-400">Capacité de stockage</div>
                                        </div>
                                    @endif
                                    @if($station->surface)
                                        <div class="rounded-xl bg-slate-50 border border-emerald-100 p-3.5 text-center">
                                            <i data-lucide="ruler" class="w-4 h-4 text-harvest-500 mx-auto mb-1.5"></i>
                                            <div class="font-bold text-ink text-sm">{{ number_format($station->surface) }} m²</div>
                                            <div class="text-[9px] font-bold uppercase text-slate-400">Surface couverte</div>
                                        </div>
                                    @endif
                                    @if($station->latitude)
                                        <div class="rounded-xl bg-slate-50 border border-emerald-100 p-3.5 text-center">
                                            <i data-lucide="map" class="w-4 h-4 text-forest-600 mx-auto mb-1.5"></i>
                                            <div class="font-bold text-ink text-sm">{{ number_format((float)$station->latitude, 3) }}</div>
                                            <div class="text-[9px] font-bold uppercase text-slate-400">Latitude</div>
                                        </div>
                                    @endif
                                </div>

                                {{-- Full description / technical details --}}
                                <div class="border-t border-emerald-100 pt-4">
                                    <h3 class="text-xs font-bold uppercase tracking-wider text-forest-600 mb-2">Description technique complète</h3>
                                    <p class="text-sm text-slate-500 leading-relaxed">{{ $station->description }}</p>
                                </div>

                                {{-- Processing lines highlight (Manouba-specific data) --}}
                                @if($station->name === 'Siège & Complexe Industriel Principal - Manouba')
                                    <div class="mt-4 grid sm:grid-cols-3 gap-3">
                                        <div class="rounded-xl border border-emerald-100 p-3.5">
                                            <div class="font-display text-xl font-bold text-forest-700">1955</div>
                                            <div class="text-[10px] font-bold uppercase text-slate-400">Ligne historique</div>
                                        </div>
                                        <div class="rounded-xl border border-emerald-100 p-3.5">
                                            <div class="font-display text-xl font-bold text-forest-700">1984</div>
                                            <div class="text-[10px] font-bold uppercase text-slate-400">Ligne d'extension</div>
                                        </div>
                                        <div class="rounded-xl border border-yellow-200 bg-harvest-50 p-3.5">
                                            <div class="font-display text-xl font-bold text-harvest-600">{{ number_format($station->capacity) }} QX</div>
                                            <div class="text-[10px] font-bold uppercase text-slate-400">Stockage semences</div>
                                        </div>
                                    </div>
                                @endif
                                @if($station->name === 'Station de Conditionnement Tébourba 1')
                                    <div class="mt-4 rounded-xl border border-yellow-200 bg-harvest-50 p-4 flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-lg bg-harvest-400 flex items-center justify-center shrink-0">
                                            <i data-lucide="gauge" class="w-5 h-5 text-white"></i>
                                        </div>
                                        <div>
                                            <div class="font-display text-lg font-bold text-ink">Unité de triage 10 T/h</div>
                                            <div class="text-xs text-slate-500">Unité de conditionnement installée en {{ $station->installation_year }}.</div>
                                        </div>
                                    </div>
                                @endif

                                {{-- Coordinates --}}
                                @if($station->latitude && $station->longitude)
                                    <div class="mt-4 flex flex-wrap gap-4 text-xs text-slate-400">
                                        <span class="inline-flex items-center gap-1.5"><i data-lucide="crosshair" class="w-3.5 h-3.5 text-forest-600"></i> Lat {{ $station->latitude }} / Lng {{ $station->longitude }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
    function weatherWidget() {
        return {
            zone: 'manouba',
            loading: false,
            error: null,
            data: { manouba: null, tebourba: null },
            zones: {
                manouba: { label: 'Station Manouba', lat: 36.8081, lon: 10.0972 },
                tebourba: { label: 'Station Tébourba', lat: 36.8306, lon: 9.8458 },
            },

            init() {
                this.load('manouba');
                this.load('tebourba');
            },

            async load(key) {
                const z = this.zones[key];
                this.loading = true;
                this.error = null;
                try {
                    const url = 'https://api.open-meteo.com/v1/forecast'
                        + '?latitude=' + z.lat + '&longitude=' + z.lon
                        + '&current=temperature_2m,relative_humidity_2m,wind_speed_10m,precipitation'
                        + '&wind_speed_unit=kmh&timezone=Africa%2FTunis';
                    const res = await fetch(url);
                    if (!res.ok) throw new Error('HTTP ' + res.status);
                    const json = await res.json();
                    this.data[key] = json.current;
                } catch (e) {
                    this.error = 'Données météo indisponibles pour le moment. Réessayez dans quelques instants.';
                    this.data[key] = null;
                } finally {
                    this.loading = false;
                }
            },

            select(key) {
                this.zone = key;
                if (!this.data[key]) this.load(key);
            },

            get current() {
                return this.data[this.zone];
            },

            get advice() {
                if (!this.current) return null;
                const wind = this.current.wind_speed_10m;
                const rain = this.current.precipitation;
                if (rain > 1) {
                    return { tone: 'warn', text: 'Sols humides — Reporter les traitements phytosanitaires.' };
                }
                if (wind > 19) {
                    return { tone: 'warn', text: 'Vent soutenu — Éviter la pulvérisation pour limiter la dérive.' };
                }
                return { tone: 'good', text: 'Conditions idéales pour les travaux du sol / semis.' };
            },
        };
    }
</script>
@endpush

@push('scripts')
<script>
window.addEventListener('load', function () {
    const mapEl = document.getElementById('cosemMap');
    if (typeof L === 'undefined' || !mapEl) return;

    var map = L.map('cosemMap', { scrollWheelZoom: false }).setView([36.8, 10.1], 9);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    setTimeout(function () { map.invalidateSize(); }, 250);

    const stations = @json($stations);

    const makeIcon = (letter) => L.divIcon({
        className: '',
        html: `<div class="cosem-marker"><span>${letter}</span></div>`,
        iconSize: [36, 42],
        iconAnchor: [18, 40],
        popupAnchor: [2, -40]
    });

    const typeLabels = {
        'conditioning_station': 'Station de Conditionnement',
        'storage_center': 'Centre de Stockage',
        'central_lab': 'Laboratoire Central',
        'specialized_station': 'Station Spécialisée',
        'regional_depot': 'Dépôt Régional',
        'warehouse': 'Entrepôt / Dépôt',
        'multiplication_zone': 'Zone de Multiplication'
    };

    const markersById = {};

    stations.forEach(s => {
        if (!s.latitude || !s.longitude) return;
        const marker = L.marker([parseFloat(s.latitude), parseFloat(s.longitude)], { icon: makeIcon(s.name.charAt(0)) }).addTo(map);
        markersById[s.id] = marker;
        marker.bindPopup(`
            <div style="font-family:Inter,sans-serif;">
                <div style="background:linear-gradient(135deg,#14532D,#166534);padding:14px 16px;color:#fff;">
                    <div style="font-size:10px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:#EAB308;margin-bottom:4px;">
                        ${s.badge || typeLabels[s.type] || s.type}
                    </div>
                    <div style="font-family:'Playfair Display',serif;font-size:15px;font-weight:700;">${s.name}</div>
                </div>
                <div style="padding:12px 16px;background:#fff;">
                    <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:#64748B;margin-bottom:8px;">
                        ${s.city}, ${s.governorate}${s.installation_year ? ' · Depuis ' + s.installation_year : ''}
                    </div>
                    <a href="#station-${s.id}" onclick="setTimeout(() => { document.getElementById('station-${s.id}').scrollIntoView({behavior:'smooth', block:'start'}); map.closePopup(); }, 10); return true;"
                       style="display:inline-flex;align-items:center;gap:6px;background:#166534;color:#fff;font-size:12px;font-weight:700;padding:8px 14px;border-radius:9px;text-decoration:none;">
                        Voir la fiche technique →
                    </a>
                </div>
            </div>
        `, { maxWidth: 300 });
    });

    /* "Sur la carte" : smooth-scroll to the interactive map + open the station marker popup.
       Returns false to let the browser open the Google Maps fallback (no marker / no JS). */
    window.cosemShowOnMap = function (event, id) {
        const marker = markersById[id];
        if (!marker) return false;
        if (event) event.preventDefault();

        const mapEl = document.getElementById('cosemMap');
        if (mapEl) mapEl.scrollIntoView({ behavior: 'smooth', block: 'center' });

        setTimeout(function () {
            map.invalidateSize();
            map.setView(marker.getLatLng(), 14);
            marker.openPopup();
        }, 550);
        return true;
    };

    const valid = stations.filter(s => s.latitude && s.longitude);
    if (valid.length) {
        map.fitBounds(valid.map(s => [parseFloat(s.latitude), parseFloat(s.longitude)]), { padding: [40, 40] });
    }

    setTimeout(() => map.invalidateSize(), 300);
    if (location.hash && location.hash.startsWith('#station-')) {
        setTimeout(() => {
            const el = document.querySelector(location.hash);
            if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 400);
    }
});
</script>
@endpush
