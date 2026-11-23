@extends('layouts.app')
@section('title', 'Leaderboard')
@section('content')
<h1>Leaderboard</h1><p>Peringkat sepanjang waktu berdasarkan XP dari misi yang disetujui.</p>
<div class="table-wrap"><table><thead><tr><th>Peringkat</th><th>Peserta</th><th>Level</th><th>Misi selesai</th><th>Total XP</th></tr></thead><tbody>
@foreach($users as $user)
    <tr @class(['current' => $user->id === auth()->id()])>
    <td>#{{ $users->firstItem() + $loop->index }}</td><td>{{ $user->name }} {{ $user->id === auth()->id() ? '(kamu)' : '' }}</td>
    <td>{{ \App\Services\GamificationService::level($user->total_xp) }}</td><td>{{ $user->completed_count }}</td><td>{{ $user->total_xp }}</td></tr>
@endforeach
</tbody></table></div>{{ $users->links('pagination::simple-bootstrap-5') }}
@endsection
