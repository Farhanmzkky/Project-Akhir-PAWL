@extends('layouts.app')
@section('title', in_array($participant->status, ['in_progress', 'rejected']) ? 'Kirim bukti' : 'Lihat bukti')
@section('content')
@php
    $canSubmit = in_array($participant->status, ['in_progress', 'rejected'], true);
    $savedPhotos = collect($participant->draft_photos ?? [])->pluck('name');
@endphp

<header class="mb-6">
    <h1 class="text-heading text-ink">
        {{ $canSubmit ? 'Tunjukkan aksi nyatamu.' : 'Riwayat bukti kegiatanmu.' }}
    </h1>
    <p class="text-body text-muted mt-1">
        {{ $participant->mission->display_title }} · Bukti akan ditinjau admin sebelum XP diberikan.
    </p>
</header>

@if($canSubmit)
<div class="grid grid-cols-1 lg:grid-cols-[1fr_340px] gap-6 items-start">
    <!-- Form Box -->
    <section class="bg-white border border-line rounded-container p-6 lg:p-8 shadow-[0_6px_0_rgba(38,62,48,0.05)]">
        <!-- Step progress indicators -->
        <ol class="flex items-center gap-2 mb-6" aria-label="Langkah misi">
            <li class="px-3 py-1 rounded-full bg-soft text-forest text-caption font-semibold">1 Ikut misi ✓</li>
            <li class="px-3 py-1 rounded-full bg-forest text-white text-caption font-semibold" aria-current="step">2 Kirim bukti</li>
            <li class="px-3 py-1 rounded-full bg-soft text-muted text-caption font-medium">3 Review</li>
        </ol>

        @if($participant->status === 'rejected')
            <div class="bg-[#F8E2DC] border border-[#F2BFB5] text-[#903E35] p-4 rounded-btn mb-6 text-body">
                <strong>Perlu perbaikan:</strong> {{ $participant->submissions->first()?->rejection_reason }}
            </div>
        @endif

        <h2 class="text-section text-ink mb-4">Foto kegiatan</h2>

        <form method="post" action="{{ route('user.submissions.store', $participant) }}" enctype="multipart/form-data">
            @csrf

            <!-- Drag & Drop Box -->
            <div class="border-2 border-dashed border-line rounded-container bg-ivory p-8 flex flex-col items-center justify-center text-center gap-3 transition-colors hover:border-forest" id="drop-area">
                <i class="glyph upload w-8 h-8 text-forest" aria-hidden="true"></i>
                <div>
                    <strong class="text-label text-ink block">Tarik foto ke sini atau pilih dari perangkat</strong>
                    <small class="text-caption text-muted block mt-0.5">JPG / PNG · Maks. 5 MB per foto · 1–3 foto</small>
                </div>
                <label class="inline-flex items-center justify-center min-h-[44px] px-6 rounded-btn bg-white border border-line text-forest text-label font-semibold cursor-pointer hover:bg-soft transition-all shadow-sm">
                    <span>Pilih foto</span>
                    <input type="file" name="photos[]" id="photos" accept="image/jpeg,image/png" multiple class="hidden">
                </label>
            </div>

            <!-- Draft photo status notification -->
            <div id="selection" class="mt-4 p-4 rounded-2xl bg-soft text-forest flex items-center gap-3 {{ $savedPhotos->isEmpty() ? 'hidden' : '' }}" role="status">
                <i class="glyph check text-forest shrink-0" aria-hidden="true"></i>
                <div class="min-w-0">
                    <strong id="file-names" class="text-label block truncate">{{ $savedPhotos->implode(' · ') }}</strong>
                    <small id="file-count" class="text-caption text-forest/80 block">{{ $savedPhotos->isNotEmpty() ? $savedPhotos->count().' foto tersimpan dalam draf' : '' }}</small>
                </div>
            </div>

            @if($savedPhotos->isNotEmpty())
                <p class="text-caption text-muted mt-2">Pilih foto baru untuk mengganti foto draf, atau langsung kirim foto yang tersimpan.</p>
            @endif

            <!-- Live photo preview container -->
            <div class="flex gap-3 flex-wrap mt-4" id="preview"></div>

            <!-- Story description textarea -->
            <div class="mt-6 flex flex-col gap-2">
                <label class="text-label text-ink" for="description">Ceritakan kegiatanmu</label>
                <textarea id="description" name="description" required maxlength="3000" rows="4"
                    class="w-full bg-white border border-line text-ink rounded-2xl p-4 text-body focus:outline-none focus:ring-2 focus:ring-forest transition-all"
                    placeholder="Saya membersihkan area taman fakultas bersama dua teman dan memilah sampah plastik serta kertas.">{{ old('description', $participant->draft_description) }}</textarea>
                <small class="text-caption text-muted">Jelaskan lokasi, aktivitas, dan dampak yang kamu hasilkan.</small>
            </div>

            <!-- Ownership consent checkbox -->
            <label class="flex items-center gap-3 mt-6 cursor-pointer select-none">
                <input type="checkbox" name="ownership" value="1" required @checked(old('ownership')) class="w-5 h-5 rounded accent-forest cursor-pointer">
                <span class="text-body text-ink font-medium">Foto ini milik saya dan sesuai kegiatan yang saya lakukan.</span>
            </label>

            <!-- Action buttons -->
            <div class="flex flex-wrap gap-3 mt-8">
                <x-action class="min-w-[180px]">Kirim bukti</x-action>
                <x-action variant="secondary" type="submit" formaction="{{ route('user.evidence.draft', $participant) }}" formnovalidate>
                    Simpan & kembali
                </x-action>
            </div>
        </form>
    </section>

    <!-- Sidebar Tips & Privacy (Sesuai Frame) -->
    <aside class="bg-soft text-forest rounded-container p-6 lg:p-7 border border-line flex flex-col gap-6">
        <div>
            <h2 class="text-section text-forest font-bold mb-3">Bukti yang mudah direview</h2>
            <ol class="space-y-3 text-body">
                <li class="flex gap-2"><span>01</span> <span>Pastikan foto terang dan tidak blur.</span></li>
                <li class="flex gap-2"><span>02</span> <span>{{ $participant->mission->evidence_instructions }}</span></li>
                <li class="flex gap-2"><span>03</span> <span>Sertakan hasil kegiatan yang jelas.</span></li>
            </ol>
        </div>

        <hr class="border-line">

        <div>
            <h3 class="text-label text-forest font-bold mb-1">Privasi bukti</h3>
            <p class="text-body text-forest/90 mb-2">Foto hanya dapat dilihat oleh kamu dan admin yang berwenang.</p>
            <small class="text-caption text-forest/80 block">Jika bukti perlu diperbaiki, kamu akan menerima catatan alasan dan bisa mengirimkan revisi.</small>
        </div>
    </aside>
</div>
@endif

<!-- Submission History (Attempts) -->
@if($participant->submissions->isNotEmpty())
<section class="mt-10">
    <h2 class="text-section text-ink mb-4">Riwayat pengiriman</h2>
    <div class="flex flex-col gap-4">
    @foreach($participant->submissions as $submission)
        <article class="bg-white border border-line rounded-container p-6 shadow-sm flex flex-col gap-3">
            <div class="flex items-center justify-between gap-4">
                <strong class="text-label text-ink">Percobaan ke-{{ $submission->attempt_number }}</strong>
                @include('components.status', ['status' => $submission->status])
            </div>
            <small class="text-caption text-muted">Dikirim {{ $submission->submitted_at->locale('id')->isoFormat('D MMM YYYY, HH:mm') }}</small>
            <p class="text-body text-ink">{{ $submission->description }}</p>
            @if($submission->rejection_reason)
                <p class="text-body text-[#903E35] font-medium bg-[#F8E2DC] p-3 rounded-xl">Catatan admin: {{ $submission->rejection_reason }}</p>
            @endif
            <div class="pt-2">
                @include('components.photos')
            </div>
        </article>
    @endforeach
    </div>
</section>
@endif

@push('scripts')
<script src="{{ asset('js/evidence.js') }}"></script>
@endpush
@endsection
