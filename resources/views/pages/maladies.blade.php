@extends('layouts.app')

@section('title', 'Maladies des Céréales — Guide Phytosanitaire COSEM')

@section('content')
@php
    // Protocoles d'intervention INGC par maladie
    $protocols = [
        'Septoriose' => [
            'risk'       => 'Stade 2 nœuds jusqu\'au stade dernière feuille étalée (F1)',
            'conditions' => 'Pluies régulières, hygrométrie > 80 %, températures 15 °C – 20 °C',
            'threshold'  => 'Intervention dès le stade 2 nœuds en cas de pluies continues ou d\'humidité prolongée du feuillage.',
            'actives'    => ['Tébuconazole', 'Azoxystrobine + Difénoconazole', 'Époxiconazole + Fluxapyroxad'],
            'note'       => 'Vigilance accrue sur les variétés Karim, Khiar et Razzak.',
        ],
        'Rouille Brune' => [
            'risk'       => 'Reprises de croissance humides — automne et fin d\'hiver',
            'conditions' => 'Rosées prolongées, amplitudes thermiques faibles, densité élevée',
            'threshold'  => 'Dès l\'observation des premières pustules sur les feuilles F2/F3.',
            'actives'    => ['Association Triazole + Strobilurine (double action curative et préventive)'],
            'note'       => null,
        ],
        'Rouille Jaune' => [
            'risk'       => 'Reprises de croissance humides — automne et fin d\'hiver',
            'conditions' => 'Rosées prolongées, hygrométrie > 85 %, températures fraîches 10 °C – 15 °C',
            'threshold'  => 'Dès l\'observation des premières pustules sur les feuilles F2/F3.',
            'actives'    => ['Association Triazole + Strobilurine (double action curative et préventive)'],
            'note'       => null,
        ],
        'Oïdium' => [
            'risk'       => 'Végétation dense, temps doux et ombragé',
            'conditions' => 'Sur-fertilisation azotée précoce, peuplement serré, faible circulation de l\'air',
            'threshold'  => 'Traitement dès l\'apparition des premiers foyers (taches poudreuses blanches sur feuillage).',
            'actives'    => ['Soufre', 'Triazoles systémiques homologués'],
            'note'       => 'Facteurs de risque : végétation dense, sur-fertilisation azotée précoce et temps doux/ombragé.',
        ],
    ];

    $fongiques = $fongiques ?? $diseases->filter(fn ($d) => ! $d->isRavageur())->values();
    $ravageurs = $ravageurs ?? $diseases->filter(fn ($d) => $d->isRavageur())->values();

    $tabs = [
        'fongiques' => ['label' => 'Maladies fongiques', 'count' => $fongiques->count()],
        'ravageurs' => ['label' => 'Ravageurs', 'count' => $ravageurs->count()],
        'semences'  => ['label' => 'Traitement de semences', 'count' => null],
    ];
@endphp

    {{-- Header --}}
    <section class="page-header">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14 lg:py-16">
            <div class="section-eyebrow">
                <i data-lucide="shield-alert" class="w-4 h-4"></i>
                Protection des Cultures
            </div>
            <h1 class="section-title mb-4">Guide <span class="text-gradient">Phytosanitaire</span></h1>
            <p class="text-slate-500 max-w-2xl">
                Identification photographique, symptômes visibles au champ, protocoles d'intervention INGC
                et matières actives homologuées pour la protection des céréales en Tunisie.
            </p>

            <div class="flex flex-wrap gap-3 mt-6">
                <span class="badge bg-white border border-emerald-200 text-forest-700">
                    <i data-lucide="shield-alert" class="w-3.5 h-3.5"></i>
                    {{ $fongiques->count() }} maladies fongiques
                </span>
                <span class="badge bg-white border border-amber-200 text-amber-800">
                    <i data-lucide="bug" class="w-3.5 h-3.5"></i>
                    {{ $ravageurs->count() }} ravageurs référencés
                </span>
                <span class="badge bg-white border border-emerald-200 text-forest-700">
                    <i data-lucide="flask-conical" class="w-3.5 h-3.5"></i>
                    Protocoles INGC &amp; COSEM
                </span>
            </div>
        </div>
    </section>

    {{-- Guide body --}}
    <section class="py-12 lg:py-16"
             x-data="{ tab: 'fongiques', open: null }">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Filter tabs --}}
            <div class="flex flex-wrap gap-2.5 mb-10">
                @foreach($tabs as $key => $t)
                    <button type="button" @click="tab = '{{ $key }}'"
                            :class="tab === '{{ $key }}' ? 'bg-forest-700 text-white border-forest-700 shadow-soft' : 'bg-white text-slate-600 border-emerald-200 hover:border-emerald-300 hover:text-forest-700'"
                            class="px-5 py-2.5 rounded-xl text-sm font-bold border transition-all duration-200 inline-flex items-center gap-2">
                        {{ $t['label'] }}
                        @if($t['count'] !== null)
                            <span :class="tab === '{{ $key }}' ? 'bg-white/20 text-white' : 'bg-emerald-50 text-forest-700 border border-emerald-100'"
                                  class="min-w-[22px] h-[22px] px-1.5 rounded-full text-[11px] font-extrabold inline-flex items-center justify-center">
                                {{ $t['count'] }}
                            </span>
                        @else
                            <span :class="tab === '{{ $key }}' ? 'bg-white/20 text-white' : 'bg-amber-50 text-amber-700 border border-amber-100'"
                                  class="h-[22px] px-2 rounded-full text-[10px] font-extrabold inline-flex items-center justify-center">
                                COSEM
                            </span>
                        @endif
                    </button>
                @endforeach
            </div>

            {{-- Tab 1 : Maladies fongiques --}}
            <div x-show="tab === 'fongiques'" x-cloak>
                <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">

                    @foreach($fongiques as $index => $disease)
                        @php
                            $protocol = $protocols[$disease->name] ?? null;
                        @endphp
                        <article class="card overflow-hidden card-hover animate-fade-in-up flex flex-col"
                                 style="animation-delay: {{ $index * 0.06 }}s">

                            {{-- Documentary preview : field symptoms photograph --}}
                            <div class="relative h-44 bg-gradient-to-br from-emerald-100 via-lime-50 to-yellow-50 flex items-center justify-center overflow-hidden border-b border-emerald-100">
                                @if($disease->image_path)
                                    <img src="{{ asset($disease->image_path) }}" alt="Symptômes de {{ $disease->name }}"
                                         loading="lazy"
                                         class="absolute inset-0 w-full h-full object-cover"
                                         onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1574323347407-f5e1ad6d020b?auto=format&fit=crop&w=800&q=80';">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/45 via-black/5 to-transparent"></div>
                                @else
                                    <div class="absolute inset-0 grain-overlay opacity-30"></div>
                                    <div class="relative text-center px-6">
                                        <div class="w-16 h-16 rounded-full bg-white/80 border border-yellow-200 flex items-center justify-center mx-auto mb-3 shadow-soft">
                                            <i data-lucide="microscope" class="w-8 h-8 text-harvest-500"></i>
                                        </div>
                                        <p class="text-[11px] font-bold uppercase tracking-wider text-forest-700">Symptômes visibles au champ</p>
                                        <p class="text-[10px] text-slate-400 mt-0.5">Photographie documentaire à venir</p>
                                    </div>
                                @endif
                                <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
                                    @foreach(($disease->affected_crops ?? []) as $crop)
                                        <span class="badge bg-white/95 text-forest-700">{{ ucwords(str_replace('_', ' ', $crop)) }}</span>
                                    @endforeach
                                </div>
                                <div class="absolute bottom-3 right-3 flex flex-wrap gap-1.5 justify-end">
                                    @if($protocol)
                                        <span class="badge bg-emerald-600/95 text-white">
                                            <i data-lucide="shield-check" class="w-3 h-3"></i> Protocole INGC
                                        </span>
                                    @endif
                                    <span class="badge bg-red-100/95 text-red-600">
                                        <i data-lucide="alert-triangle" class="w-3 h-3"></i> Nuisible
                                    </span>
                                </div>
                            </div>

                            {{-- Identity --}}
                            <div class="p-5 pb-4">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-red-50 border border-red-100 flex items-center justify-center shrink-0">
                                        <i data-lucide="shield-alert" class="w-5 h-5 text-red-500"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <h2 class="font-display text-lg font-bold text-ink leading-tight">{{ $disease->name }}</h2>
                                        @if($disease->scientific_name)
                                            <p class="text-xs text-forest-600 italic font-medium">{{ $disease->scientific_name }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Expandable details --}}
                            <div class="px-5 pb-5 mt-auto">
                                <button @click="open = open === 'fon-{{ $index }}' ? null : 'fon-{{ $index }}'"
                                        class="w-full flex items-center justify-between gap-2 py-2.5 px-3.5 rounded-xl bg-slate-50 border border-emerald-100 hover:border-emerald-200 transition text-sm font-bold text-forest-700">
                                    <span x-text="open === 'fon-{{ $index }}' ? 'Masquer le détail' : 'Afficher les détails'">Afficher les détails</span>
                                    <span class="inline-block transition-transform duration-300" :class="open === 'fon-{{ $index }}' ? 'rotate-180' : ''">
                                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                    </span>
                                </button>

                                <div x-show="open === 'fon-{{ $index }}'" x-cloak
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 -translate-y-2"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100"
                                     x-transition:leave-end="opacity-0"
                                     class="pt-4 space-y-4"
                                     style="display: none">

                                    {{-- Symptoms --}}
                                    <div>
                                        <div class="flex items-center gap-2 mb-1.5">
                                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-amber-50 border border-amber-200 text-[10px] font-bold uppercase tracking-wider text-amber-700">
                                                <i data-lucide="eye" class="w-3 h-3"></i> Symptômes
                                            </span>
                                        </div>
                                        <p class="text-sm text-slate-500 leading-relaxed">{{ $disease->symptoms }}</p>
                                    </div>

                                    {{-- Risk period --}}
                                    @if($protocol)
                                        <div>
                                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-emerald-50 border border-emerald-200 text-[10px] font-bold uppercase tracking-wider text-emerald-700 mb-1.5">
                                                <i data-lucide="calendar-days" class="w-3 h-3"></i> Période de risque
                                            </span>
                                            <p class="text-sm text-slate-600 leading-relaxed font-medium">{{ $protocol['risk'] }}</p>
                                            <p class="text-xs text-slate-400 mt-1">Conditions favorables : {{ $protocol['conditions'] }}</p>
                                        </div>

                                        {{-- Intervention threshold --}}
                                        <div class="rounded-xl bg-red-50/70 border border-red-100 p-3.5">
                                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-white border border-red-200 text-[10px] font-bold uppercase tracking-wider text-red-600 mb-1.5">
                                                <i data-lucide="crosshair" class="w-3 h-3"></i> Seuil de traitement
                                            </span>
                                            <p class="text-sm text-slate-600 leading-relaxed">{{ $protocol['threshold'] }}</p>
                                        </div>

                                        {{-- Approved active substances --}}
                                        <div class="rounded-xl bg-sky-50/70 border border-sky-100 p-3.5">
                                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-white border border-sky-200 text-[10px] font-bold uppercase tracking-wider text-sky-700 mb-1.5">
                                                <i data-lucide="flask-conical" class="w-3 h-3"></i> Matières actives homologuées
                                            </span>
                                            <ul class="space-y-1 mt-1">
                                                @foreach($protocol['actives'] as $active)
                                                    <li class="text-sm text-slate-600 leading-relaxed flex items-start gap-2">
                                                        <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-sky-600 mt-0.5 shrink-0"></i>
                                                        <span>{{ $active }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        @if($protocol['note'])
                                            <div class="rounded-xl bg-forest-50 border border-emerald-100 p-3.5 flex items-start gap-2.5">
                                                <i data-lucide="shield-alert" class="w-4 h-4 text-forest-600 mt-0.5 shrink-0"></i>
                                                <p class="text-sm text-forest-800 leading-relaxed font-medium">{{ $protocol['note'] }}</p>
                                            </div>
                                        @endif
                                    @endif

                                    {{-- Vulnerable cereals --}}
                                    @if($disease->affected_crops)
                                        <div>
                                            <div class="flex items-center gap-2 mb-1.5">
                                                <i data-lucide="wheat" class="w-3.5 h-3.5 text-forest-600"></i>
                                                <span class="text-[10px] font-bold uppercase tracking-wider text-forest-600">Céréales sensibles</span>
                                            </div>
                                            <div class="flex flex-wrap gap-1.5">
                                                @foreach($disease->affected_crops as $crop)
                                                    <span class="badge bg-emerald-50 border border-emerald-100 text-forest-700">{{ ucwords(str_replace('_', ' ', $crop)) }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Cultural practices --}}
                                    <div>
                                        <div class="flex items-center gap-2 mb-1.5">
                                            <i data-lucide="leaf" class="w-3.5 h-3.5 text-forest-600"></i>
                                            <span class="text-[10px] font-bold uppercase tracking-wider text-forest-600">Pratiques culturelles préventives</span>
                                        </div>
                                        <p class="text-sm text-slate-500 leading-relaxed">{{ $disease->cultural_practices }}</p>
                                    </div>

                                    {{-- Chemical treatment (DB fallback) --}}
                                    <div class="rounded-xl bg-red-50/70 border border-red-100 p-3.5">
                                        <div class="flex items-center gap-2 mb-1.5">
                                            <i data-lucide="flask-conical" class="w-3.5 h-3.5 text-red-500"></i>
                                            <span class="text-[10px] font-bold uppercase tracking-wider text-red-500">Traitement chimique (référence)</span>
                                        </div>
                                        <p class="text-sm text-slate-600 leading-relaxed">{{ $disease->chemical_treatment }}</p>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

            {{-- Tab 2 : Ravageurs (3 fiches scientifiques complètes) --}}
            <div x-show="tab === 'ravageurs'" x-cloak>
                <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse($ravageurs as $index => $pest)
                        <article class="card overflow-hidden card-hover animate-fade-in-up flex flex-col"
                                 style="animation-delay: {{ $index * 0.08 }}s">

                            {{-- Documentary preview --}}
                            <div class="relative h-44 bg-gradient-to-br from-amber-100 via-orange-50 to-yellow-50 flex items-center justify-center overflow-hidden border-b border-amber-200">
                                @if($pest->image_path)
                                    <img src="{{ asset($pest->image_path) }}" alt="Symptômes de {{ $pest->name }}"
                                         loading="lazy"
                                         class="absolute inset-0 w-full h-full object-cover"
                                         onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1530595467537-0b5996c41f2d?auto=format&fit=crop&w=800&q=80';">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/45 via-black/5 to-transparent"></div>
                                @else
                                    <div class="absolute inset-0 grain-overlay opacity-30"></div>
                                    <div class="relative text-center px-6">
                                        <div class="w-16 h-16 rounded-full bg-white/85 border border-amber-300 flex items-center justify-center mx-auto mb-3 shadow-soft">
                                            <i data-lucide="bug" class="w-8 h-8 text-amber-600"></i>
                                        </div>
                                        <p class="text-[11px] font-bold uppercase tracking-wider text-amber-800">Ravageur des grandes cultures</p>
                                        <p class="text-[10px] text-amber-600/80 mt-0.5">Surveillance &amp; Seuil d'intervention</p>
                                    </div>
                                @endif
                                <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
                                    @if($pest->target_crops)
                                        @foreach(explode(',', $pest->target_crops) as $cropName)
                                            <span class="badge bg-white/95 text-amber-900 font-bold">{{ trim($cropName) }}</span>
                                        @endforeach
                                    @elseif($pest->affected_crops)
                                        @foreach($pest->affected_crops as $crop)
                                            <span class="badge bg-white/95 text-amber-900 font-bold">{{ ucwords(str_replace('_', ' ', $crop)) }}</span>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="absolute bottom-3 right-3 flex flex-wrap gap-1.5 justify-end">
                                    <span class="badge bg-amber-500/95 text-white font-bold">
                                        <i data-lucide="crosshair" class="w-3 h-3"></i> Lutte Intégrée
                                    </span>
                                    <span class="badge bg-red-100/95 text-red-700 font-bold">
                                        <i data-lucide="alert-triangle" class="w-3 h-3"></i> Ravageur
                                    </span>
                                </div>
                            </div>

                            {{-- Identity --}}
                            <div class="p-5 pb-4">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-200 flex items-center justify-center shrink-0">
                                        <i data-lucide="bug" class="w-5 h-5 text-amber-600"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <h2 class="font-display text-lg font-bold text-ink leading-tight">{{ $pest->name }}</h2>
                                        @if($pest->scientific_name)
                                            <p class="text-xs text-amber-700 italic font-medium">{{ $pest->scientific_name }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Expandable details --}}
                            <div class="px-5 pb-5 mt-auto">
                                <button @click="open = open === 'rav-{{ $index }}' ? null : 'rav-{{ $index }}'"
                                        class="w-full flex items-center justify-between gap-2 py-2.5 px-3.5 rounded-xl bg-amber-50/70 border border-amber-200 hover:border-amber-300 transition text-sm font-bold text-amber-800">
                                    <span x-text="open === 'rav-{{ $index }}' ? 'Masquer le détail' : 'Afficher les détails techniques'">Afficher les détails techniques</span>
                                    <span class="inline-block transition-transform duration-300" :class="open === 'rav-{{ $index }}' ? 'rotate-180' : ''">
                                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                    </span>
                                </button>

                                <div x-show="open === 'rav-{{ $index }}'" x-cloak
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 -translate-y-2"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100"
                                     x-transition:leave-end="opacity-0"
                                     class="pt-4 space-y-4"
                                     style="display: none">

                                    {{-- Period of risk / activity --}}
                                    @if($pest->period)
                                        <div class="rounded-xl bg-amber-50/80 border border-amber-200 p-3.5">
                                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-white border border-amber-200 text-[10px] font-bold uppercase tracking-wider text-amber-800 mb-1.5">
                                                <i data-lucide="calendar-days" class="w-3 h-3 text-amber-600"></i> Période à risque
                                            </span>
                                            <p class="text-sm text-amber-900 leading-relaxed font-semibold">{{ $pest->period }}</p>
                                        </div>
                                    @endif

                                    {{-- Symptoms --}}
                                    <div>
                                        <div class="flex items-center gap-2 mb-1.5">
                                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-red-50 border border-red-200 text-[10px] font-bold uppercase tracking-wider text-red-700">
                                                <i data-lucide="eye" class="w-3 h-3"></i> Symptômes visibles au champ
                                            </span>
                                        </div>
                                        <p class="text-sm text-slate-600 leading-relaxed">{{ $pest->symptoms }}</p>
                                    </div>

                                    {{-- Control methods / Thresholds --}}
                                    @if($pest->control_methods || $pest->chemical_treatment)
                                        <div class="rounded-xl bg-emerald-50/80 border border-emerald-200 p-3.5">
                                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-white border border-emerald-200 text-[10px] font-bold uppercase tracking-wider text-forest-700 mb-1.5">
                                                <i data-lucide="shield-check" class="w-3 h-3 text-forest-600"></i> Méthodes de lutte &amp; Seuils d'intervention
                                            </span>
                                            <p class="text-sm text-forest-900 leading-relaxed">{{ $pest->control_methods ?: $pest->chemical_treatment }}</p>
                                        </div>
                                    @endif

                                    {{-- Target crops --}}
                                    <div>
                                        <div class="flex items-center gap-2 mb-1.5">
                                            <i data-lucide="wheat" class="w-3.5 h-3.5 text-forest-600"></i>
                                            <span class="text-[10px] font-bold uppercase tracking-wider text-forest-600">Céréales cibles</span>
                                        </div>
                                        <div class="flex flex-wrap gap-1.5">
                                            @if($pest->target_crops)
                                                @foreach(explode(',', $pest->target_crops) as $cropName)
                                                    <span class="badge bg-emerald-50 border border-emerald-200 text-forest-700 font-semibold">{{ trim($cropName) }}</span>
                                                @endforeach
                                            @elseif($pest->affected_crops)
                                                @foreach($pest->affected_crops as $crop)
                                                    <span class="badge bg-emerald-50 border border-emerald-200 text-forest-700 font-semibold">{{ ucwords(str_replace('_', ' ', $crop)) }}</span>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Cultural practices / Prophylaxis --}}
                                    @if($pest->cultural_practices)
                                        <div>
                                            <div class="flex items-center gap-2 mb-1.5">
                                                <i data-lucide="leaf" class="w-3.5 h-3.5 text-forest-600"></i>
                                                <span class="text-[10px] font-bold uppercase tracking-wider text-forest-600">Pratiques agronomiques préventives</span>
                                            </div>
                                            <p class="text-sm text-slate-500 leading-relaxed">{{ $pest->cultural_practices }}</p>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="card p-12 text-center md:col-span-2 xl:col-span-3">
                            <p class="text-sm text-slate-400">Aucun ravageur répertorié actuellement.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Tab 3 : Traitement & Désinfection des Semences COSEM --}}
            <div x-show="tab === 'semences'" x-cloak>
                <div class="card overflow-hidden">
                    <div class="bg-gradient-to-br from-forest-700 to-forest-600 p-6 sm:p-8 text-white relative overflow-hidden">
                        <div class="absolute inset-0 grain-overlay opacity-20"></div>
                        <div class="relative flex flex-wrap items-start justify-between gap-4">
                            <div class="flex items-start gap-4">
                                <div class="w-14 h-14 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center shrink-0">
                                    <i data-lucide="shield-check" class="w-7 h-7 text-yellow-300"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider text-yellow-300 mb-1">Engagement institutionnel COSEM</p>
                                    <h2 class="font-display text-2xl font-extrabold">Traitement et Désinfection des Semences COSEM</h2>
                                    <p class="text-white/80 text-sm mt-2 max-w-2xl">
                                        Chaque lot de semences certifiées COSEM bénéficie d'une protection sanitaire intégrée,
                                        appliquée industriellement dans nos stations de traitement agréées.
                                    </p>
                                </div>
                            </div>
                            <span class="badge bg-yellow-300 text-forest-900 shrink-0">
                                <i data-lucide="badge-check" class="w-3.5 h-3.5"></i> Garantie officielle
                            </span>
                        </div>
                    </div>

                    <div class="p-6 sm:p-8 grid md:grid-cols-2 gap-6">
                        <div class="rounded-2xl bg-emerald-50 border border-emerald-100 p-5">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-white border border-emerald-200 text-[10px] font-bold uppercase tracking-wider text-emerald-700">
                                    <i data-lucide="shield" class="w-3 h-3"></i> Protection dès l'implantation
                                </span>
                            </div>
                            <p class="text-sm text-emerald-900 leading-relaxed">
                                <strong class="font-bold">Protection intégrée dès l'implantation</strong> contre le
                                <strong class="font-bold">Charbon nu</strong> (<em>Ustilago nuda</em>), la
                                <strong class="font-bold">Carie</strong> (<em>Tilletia caries</em>) et les
                                <strong class="font-bold">fontes de semis</strong> (Fusarium, Pythium).
                            </p>
                            <div class="flex flex-wrap gap-1.5 mt-4">
                                <span class="badge bg-white border border-emerald-200 text-emerald-800">Charbon nu — Ustilago nuda</span>
                                <span class="badge bg-white border border-emerald-200 text-emerald-800">Carie — Tilletia caries</span>
                                <span class="badge bg-white border border-emerald-200 text-emerald-800">Fontes de semis</span>
                            </div>
                        </div>

                        <div class="rounded-2xl bg-amber-50 border border-amber-100 p-5">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-white border border-amber-200 text-[10px] font-bold uppercase tracking-wider text-amber-700">
                                    <i data-lucide="factory" class="w-3 h-3"></i> Station de traitement industrielle
                                </span>
                            </div>
                            <p class="text-sm text-amber-900 leading-relaxed">
                                <strong class="font-bold">Formulation fongicide de haute adhérence</strong> appliquée
                                industriellement en station de traitement agréée —
                                <strong class="font-bold">Manouba</strong> &amp; <strong class="font-bold">Tébourba</strong> —
                                garantissant un enrobage homogène et une levée sécurisée.
                            </p>
                            <div class="flex flex-wrap gap-1.5 mt-4">
                                <span class="badge bg-white border border-amber-200 text-amber-800">
                                    <i data-lucide="map-pin" class="w-3 h-3"></i> Station de Manouba
                                </span>
                                <span class="badge bg-white border border-amber-200 text-amber-800">
                                    <i data-lucide="map-pin" class="w-3 h-3"></i> Station de Tébourba
                                </span>
                            </div>
                        </div>

                        <div class="md:col-span-2 rounded-2xl border border-emerald-100 bg-slate-50 p-5 flex items-start gap-3">
                            <i data-lucide="info" class="w-4 h-4 text-forest-600 mt-0.5 shrink-0"></i>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Note officielle : semences traitées et certifiées COSEM contre le Charbon et la Carie.
                                Toute réimplantation de semences non traitées expose la parcelle à des contaminations
                                telluriques difficiles à maîtriser en végétation. Utilisez exclusivement des semences
                                certifiées COSEM pour sécuriser votre campagne.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection
