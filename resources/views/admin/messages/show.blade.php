@extends('layouts.admin')

@section('title', 'Message — '.$message->full_name)
@section('page-title', 'Message reçu')

@section('content')
    <a href="{{ route('admin.messages.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-forest-700 hover:text-forest-800 transition mb-6">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Retour à la boîte de réception
    </a>

    <div class="card p-6 sm:p-8 max-w-3xl">
        <div class="flex flex-wrap items-start justify-between gap-4 pb-6 border-b border-emerald-100">
            <div>
                <h2 class="font-display text-xl font-bold text-ink">{{ $message->subject ?? 'Sans sujet' }}</h2>
                <p class="text-sm text-slate-500 mt-1">
                    De <span class="font-bold text-ink">{{ $message->full_name }}</span>
                    — {{ $message->created_at->format('d/m/Y à H:i') }}
                </p>
            </div>
            <div class="flex items-center gap-2">
                <form method="POST" action="{{ route('admin.messages.toggle', $message) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn-outline py-2.5">
                        <i data-lucide="{{ $message->is_read ? 'mail' : 'mail-open' }}" class="w-4 h-4"></i>
                        {{ $message->is_read ? 'Marquer non lu' : 'Marquer lu' }}
                    </button>
                </form>
                <button type="button"
                        @click="$dispatch('confirm-delete', { url: '{{ route('admin.messages.destroy', $message) }}', label: 'ce message' })"
                        class="p-2.5 rounded-xl text-red-600 border border-red-100 hover:bg-red-50 transition" title="Supprimer">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
            </div>
        </div>

        <div class="py-6 space-y-4">
            <div class="flex flex-wrap gap-6">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">E-mail</p>
                    <a href="mailto:{{ $message->email }}" class="text-sm font-semibold text-forest-700 hover:underline">{{ $message->email }}</a>
                </div>
                @if($message->phone)
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Téléphone</p>
                        <p class="text-sm font-semibold text-ink">{{ $message->phone }}</p>
                    </div>
                @endif
            </div>

            <div class="rounded-2xl bg-slate-50 border border-emerald-100 px-5 py-4 text-sm text-slate-700 whitespace-pre-line">{{ $message->message }}</div>
        </div>
    </div>
@endsection
