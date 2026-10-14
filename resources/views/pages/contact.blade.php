@extends('layouts.app')

@section('title', 'Contact — COSEM')

@section('content')

    {{-- Header --}}
    <section class="page-header">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14 lg:py-16">
            <div class="section-eyebrow">
                <i data-lucide="send" class="w-4 h-4"></i>
                Contact
            </div>
            <h1 class="section-title mb-4">Parlez-nous de votre <span class="text-gradient">Projet</span></h1>
            <p class="text-slate-500 max-w-2xl">
                Une question sur nos semences, nos stations ou nos services ? Écrivez-nous.
                Notre équipe technique vous répond sous 48 heures ouvrées.
            </p>
        </div>
    </section>

    <section class="py-12 lg:py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-5 gap-10 lg:gap-14 items-start">

                {{-- Contact details --}}
                <div class="lg:col-span-2 space-y-5 animate-fade-in-up">
                    <div class="card p-5 flex items-start gap-4 card-hover">
                        <div class="w-11 h-11 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center shrink-0">
                            <i data-lucide="map-pin" class="w-5 h-5 text-forest-600"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-ink text-sm">Siège Social</h3>
                            <p class="text-sm text-slate-500">Avenue de la Liberté, Tunis, Tunisie</p>
                        </div>
                    </div>

                    <div class="card p-5 flex items-start gap-4 card-hover">
                        <div class="w-11 h-11 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center shrink-0">
                            <i data-lucide="phone" class="w-5 h-5 text-forest-600"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-ink text-sm">Téléphone</h3>
                            <a href="tel:+21671747000" class="text-sm text-slate-500 hover:text-forest-600 transition">+216 71 747 000</a>
                        </div>
                    </div>

                    <div class="card p-5 flex items-start gap-4 card-hover">
                        <div class="w-11 h-11 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center shrink-0">
                            <i data-lucide="mail" class="w-5 h-5 text-forest-600"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-ink text-sm">Email</h3>
                            <a href="mailto:contact@cosem.tn" class="text-sm text-slate-500 hover:text-forest-600 transition">contact@cosem.tn</a>
                        </div>
                    </div>

                    {{-- Hours --}}
                    <div class="card p-5">
                        <h3 class="font-bold text-ink text-sm mb-3 inline-flex items-center gap-2">
                            <i data-lucide="clock" class="w-4 h-4 text-forest-600"></i> Horaires
                        </h3>
                        <ul class="text-sm text-slate-500 space-y-1.5">
                            <li class="flex justify-between"><span>Lundi — Vendredi</span><span class="font-semibold text-ink">08:00 — 17:00</span></li>
                            <li class="flex justify-between"><span>Samedi</span><span class="font-semibold text-ink">08:00 — 13:00</span></li>
                            <li class="flex justify-between"><span>Dimanche</span><span class="font-semibold text-slate-400">Fermé</span></li>
                        </ul>
                    </div>
                </div>

                {{-- Form --}}
                <div class="lg:col-span-3 card p-6 sm:p-8 shadow-lift animate-fade-in-up" style="animation-delay: .1s">
                    <h2 class="font-display text-xl font-bold text-ink mb-6">Envoyer un Message</h2>

                    @if ($errors->any())
                        <div class="mb-5 p-4 rounded-2xl bg-red-50 border border-red-200 text-sm text-red-700">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                        @csrf
                        <div class="grid sm:grid-cols-2 gap-5">
                            <div>
                                <label for="full_name" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Nom complet *</label>
                                <input type="text" name="full_name" id="full_name" required value="{{ old('full_name') }}"
                                       placeholder="Votre nom et prénom"
                                       class="w-full px-4 py-3.5 rounded-xl bg-white border border-emerald-200 text-sm text-ink placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
                            </div>
                            <div>
                                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Email *</label>
                                <input type="email" name="email" id="email" required value="{{ old('email') }}"
                                       placeholder="vous@exemple.tn"
                                       class="w-full px-4 py-3.5 rounded-xl bg-white border border-emerald-200 text-sm text-ink placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
                            </div>
                        </div>
                        <div class="grid sm:grid-cols-2 gap-5">
                            <div>
                                <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Téléphone</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                       placeholder="+216 XX XXX XXX"
                                       class="w-full px-4 py-3.5 rounded-xl bg-white border border-emerald-200 text-sm text-ink placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
                            </div>
                            <div>
                                <label for="subject" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Sujet</label>
                                <select name="subject" id="subject"
                                        class="w-full px-4 py-3.5 rounded-xl bg-white border border-emerald-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
                                    <option value="">— Choisir un sujet —</option>
                                    @foreach(['Demande de semences', 'Conseil technique', 'Devenir multiplicateur', 'Autre'] as $s)
                                        <option value="{{ $s }}" {{ old('subject') === $s ? 'selected' : '' }}>{{ $s }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div>
                            <label for="message" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Message *</label>
                            <textarea name="message" id="message" rows="6" required
                                      placeholder="Décrivez votre demande en détail..."
                                      class="w-full px-4 py-3.5 rounded-xl bg-white border border-emerald-200 text-sm text-ink placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition resize-none">{{ old('message') }}</textarea>
                        </div>
                        <div class="flex flex-wrap items-center gap-4">
                            <button type="submit" class="btn-primary">
                                <i data-lucide="send" class="w-4 h-4"></i>
                                Envoyer le Message
                            </button>
                            <p class="text-xs text-slate-400">Réponse garantie sous 48h ouvrées.</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
