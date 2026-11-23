@extends('layouts.app')
@section('title', 'Misi saya')
@section('content')
<header class="mb-6 anim-fade-up">
    <h1 class="text-heading text-ink">Setiap aksi punya cerita</h1>
    <p class="text-body text-muted mt-1">Pantau aktivitas, hasil review, dan bukti yang perlu diperbaiki.</p>
</header>

@if(session('evidence_sent'))
    <div class="bg-soft border border-line text-forest p-4 rounded-btn mb-6 flex items-center gap-3 anim-fade-up eco-pulse" role="status">
        <i class="glyph check text-forest" aria-hidden="true"></i>
        <div>
            <strong class="text-label block font-bold">Bukti berhasil dikirim. Terima kasih sudah beraksi!</strong>
            <small class="text-caption text-forest/90">Admin akan meninjau secara berkala. XP diberikan setelah bukti disetujui.</small>
        </div>
    </div>
@endif

<!-- Filter Pills -->
<nav class="flex gap-2.5 flex-wrap mb-6 anim-fade-up delay-1" aria-label="Filter status misi">
    @foreach($filters as $key => $label)
        @php $isCurrent = $selected === $key; @endphp
        <a href="{{ route('user.my-missions', $key === 'all' ? [] : ['status' => $key]) }}"
           class="px-4 py-1.5 rounded-full text-caption font-semibold transition-all min-h-[36px] inline-flex items-center
                  {{ $isCurrent
                      ? 'bg-forest text-white shadow-sm'
                      : 'bg-white text-muted border border-line hover:border-forest hover:text-ink hover:-translate-y-0.5' }}">
            <span>{{ $label }} ({{ $counts->get($key, 0) }})</span>
        </a>
    @endforeach
</nav>

<!-- Activity List Cards -->
<div class="flex flex-col gap-4">
@forelse($participants as $participant)
    @php
        $mission = $participant->mission;
        $entry = $participant->latestSubmission;
        $tile = match ($mission->seed_key) {
            'bring-your-tumbler' => 'bottle',
            'say-no-to-plastic' => 'bag',
            default => null,
        };
        $actionText = match ($participant->status) {
            'in_progress' => 'Kirim bukti',
            'rejected' => 'Perbaiki bukti',
            'completed' => 'Lihat pencapaian',
            default => 'Lihat bukti',
        };
        $actionRoute = $participant->status === 'completed'
            ? route('user.achievements')
            : route('user.evidence', $participant);
    @endphp

    <article class="group bg-white border border-line rounded-container p-6 shadow-[0_6px_0_rgba(38,62,48,0.05)]
                    grid grid-cols-1 md:grid-cols-[96px_1fr_auto] gap-5 items-center
                    hover:border-forest hover:shadow-[0_10px_28px_rgba(24,63,50,0.10)] hover:-translate-y-0.5
                    transition-all duration-200 row-anim cursor-pointer select-none"
             onclick="if (!event.target.closest('a, button')) window.location='{{ $actionRoute }}'"
             style="animation-delay: {{ $loop->index * 0.07 }}s">
        <!-- Thumbnail Misi Konsisten -->
        <div class="w-24 h-24 rounded-container overflow-hidden shrink-0 border border-line transition-transform duration-300 hover:scale-105">
            @include('components.art', ['mission' => $mission, 'category' => $mission->category])
        </div>

        <!-- Mission Copy -->
        <div class="flex flex-col gap-1.5">
            <div class="flex items-center gap-3 flex-wrap">
                <h2 class="text-section text-ink font-bold">{{ $mission->display_title }}</h2>
                @include('components.status', ['status' => $participant->status])
            </div>

            @if($participant->status === 'pending_review' && $entry)
                <p class="text-body text-muted">
                    Dikirim {{ $entry->submitted_at->locale('id')->isoFormat('D MMM YYYY') }} · {{ $entry->photos_count }} foto · Percobaan ke-{{ $entry->attempt_number }}
                </p>
            @elseif($participant->status === 'rejected')
                <p class="text-body text-[#903E35] font-medium">Catatan penolakan: {{ $entry?->rejection_reason }}</p>
            @elseif($participant->status === 'completed')
                <p class="text-body text-muted">
                    Selesai {{ $participant->completed_at?->locale('id')->isoFormat('D MMM YYYY') }} · <span class="text-forest font-semibold">+{{ $participant->reward_xp_snapshot }} XP</span> sudah diterima
                </p>
            @else
                <p class="text-body text-muted">
                    {{ $participant->draft_description || $participant->draft_photos ? 'Draf tersimpan' : 'Misi diikuti' }} · +{{ $participant->reward_xp_snapshot }} XP setelah disetujui
                </p>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col gap-2 items-stretch md:items-end w-full md:w-auto">
            <x-action variant="secondary" :href="$actionRoute" onclick="window.location='{{ $actionRoute }}'" class="w-full md:w-auto text-center">
                {{ $actionText }}
            </x-action>
            @if($participant->status === 'completed')
                <a class="text-caption text-forest text-center hover:underline py-1 transition-colors" href="{{ route('user.evidence', $participant) }}">
                    Riwayat bukti
                </a>
            @endif
        </div>
    </article>
@empty
    <div class="bg-white border border-line rounded-container p-12 text-center flex flex-col items-center justify-center gap-4 anim-scale shadow-sm">
        <div class="w-16 h-16 rounded-full bg-soft text-forest flex items-center justify-center text-3xl">
            🌿
        </div>
        <div>
            <h2 class="text-section text-ink font-bold">
                {{ $selected === 'all' ? 'Yuk, mulai misi pertamamu!' : 'Belum ada misi dengan status ini.' }}
            </h2>
            <p class="text-body text-muted mt-1 max-w-md">
                {{ $selected === 'all'
                    ? 'Pilih aksi ramah lingkungan di kampus, kumpulkan poin XP, dan raih badge pencapaian bersama teman-temanmu.'
                    : 'Kamu belum memiliki aktivitas misi dengan status ini. Coba cek kategori status lainnya.' }}
            </p>
        </div>
        <div class="pt-2">
            @if($selected === 'all')
                <x-action :href="route('user.missions.index')" onclick="window.location='{{ route('user.missions.index') }}'">
                    Jelajahi Misi Sekarang →
                </x-action>
            @else
                <a href="{{ route('user.my-missions') }}"
                   class="inline-flex items-center justify-center min-h-[42px] px-6 rounded-btn bg-forest text-white text-label font-semibold hover:bg-forest-hover transition-colors shadow-sm">
                    Tampilkan Semua Misi Saya
                </a>
            @endif
        </div>
    </div>
@endforelse
</div>
@endsection
