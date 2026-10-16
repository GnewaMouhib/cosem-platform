@extends('layouts.app')

@section('title', 'Mentions Légales — COSEM')

@section('content')

    {{-- Header --}}
    <section class="page-header">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14 lg:py-16">
            <div class="section-eyebrow">
                <i data-lucide="scale" class="w-4 h-4"></i>
                Informations légales
            </div>
            <h1 class="section-title mb-4">Mentions <span class="text-gradient">Légales</span></h1>
            <p class="text-slate-500 max-w-2xl">
                Éditeur du site, hébergement, propriété intellectuelle et responsabilité.
            </p>
        </div>
    </section>

    <section class="py-12 lg:py-16">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 space-y-8">

            <div class="card p-6 lg:p-8 animate-fade-in-up">
                <h2 class="font-display text-xl font-bold text-ink mb-3 inline-flex items-center gap-2">
                    <i data-lucide="building-2" class="w-5 h-5 text-forest-600"></i>
                    Éditeur du site
                </h2>
                <dl class="space-y-2 text-sm text-slate-600">
                    <div class="flex flex-wrap gap-x-2">
                        <dt class="font-semibold text-ink min-w-[11rem]">Dénomination sociale</dt>
                        <dd>COSEM — Société Coopérative Centrale des Semences</dd>
                    </div>
                    <div class="flex flex-wrap gap-x-2">
                        <dt class="font-semibold text-ink min-w-[11rem]">Siège social</dt>
                        <dd>Avenue de la Liberté, Tunis, Tunisie</dd>
                    </div>
                    <div class="flex flex-wrap gap-x-2">
                        <dt class="font-semibold text-ink min-w-[11rem]">Téléphone</dt>
                        <dd><a href="tel:+21671747000" class="hover:text-forest-600 transition">+216 71 747 000</a></dd>
                    </div>
                    <div class="flex flex-wrap gap-x-2">
                        <dt class="font-semibold text-ink min-w-[11rem]">Email</dt>
                        <dd><a href="mailto:contact@cosem.tn" class="hover:text-forest-600 transition">contact@cosem.tn</a></dd>
                    </div>
                    <div class="flex flex-wrap gap-x-2">
                        <dt class="font-semibold text-ink min-w-[11rem]">Horaires d'ouverture</dt>
                        <dd>Lundi au vendredi, 08h00 – 16h30</dd>
                    </div>
                </dl>
            </div>

            <div class="card p-6 lg:p-8 animate-fade-in-up">
                <h2 class="font-display text-xl font-bold text-ink mb-3 inline-flex items-center gap-2">
                    <i data-lucide="globe" class="w-5 h-5 text-forest-600"></i>
                    Hébergement du site
                </h2>
                <p class="text-sm text-slate-600">
                    Le nom et l'adresse de l'hébergeur sont communiqués sur demande écrite adressée à
                    <a href="mailto:contact@cosem.tn" class="text-forest-600 hover:underline">contact@cosem.tn</a>,
                    conformément à la réglementation tunisienne applicable à l'hébergement de sites.
                </p>
            </div>

            <div class="card p-6 lg:p-8 animate-fade-in-up">
                <h2 class="font-display text-xl font-bold text-ink mb-3 inline-flex items-center gap-2">
                    <i data-lucide="copyright" class="w-5 h-5 text-forest-600"></i>
                    Propriété intellectuelle
                </h2>
                <p class="text-sm text-slate-600">
                    L'ensemble des contenus présents sur ce site (textes, fiches techniques, illustrations,
                    bases de données, marques et logos) est la propriété exclusive de COSEM. Toute
                    reproduction, représentation ou diffusion, totale ou partielle, sans autorisation
                    écrite préalable, est interdite.
                </p>
                <p class="text-sm text-slate-600 mt-3">
                    Les informations agronomiques publiées (normes INGC, catalogue variétal, itinéraires
                    techniques) sont fournies à titre indicatif. Pour toute application au champ, se
                    référer aux normes officielles en vigueur et auprès du service technique de COSEM.
                </p>
            </div>

            <div class="card p-6 lg:p-8 animate-fade-in-up">
                <h2 class="font-display text-xl font-bold text-ink mb-3 inline-flex items-center gap-2">
                    <i data-lucide="shield-check" class="w-5 h-5 text-forest-600"></i>
                    Responsabilité
                </h2>
                <p class="text-sm text-slate-600">
                    COSEM met tout en œuvre pour assurer l'exactitude et la mise à jour des informations
                    diffusées sur ce site. Toutefois, COSEM ne peut être tenue responsable des damages
                    directs ou indirects résultant de l'accès au site, de son utilisation ou de
                    l'indisponibilité temporaire d'un service.
                </p>
            </div>

            <div class="card p-6 lg:p-8 animate-fade-in-up">
                <h2 class="font-display text-xl font-bold text-ink mb-3 inline-flex items-center gap-2">
                    <i data-lucide="link" class="w-5 h-5 text-forest-600"></i>
                    Liens externes
                </h2>
                <p class="text-sm text-slate-600">
                    Ce site peut contenir des liens vers des ressources tierces. COSEM n'exerce aucun
                    contrôle sur ces sites et décline toute responsabilité quant à leur contenu.
                </p>
            </div>

            <p class="text-xs text-slate-400">
                Dernière mise à jour : {{ \Illuminate\Support\Str::ucfirst(now()->locale('fr')->isoFormat('MMMM YYYY')) }}.
            </p>

        </div>
    </section>

@endsection