@extends('layouts.app')
@section('title', 'Verifikasi bukti')
@section('content')
<div class="spread"><h1>{{ $history ? 'Riwayat verifikasi' : 'Antrean bukti' }}</h1>
<a href="{{ route($history ? 'admin.submissions.index' : 'admin.submissions.history') }}">{{ $history ? 'Buka antrean' : 'Lihat riwayat' }}</a></div>
<div class="table-wrap"><table><thead><tr><th>Peserta dan misi</th><th>Dikirim</th><th>Status</th><th>Bukti</th></tr></thead><tbody>
@forelse($submissions as $submission)
<tr><td><strong>{{ $submission->participant->user->name }}</strong><br>{{ $submission->participant->mission->display_title }}</td>
    <td>{{ $submission->submitted_at }}</td><td>@include('components.status', ['status' => $submission->status])</td>
    <td><a href="{{ route('admin.submissions.show', $submission) }}">Buka bukti</a></td></tr>
@empty <tr><td colspan="4">{{ $history ? 'Belum ada keputusan verifikasi.' : 'Semua bukti sudah ditangani atau belum ada pengiriman.' }}</td></tr>
@endforelse
</tbody></table></div>{{ $submissions->links('pagination::simple-bootstrap-5') }}
@endsection
