@extends('layouts.app')
@section('title', 'Detail misi')
@section('content')

<x-back-button :fallback="route('user.missions.index')" label="Kembali ke katalog misi" />

<article class="bg-white border border-line rounded-container p-8 shadow-[0_6px_0_rgba(38,62,48,0.05)] grid grid-cols-1 lg:grid-cols-[160px_1fr] gap-8 items-start anim-scale">
    <div class="w-40 h-40 rounded-container overflow-hidden border border-line transition-transform duration-300 hover:scale-105">
        @include('components.art', ['category' => $mission->category])
    </div>
    <div>
        <p class="text-caption text-muted font-semibold uppercase tracking-wider mb-1">Level {{ $mission->required_level }} · {{ $mission->category }}</p>
        <h1 class="text-heading text-ink mb-3">{{ $mission->display_title }}</h1>
        <p class="text-body text-muted mb-6">{{ $mission->description }}</p>

        <div class="bg-soft border border-line rounded-2xl p-5 mb-6">
            <h2 class="text-label text-forest font-bold mb-2">📸 Bukti kegiatan</h2>
            <p class="text-body text-ink">{{ $mission->evidence_instructions }} Kirim 1–3 foto dan deskripsi singkat.</p>
        </div>

        <div class="flex items-center gap-3 mb-6">
            <span class="text-2xl font-extrabold text-forest">+{{ $participation?->reward_xp_snapshot ?? $mission->xp_reward }} XP</span>
            <span class="text-caption text-muted">setelah disetujui admin</span>
        </div>

        @if($participation)
            <div class="flex items-center gap-3">
                @include('components.status', ['status' => $participation->status])
                <a href="{{ route('user.evidence', $participation) }}"
                   class="text-label text-forest font-semibold hover:underline transition-colors">
                    Buka pengerjaan →
                </a>
            </div>
        @elseif($level < $mission->required_level)
            <p class="text-body text-muted bg-soft border border-line rounded-btn px-4 py-3 inline-block">
                🔒 Misi terbuka saat kamu mencapai <strong>Level {{ $mission->required_level }}</strong>.
            </p>
        @else
            <form method="POST" action="{{ route('user.missions.join', $mission) }}"
                  data-confirm="Apakah kamu yakin ingin mengikuti misi '{{ $mission->display_title }}'?"
                  data-confirm-title="Ikuti Misi"
                  data-confirm-btn="Ya, Ikuti Misi">
                @csrf
                <x-action>Ikuti misi ini</x-action>
            </form>
        @endif
    </div>
</article>
@endsection
