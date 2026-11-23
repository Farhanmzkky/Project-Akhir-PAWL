@extends('layouts.app')
@section('title', in_array($participant->status, ['in_progress', 'rejected']) ? 'Kirim bukti' : 'Lihat bukti')
@section('content')
@php
    $canSubmit = in_array($participant->status, ['in_progress', 'rejected'], true);
    $savedPhotos = collect($participant->draft_photos ?? [])->pluck('name');
@endphp
<header class="page-intro"><h1>{{ $canSubmit ? 'Tunjukkan aksi nyatamu.' : 'Riwayat bukti kegiatanmu.' }}</h1>
<p>{{ $participant->mission->display_title }} · Bukti akan ditinjau admin sebelum XP diberikan.</p></header>
@if($canSubmit)
<div class="evidence-grid">
    <section class="surface proof-form">
        <ol class="step-list" aria-label="Langkah misi"><li>1 Ikut misi ✓</li><li aria-current="step">2 Kirim bukti</li><li>3 Review</li></ol>
        @if($participant->status === 'rejected')<div class="message problem">Perlu perbaikan · {{ $participant->submissions->first()?->rejection_reason }}</div>@endif
        <h2>Foto kegiatan</h2>
        <form method="post" action="{{ route('user.submissions.store', $participant) }}" enctype="multipart/form-data">
            @csrf
            <div class="drop-area" id="drop-area">
                <i class="glyph upload" aria-hidden="true"></i><strong>Tarik foto ke sini atau pilih dari perangkat</strong>
                <small>JPG / PNG · Maks. 5 MB per foto · 1–3 foto</small>
                <label class="action secondary pick-file">Pilih foto<input type="file" name="photos[]" id="photos" accept="image/jpeg,image/png" multiple></label>
            </div>
            <div id="selection" class="selection" role="status" @if($savedPhotos->isEmpty()) hidden @endif>
                <i class="glyph check" aria-hidden="true"></i><strong id="file-names">{{ $savedPhotos->implode(' · ') }}</strong>
                <small id="file-count">{{ $savedPhotos->isNotEmpty() ? $savedPhotos->count().' foto tersimpan dalam draf' : '' }}</small>
            </div>
            @if($savedPhotos->isNotEmpty())<small>Pilih foto baru untuk mengganti foto draf, atau langsung kirim foto yang tersimpan.</small>@endif
            <div class="photos" id="preview"></div>
            <label class="description-label" for="description">Ceritakan kegiatanmu</label>
            <textarea id="description" name="description" required maxlength="3000" rows="4" aria-describedby="description-help"
                placeholder="Saya membersihkan area taman fakultas bersama dua teman dan memilah sampah plastik serta kertas.">{{ old('description', $participant->draft_description) }}</textarea>
            <small id="description-help">Jelaskan lokasi, aktivitas, dan hasil kegiatanmu.</small>
            <label class="consent"><input type="checkbox" name="ownership" value="1" required @checked(old('ownership'))> Foto ini milik saya dan sesuai kegiatan yang saya lakukan.</label>
            <div class="form-actions"><x-action>Kirim bukti</x-action>
                <button class="action secondary" type="submit" formaction="{{ route('user.evidence.draft', $participant) }}" formnovalidate>Simpan &amp; kembali</button></div>
        </form>
    </section>
    <section class="evidence-tips"><h2>Bukti yang mudah direview</h2>
        <ol><li>Pastikan foto terang dan tidak blur.</li><li>{{ $participant->mission->evidence_instructions }}</li><li>Sertakan hasil kegiatan yang jelas.</li></ol>
        <hr><h3>Privasi bukti</h3><p>Foto hanya dapat dilihat oleh kamu dan admin yang berwenang.</p>
        <small>Jika bukti perlu diperbaiki, kamu akan menerima alasan dan bisa mengirim ulang.</small>
    </section>
</div>
@endif
@if($participant->submissions->isNotEmpty())
<section class="attempts"><h2>Riwayat pengiriman</h2>
@foreach($participant->submissions as $submission)
    <article class="panel"><div class="spread"><strong>Percobaan {{ $submission->attempt_number }}</strong>
        @include('components.status', ['status' => $submission->status])</div>
        <small>Dikirim {{ $submission->submitted_at->locale('id')->isoFormat('D MMM YYYY, HH:mm') }}</small>
        <p>{{ $submission->description }}</p>
        @if($submission->rejection_reason)<p class="reason">Catatan admin · {{ $submission->rejection_reason }}</p>@endif
        @include('components.photos')
    </article>
@endforeach</section>
@endif
@push('scripts')<script src="{{ asset('js/evidence.js') }}"></script>@endpush
@endsection
