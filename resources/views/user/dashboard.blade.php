@extends('layouts.app')
@section('title', 'Dashboard peserta')
@section('content')
<div class="flex items-center justify-between gap-4 mb-6">
    <h1 class="text-heading text-ink">Halo, {{ $user->name }}.</h1>
    <x-action :href="route('user.missions.index')" onclick="window.location='{{ route('user.missions.index') }}'">Jelajahi misi</x-action>
</div>

@if($levelUp)
    <div class="bg-lime/50 border border-line text-forest px-5 py-3 rounded-btn mb-6 text-label flex items-center gap-2">
        <i class="glyph check text-forest" aria-hidden="true"></i>
        <span>Selamat! Kamu naik ke <strong>{{ $levelName }}</strong>!</span>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Featured Card: Level Progress (Forest Green) -->
    <section class="bg-forest text-white rounded-container p-6 shadow-[0_6px_0_rgba(24,63,50,0.20)] flex flex-col justify-between">
        <div>
            <span class="text-caption font-semibold tracking-wider text-lime uppercase">Level {{ $level }}</span>
            <h2 class="text-section text-white mt-0.5">{{ $levelName }}</h2>
            <div class="text-3xl font-extrabold tracking-tight mt-3 text-white">
                {{ number_format($user->total_xp, 0, ',', '.') }} <span class="text-base font-normal text-white/80">XP</span>
            </div>
        </div>
        <div class="mt-6">
            <div class="w-full bg-black/25 rounded-full h-2.5 overflow-hidden">
                <div class="bg-lime h-2.5 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
            </div>
            <p class="text-caption text-white/80 mt-2">
                {{ $next ? ($next - $user->total_xp).' XP lagi menuju Level '.($level + 1) : 'Kamu sudah mencapai level tertinggi!' }}
            </p>
        </div>
    </section>

    <!-- Stat Card: Misi Selesai -->
    <section class="bg-white border border-line rounded-container p-6 shadow-[0_6px_0_rgba(38,62,48,0.05)] flex flex-col justify-between">
        <div>
            <span class="text-caption text-muted font-semibold uppercase tracking-wider">Aktivitas</span>
            <h2 class="text-section text-ink mt-0.5">Misi selesai</h2>
            <p class="text-4xl font-extrabold text-ink mt-2">{{ $completed }}</p>
        </div>
        <a class="text-label text-forest font-semibold hover:underline inline-flex items-center gap-1 mt-4" href="{{ route('user.my-missions') }}">
            Lihat riwayat misi →
        </a>
    </section>

    <!-- Stat Card: Peringkat Leaderboard -->
    <section class="bg-white border border-line rounded-container p-6 shadow-[0_6px_0_rgba(38,62,48,0.05)] flex flex-col justify-between">
        <div>
            <span class="text-caption text-muted font-semibold uppercase tracking-wider">Komunitas</span>
            <h2 class="text-section text-ink mt-0.5">Peringkat kampus</h2>
            <p class="text-4xl font-extrabold text-forest mt-2">#{{ $rank }}</p>
        </div>
        <a class="text-label text-forest font-semibold hover:underline inline-flex items-center gap-1 mt-4" href="{{ route('user.leaderboard') }}">
            Buka leaderboard →
        </a>
    </section>
</div>

<!-- Section: Misi Berjalan -->
<div class="mb-8">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-section text-ink">Misi berjalan</h2>
        <a href="{{ route('user.my-missions') }}" class="text-label text-forest font-semibold hover:underline">Semua misi saya</a>
    </div>
    <div class="flex flex-col gap-3">
        @forelse($ongoing as $participant)
            <div class="bg-white border border-line rounded-2xl p-4 px-6 flex items-center justify-between gap-4 shadow-sm hover:border-forest transition-colors">
                <a href="{{ route('user.evidence', $participant) }}" class="text-body font-semibold text-ink hover:text-forest">
                    {{ $participant->mission->display_title }}
                </a>
                <div class="flex items-center gap-3">
                    @include('components.status', ['status' => $participant->status])
                    <a href="{{ route('user.evidence', $participant) }}" class="text-caption font-semibold text-forest hover:underline">Buka →</a>
                </div>
            </div>
        @empty
            <div class="bg-white border border-line rounded-container p-8 text-center">
                <p class="text-body text-muted">Belum ada misi yang sedang berjalan.</p>
                <a href="{{ route('user.missions.index') }}" class="text-label text-forest font-semibold hover:underline mt-2 inline-block">Mulai dengan memilih satu misi</a>
            </div>
        @endforelse
    </div>
</div>

<!-- Section: Badge Terbaru (Kebunku) -->
<div>
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-section text-ink">Badge terbaru</h2>
        <a href="{{ route('user.achievements') }}" class="text-label text-forest font-semibold hover:underline">Lihat Kebunku</a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        @forelse($badges as $badge)
            <div class="bg-white border border-line rounded-2xl p-4 flex items-center gap-3 shadow-sm">
                <span class="text-3xl" aria-hidden="true">{{ $badge->icon }}</span>
                <div>
                    <strong class="text-label text-ink block">{{ $badge->name }}</strong>
                    <small class="text-caption text-muted block">{{ $badge->description }}</small>
                </div>
            </div>
        @empty
            <div class="sm:col-span-3 bg-white border border-line rounded-container p-6 text-center text-body text-muted">
                Selesaikan misi pertamamu untuk memperoleh badge <strong>First Step</strong>! 🌱
            </div>
        @endforelse
    </div>
</div>
@endsection
