@extends('layouts.admin')

@section('title', 'Messages Reçus')
@section('page-title', 'Messages Reçus')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <p class="text-sm text-slate-500">
            {{ $messages->total() }} message(s) —
            <span class="font-bold text-red-600">{{ $unreadCount }} non lu(s)</span>
        </p>
    </div>

    <div class="card overflow-hidden">
        <div class="divide-y divide-emerald-100">
            @forelse($messages as $message)
                <div class="flex flex-wrap items-center gap-4 px-5 py-4 hover:bg-slate-50 transition {{ $message->is_read ? '' : 'bg-emerald-50/40' }}">
                    <span class="w-2.5 h-2.5 rounded-full shrink-0 {{ $message->is_read ? 'bg-slate-300' : 'bg-red-500' }}"></span>

                    <a href="{{ route('admin.messages.show', $message) }}" class="min-w-0 flex-1">
                        <p class="text-sm {{ $message->is_read ? 'text-slate-600' : 'font-bold text-ink' }} truncate">
                            {{ $message->full_name }}
                            <span class="text-slate-400 font-normal">— {{ $message->email }}</span>
                        </p>
                        <p class="text-xs {{ $message->is_read ? 'text-slate-400' : 'font-semibold text-slate-600' }} truncate mt-0.5">
                            {{ $message->subject ?? 'Sans sujet' }} — {{ \Illuminate\Support\Str::limit($message->message, 100) }}
                        </p>
                    </a>

                    <div class="flex items-center gap-2 shrink-0 ml-auto">
                        <span class="text-xs text-slate-400 hidden sm:block">{{ $message->created_at->format('d/m/Y H:i') }}</span>

                        <form method="POST" action="{{ route('admin.messages.toggle', $message) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="p-2 rounded-lg text-slate-500 hover:bg-emerald-50 transition"
                                    title="{{ $message->is_read ? 'Marquer comme non lu' : 'Marquer comme lu' }}">
                                <i data-lucide="{{ $message->is_read ? 'mail' : 'mail-open' }}" class="w-4 h-4"></i>
                            </button>
                        </form>

                        <button type="button"
                                @click="$dispatch('confirm-delete', { url: '{{ route('admin.messages.destroy', $message) }}', label: 'le message de {{ $message->full_name }}' })"
                                class="p-2 rounded-lg text-red-600 hover:bg-red-50 transition" title="Supprimer">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            @empty
                <div class="px-5 py-12 text-center text-slate-400 text-sm">Aucun message reçu pour le moment.</div>
            @endforelse
        </div>
    </div>

    <div class="mt-6">
        {{ $messages->links() }}
    </div>
@endsection
