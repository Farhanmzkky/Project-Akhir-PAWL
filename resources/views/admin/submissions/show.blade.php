@extends('layouts.app')
@section('title', 'Tinjau bukti')
@section('content')
<h1>{{ $submission->participant->mission->display_title }}</h1>
<article class="panel"><div class="spread"><strong>{{ $submission->participant->user->name }}</strong>
@include('components.status', ['status' => $submission->status])</div>
<p>Percobaan {{ $submission->attempt_number }} · {{ $submission->submitted_at }} · {{ $submission->participant->reward_xp_snapshot }} XP</p>
<h2>Petunjuk misi</h2><p>{{ $submission->participant->mission->evidence_instructions }}</p>
<h2>Keterangan peserta</h2><p>{{ $submission->description }}</p>
@include('components.photos')
</article>
@if($submission->status === 'pending')
<section class="panel"><h2>Keputusan verifikasi</h2>
<form method="POST" action="{{ route('admin.submissions.approve', $submission) }}">@csrf <x-action>Setujui dan berikan XP</x-action></form>
<hr><form class="form-stack" method="POST" action="{{ route('admin.submissions.reject', $submission) }}">@csrf
    <label>Alasan jika ditolak<textarea name="reason" required maxlength="1500">{{ old('reason') }}</textarea></label>
    <x-action class="danger">Tolak dan minta perbaikan</x-action>
</form></section>
@else
<p>Ditinjau oleh {{ $submission->reviewer?->name }} pada {{ $submission->reviewed_at }}.</p>
@if($submission->rejection_reason)<p>Alasan penolakan: {{ $submission->rejection_reason }}</p>@endif
@endif
@endsection
