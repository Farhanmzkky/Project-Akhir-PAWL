@extends('layouts.app')
@section('title', 'Misi saya')
@section('content')
<header class="page-intro"><h1>Setiap aksi punya cerita.</h1><p>Pantau aktivitas, hasil review, dan bukti yang perlu diperbaiki.</p></header>
@if(session('evidence_sent'))
    <div class="success-strip" role="status"><i class="glyph check" aria-hidden="true"></i><div><strong>Bukti berhasil dikirim. Terima kasih sudah beraksi!</strong>
        <small>Admin akan meninjau secara berkala. XP diberikan setelah bukti disetujui.</small></div></div>
@endif
<nav class="filter-pills" aria-label="Filter status misi">
@foreach($filters as $key => $label)
    <a href="{{ route('user.my-missions', $key === 'all' ? [] : ['status' => $key]) }}" @if($selected === $key) aria-current="page" @endif>
        <span>{{ $label }} ({{ $counts->get($key, 0) }})</span></a>
@endforeach
</nav>
<div class="activity-list">
@forelse($participants as $participant)
    @php
        $mission = $participant->mission;
        $entry = $participant->latestSubmission;
        $tile = match ($mission->seed_key) {
            'bring-your-tumbler' => 'bottle', 'say-no-to-plastic' => 'bag',
            'trash-in-its-place', 'clean-your-corner', 'lead-a-clean-up' => 'bin',
            default => null,
        };
        $action = match ($participant->status) {
            'in_progress' => 'Kirim bukti', 'rejected' => 'Perbaiki bukti', 'completed' => 'Lihat pencapaian', default => 'Lihat bukti',
        };
    @endphp
    <article class="activity-card">
        @if($tile)<div class="mission-tile {{ $tile }}" aria-hidden="true"></div>
        @else<div class="mission-tile fallback">@include('components.art', ['category' => $mission->category])</div>@endif
        <div class="activity-copy"><h2>{{ $mission->display_title }}</h2>@include('components.status', ['status' => $participant->status])
            @if($participant->status === 'pending_review' && $entry)
                <p>Dikirim {{ $entry->submitted_at->locale('id')->isoFormat('D MMM YYYY') }} · {{ $entry->photos_count }} foto · Percobaan ke-{{ $entry->attempt_number }}</p>
            @elseif($participant->status === 'rejected')<p class="reason">{{ $entry?->rejection_reason }}</p>
            @elseif($participant->status === 'completed')
                <p>Selesai {{ $participant->completed_at?->locale('id')->isoFormat('D MMM YYYY') }} · +{{ $participant->reward_xp_snapshot }} XP sudah diterima</p>
            @else<p>{{ $participant->draft_description || $participant->draft_photos ? 'Draf tersimpan' : 'Misi diikuti' }} · +{{ $participant->reward_xp_snapshot }} XP setelah disetujui</p>
            @endif
        </div>
        <a class="action secondary" href="{{ $participant->status === 'completed' ? route('user.achievements') : route('user.evidence', $participant) }}">{{ $action }}</a>
        @if($participant->status === 'completed')<a class="history-link" href="{{ route('user.evidence', $participant) }}">Riwayat bukti</a>@endif
    </article>
@empty
    <div class="surface empty-state"><h2>{{ $selected === 'all' ? 'Yuk, mulai misi pertamamu.' : 'Belum ada misi dengan status ini.' }}</h2>
        <a href="{{ $selected === 'all' ? route('user.missions.index') : route('user.my-missions') }}">{{ $selected === 'all' ? 'Jelajahi misi' : 'Lihat semua misi' }}</a></div>
@endforelse
</div>
@endsection
