@extends('layouts.app')
@section('title', 'Leaderboard')
@section('content')
<header class="mb-6">
    <h1 class="text-heading text-ink">Leaderboard</h1>
    <p class="text-body text-muted mt-1">Peringkat sepanjang waktu berdasarkan XP dari misi yang disetujui.</p>
</header>

<div class="bg-white border border-line rounded-container overflow-hidden shadow-[0_6px_0_rgba(38,62,48,0.05)]">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-body border-collapse">
            <thead>
                <tr class="bg-soft border-b border-line text-forest font-semibold text-label">
                    <th class="px-6 py-4">Peringkat</th>
                    <th class="px-6 py-4">Peserta</th>
                    <th class="px-6 py-4">Level</th>
                    <th class="px-6 py-4">Misi selesai</th>
                    <th class="px-6 py-4">Total XP</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line">
            @foreach($users as $user)
                @php $isMe = $user->id === auth()->id(); @endphp
                <tr class="transition-colors {{ $isMe ? 'bg-lime/20 font-semibold' : 'hover:bg-ivory/60' }}">
                    <td class="px-6 py-4 text-forest font-bold">#{{ $users->firstItem() + $loop->index }}</td>
                    <td class="px-6 py-4 text-ink flex items-center gap-2">
                        <span>{{ $user->name }}</span>
                        @if($isMe)
                            <span class="text-caption bg-forest text-white px-2 py-0.5 rounded-full">kamu</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-muted">Level {{ \App\Services\GamificationService::level($user->total_xp) }}</td>
                    <td class="px-6 py-4 text-muted">{{ $user->completed_count }}</td>
                    <td class="px-6 py-4 font-bold text-forest">{{ number_format($user->total_xp, 0, ',', '.') }} XP</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $users->links() }}
</div>
@endsection
