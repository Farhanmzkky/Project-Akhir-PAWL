@extends('layouts.app')
@section('title', 'Verifikasi bukti')
@section('content')
<div class="flex items-center justify-between gap-4 mb-6">
    <h1 class="text-heading text-ink">{{ $history ? 'Riwayat verifikasi' : 'Antrean bukti' }}</h1>
    <a href="{{ route($history ? 'admin.submissions.index' : 'admin.submissions.history') }}" class="text-label text-forest font-semibold hover:underline">
        {{ $history ? '← Buka antrean pending' : 'Lihat riwayat verifikasi →' }}
    </a>
</div>

<div class="bg-white border border-line rounded-container overflow-hidden shadow-[0_6px_0_rgba(38,62,48,0.05)]">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-body border-collapse">
            <thead>
                <tr class="bg-soft border-b border-line text-forest font-semibold text-label">
                    <th class="px-6 py-4">Peserta dan misi</th>
                    <th class="px-6 py-4">Waktu kirim</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line">
            @forelse($submissions as $submission)
                <tr class="hover:bg-ivory/60 transition-colors">
                    <td class="px-6 py-4">
                        <strong class="text-ink block font-bold">{{ $submission->participant->user->name }}</strong>
                        <span class="text-muted text-caption">{{ $submission->participant->mission->display_title }}</span>
                    </td>
                    <td class="px-6 py-4 text-muted text-caption">{{ $submission->submitted_at }}</td>
                    <td class="px-6 py-4">@include('components.status', ['status' => $submission->status])</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.submissions.show', $submission) }}" class="inline-flex items-center px-4 py-1.5 rounded-btn bg-soft text-forest text-label font-semibold hover:bg-forest hover:text-white transition-colors">
                            Buka bukti
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-14 text-center">
                        <div class="flex flex-col items-center justify-center gap-2.5">
                            <span class="text-4xl">{{ $history ? '📋' : '✨' }}</span>
                            <strong class="text-label text-ink font-bold">
                                {{ $history ? 'Belum ada riwayat verifikasi' : 'Semua bukti telah ditinjau!' }}
                            </strong>
                            <p class="text-caption text-muted max-w-sm">
                                {{ $history ? 'Keputusan verifikasi bukti yang telah dinilai akan tercatat di halaman ini.' : 'Tidak ada antrean bukti kegiatan yang menunggu verifikasi saat ini. Kerja bagus!' }}
                            </p>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $submissions->links() }}
</div>
@endsection
