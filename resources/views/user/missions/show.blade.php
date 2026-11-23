@extends('layouts.app')
@section('title', 'Detail misi')
@section('content')
<a href="{{ route('user.missions.index') }}">← Katalog misi</a>
<article class="panel detail">@include('components.art', ['category' => $mission->category])
<div class="card-body"><p class="kicker">Level {{ $mission->required_level }} · {{ $mission->category }}</p>
<h1>{{ $mission->display_title }}</h1><p>{{ $mission->description }}</p>
<h2>Bukti kegiatan</h2><p>{{ $mission->evidence_instructions }} Kirim 1–3 foto dan deskripsi singkat.</p>
<p><strong>Reward +{{ $participation?->reward_xp_snapshot ?? $mission->xp_reward }} XP</strong></p>
@if($participation)
    @include('components.status', ['status' => $participation->status])
    <a href="{{ route('user.evidence', $participation) }}">Buka pengerjaan</a>
@elseif($level < $mission->required_level)
    <p class="message">Misi terbuka saat kamu mencapai Level {{ $mission->required_level }}.</p>
@else
    <form method="POST" action="{{ route('user.missions.join', $mission) }}">@csrf <x-action>Ikuti misi</x-action></form>
@endif
</div></article>
@endsection
