@extends('layouts.app')

@section('title', 'Politique de Confidentialité — COSEM')

@section('content')

    {{-- Header --}}
    <section class="page-header">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14 lg:py-16">
            <div class="section-eyebrow">
                <i data-lucide="lock" class="w-4 h-4"></i>
                Données personnelles
            </div>
            <h1 class="section-title mb-4">Politique de <span class="text-gradient">Confidentialité</span></h1>
            <p class="text-slate-500 max-w-2xl">
                Comment COSEM traite les données personnelles collectées via ce site, et comment exercer
                vos droits.
            </p>
        </div>
    </section>

    <section class="py-12 lg:py-16">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 space-y-8">

            <div class="card p-6 lg:p-8 animate-fade-in-up">
                <h2 class="font-display text-xl font-bold text-ink mb-3 inline-flex items-center gap-2">
                    <i data-lucide="user-check" class="w-5 h-5 text-forest-600"></i>
                    Responsable du traitement
                </h2>
                <p class="text-sm text-slate-600">
                    COSEM — Société Coopérative Centrale des Semences, Avenue de la Liberté, Tunis.
                    Pour toute question relative à vos données personnelles, écrivez à
                    <a href="mailto:contact@cosem.tn" class="text-forest-600 hover:underline">contact@cosem.tn</a>.
                </p>
            </div>

            <div class="card p-6 lg:p-8 animate-fade-in-up">
                <h2 class="font-display text-xl font-bold text-ink mb-3 inline-flex items-center gap-2">
                    <i data-lucide="clipboard-list" class="w-5 h-5 text-forest-600"></i>
                    Données collectées
                </h2>
                <p class="text-sm text-slate-600">
                    Ce site ne crée aucun compte visiteur et n'utilise aucun traceur publicitaire. Les seules
                    données personnelles collectées sont celles que vous nous transmettez volontairement :
                </p>
                <ul class="mt-3 space-y-2 text-sm text-slate-600 list-disc pl-5">
                    <li><strong>Formulaire de contact</strong> : nom et prénom, adresse e-mail, téléphone (facultatif), objet et contenu du message.</li>
                    <li><strong>Assistant agricole « 9am7a »</strong> : les questions que vous posez sont transmises à notre service technique afin de vous répondre. Aucune donnée d'identité n'est requise.</li>
                    <li><strong>Espace administration</strong> : les identifiants de connexion sont réservés aux personnels habilités COSEM.</li>
                </ul>
            </div>

            <div class="card p-6 lg:p-8 animate-fade-in-up">
                <h2 class="font-display text-xl font-bold text-ink mb-3 inline-flex items-center gap-2">
                    <i data-lucide="target" class="w-5 h-5 text-forest-600"></i>
                    Finalité et durée de conservation
                </h2>
                <p class="text-sm text-slate-600">
                    Les messages du formulaire de contact sont conservés le temps nécessaire au traitement
                    de la demande, puis archivés pour une durée maximale de douze mois. Aucune donnée
                    n'est vendue, louée ou cédée à des tiers à des fins commerciales.
                </p>
            </div>

            <div class="card p-6 lg:p-8 animate-fade-in-up">
                <h2 class="font-display text-xl font-bold text-ink mb-3 inline-flex items-center gap-2">
                    <i data-lucide="hard-drive" class="w-5 h-5 text-forest-600"></i>
                    Sécurité et hébergement
                </h2>
                <p class="text-sm text-slate-600">
                    Les échanges sont chiffrés via HTTPS. Les mots de passe de l'espace administration sont
                    stockés sous forme de condensats (hachage) et ne sont jamais lisibles en clair.
                </p>
            </div>

            <div class="card p-6 lg:p-8 animate-fade-in-up">
                <h2 class="font-display text-xl font-bold text-ink mb-3 inline-flex items-center gap-2">
                    <i data-lucide="cookie" class="w-5 h-5 text-forest-600"></i>
                    Cookies et services tiers
                </h2>
                <p class="text-sm text-slate-600">
                    Aucun cookie publicitaire ou de mesure d'audience n'est déposé. Seul un cookie de
                    session technique, indispensable au fonctionnement de l'espace administration, peut être
                    créé. Certaines ressources (cartes interactives, polices, bibliothèques JavaScript)
                    sont chargées depuis des services tiers qui peuvent recevoir votre adresse IP lors de
                    l'affichage de la page.
                </p>
            </div>

            <div class="card p-6 lg:p-8 animate-fade-in-up">
                <h2 class="font-display text-xl font-bold text-ink mb-3 inline-flex items-center gap-2">
                    <i data-lucide="scale" class="w-5 h-5 text-forest-600"></i>
                    Vos droits
                </h2>
                <p class="text-sm text-slate-600">
                    Conformément à la loi tunisienne n° 2004-63 du 15 août 2004 relative à la protection des
                    données personnelles, vous disposez d'un droit d'accès, de rectification et de
                    suppression de vos données. Adressez votre demande à
                    <a href="mailto:contact@cosem.tn" class="text-forest-600 hover:underline">contact@cosem.tn</a>,
                    en précisant votre identité afin que nous puissions traiter votre demande dans les
                    meilleurs délais.
                </p>
            </div>

            <p class="text-xs text-slate-400">
                Dernière mise à jour : {{ \Illuminate\Support\Str::ucfirst(now()->locale('fr')->isoFormat('MMMM YYYY')) }}.
            </p>

        </div>
    </section>

@endsection