@extends('layouts.app')
@section('title', 'Dashboard peserta')
@section('content')
<div class="spread"><h1>Halo, {{ $user->name }}.</h1><a class="action" href="{{ route('user.missions.index') }}">Jelajahi misi</a></div>
@if($levelUp)<p class="message" role="status">Level naik! Kamu sekarang {{ $levelName }}.</p>@endif
<div class="grid dashboard-grid">
    <section class="featured"><p class="kicker">Level {{ $level }}</p><h2>{{ $levelName }}</h2>
        <p class="big">{{ number_format($user->total_xp, 0, ',', '.') }} <small>XP</small></p>
        <progress aria-label="Progres level" max="100" value="{{ $progress }}">{{ $progress }}%</progress>
        <p>{{ $next ? ($next - $user->total_xp).' XP lagi menuju Level '.($level + 1) : 'Kamu sudah mencapai level tertinggi.' }}</p>
    </section>
    <section class="panel"><h2>Misi selesai</h2><p class="big">{{ $completed }}</p><a href="{{ route('user.my-missions') }}">Lihat misi saya</a></section>
    <section class="panel"><h2>Peringkat</h2><p class="big">#{{ $rank }}</p><a href="{{ route('user.leaderboard') }}">Lihat leaderboard</a></section>
</div>
<h2>Misi berjalan</h2>
@forelse($ongoing as $participant)
    <div class="panel spread"><a href="{{ route('user.evidence', $participant) }}">{{ $participant->mission->display_title }}</a>
    @include('components.status', ['status' => $participant->status])</div>
@empty <p>Belum ada misi berjalan. Mulai dengan <a href="{{ route('user.missions.index') }}">memilih satu misi</a>.</p>
@endforelse
<h2>Badge terbaru</h2><div class="grid cards">
@forelse($badges as $badge)<div class="panel"><span aria-hidden="true">{{ $badge->icon }}</span> {{ $badge->name }}</div>
@empty <p>Selesaikan misi pertamamu untuk memperoleh First Step.</p>
@endforelse</div>
@endsection
