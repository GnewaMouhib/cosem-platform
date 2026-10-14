<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion Administration — COSEM</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 font-sans antialiased min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <img src="{{ asset('images/cosem-logo.png') }}" alt="Logo COSEM" height="48"
                 class="h-12 w-auto object-contain mx-auto mb-4">
            <h1 class="font-display text-2xl font-bold text-ink">Espace Administration</h1>
            <p class="text-sm text-slate-500 mt-1">Coopérative des Semences — depuis 1947</p>
        </div>

        <div class="bg-white rounded-3xl border border-emerald-100 shadow-soft p-8">
            @if($errors->any())
                <div class="mb-6 flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-red-500 shrink-0 mt-0.5"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.attempt') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Adresse e-mail</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                           placeholder="admin@cosem.tn"
                           class="w-full px-4 py-3.5 rounded-xl bg-white border border-emerald-200 text-sm text-ink placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
                    @error('email')
                        <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-forest-700 mb-2">Mot de passe</label>
                    <input type="password" name="password" id="password" required
                           placeholder="••••••••••••"
                           class="w-full px-4 py-3.5 rounded-xl bg-white border border-emerald-200 text-sm text-ink placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-forest-600/30 focus:border-forest-600 transition">
                    @error('password')
                        <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <label class="flex items-center gap-2.5 cursor-pointer select-none">
                    <input type="checkbox" name="remember" id="remember" value="1"
                           class="w-4 h-4 rounded border-emerald-300 text-forest-700 focus:ring-forest-600/30">
                    <span class="text-sm text-slate-600 font-medium">Se souvenir de moi</span>
                </label>

                <button type="submit"
                        class="w-full btn-primary justify-center py-3.5 text-base">
                    <i data-lucide="log-in" class="w-4 h-4"></i>
                    Se connecter
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-slate-400 mt-6">
            © {{ date('Y') }} COSEM — Accès strictement réservé au personnel autorisé.
        </p>
    </div>

    <script src="https://unpkg.com/lucide@0.468.0/dist/umd/lucide.min.js"></script>
    <script>document.addEventListener('DOMContentLoaded', () => lucide.createIcons());</script>
</body>
</html>
