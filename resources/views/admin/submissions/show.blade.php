@extends('layouts.app')
@section('title', 'Tinjau bukti')
@section('content')
<div class="mb-6 flex items-center justify-between">
    <h1 class="text-heading text-ink">{{ $submission->participant->mission->display_title }}</h1>
    <a href="{{ route('admin.submissions.index') }}" class="text-label text-forest hover:underline">← Kembali ke antrean</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-[1fr_360px] gap-6 items-start">
    <!-- Proof Details -->
    <article class="bg-white border border-line rounded-container p-6 lg:p-8 shadow-[0_6px_0_rgba(38,62,48,0.05)] flex flex-col gap-6">
        <div class="flex items-center justify-between gap-4 border-b border-line pb-4">
            <div>
                <strong class="text-section text-ink block">{{ $submission->participant->user->name }}</strong>
                <span class="text-caption text-muted">Percobaan ke-{{ $submission->attempt_number }} · {{ $submission->submitted_at }} · Snapshot +{{ $submission->participant->reward_xp_snapshot }} XP</span>
            </div>
            @include('components.status', ['status' => $submission->status])
        </div>

        <div>
            <h2 class="text-label text-muted uppercase font-bold tracking-wider mb-1">Petunjuk misi</h2>
            <p class="text-body text-ink bg-ivory p-4 rounded-xl border border-line">{{ $submission->participant->mission->evidence_instructions }}</p>
        </div>

        <div>
            <h2 class="text-label text-muted uppercase font-bold tracking-wider mb-1">Cerita peserta</h2>
            <p class="text-body text-ink bg-soft/50 p-4 rounded-xl border border-line">{{ $submission->description }}</p>
        </div>

        <div>
            <h2 class="text-label text-muted uppercase font-bold tracking-wider mb-2">Foto bukti</h2>
            @include('components.photos')
        </div>
    </article>

    <!-- Admin Decision Panel -->
    <aside class="bg-white border border-line rounded-container p-6 shadow-[0_6px_0_rgba(38,62,48,0.05)] flex flex-col gap-6">
        <h2 class="text-section text-ink">Keputusan verifikasi</h2>

        @if($submission->status === 'pending')
            <form method="POST" action="{{ route('admin.submissions.approve', $submission) }}">
                @csrf
                <x-action class="w-full">Setujui & berikan XP</x-action>
            </form>

            <hr class="border-line">

            <form class="flex flex-col gap-3" method="POST" action="{{ route('admin.submissions.reject', $submission) }}">
                @csrf
                <label class="flex flex-col gap-1.5">
                    <span class="text-label text-ink">Alasan penolakan</span>
                    <textarea name="reason" required maxlength="1500" rows="3"
                        class="w-full bg-white border border-line text-ink rounded-btn p-3 text-body focus:outline-none focus:ring-2 focus:ring-[#903E35]"
                        placeholder="Contoh: Foto kurang jelas atau belum menunjukkan tumbler saat digunakan.">{{ old('reason') }}</textarea>
                </label>
                <x-action variant="danger" class="w-full">Tolak dan minta perbaikan</x-action>
            </form>
        @else
            <div class="bg-soft p-4 rounded-xl text-body text-forest flex flex-col gap-1">
                <span>Ditinjau oleh: <strong>{{ $submission->reviewer?->name ?? 'Admin' }}</strong></span>
                <span class="text-caption text-muted">Pada {{ $submission->reviewed_at }}</span>
            </div>
            @if($submission->rejection_reason)
                <div class="bg-[#F8E2DC] p-4 rounded-xl text-body text-[#903E35]">
                    <strong>Catatan penolakan:</strong>
                    <p class="mt-1">{{ $submission->rejection_reason }}</p>
                </div>
            @endif
        @endif
    </aside>
</div>
@endsection
