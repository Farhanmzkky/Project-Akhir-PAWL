@extends('layouts.app')
@section('title', 'Kelola misi')
@section('content')
<div class="spread"><h1>Kelola misi</h1><a class="action" href="{{ route('admin.missions.create') }}">Tambah misi</a></div>
<div class="table-wrap"><table><thead><tr><th>Misi</th><th>Level</th><th>Reward</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
@forelse($missions as $mission)
    <tr><td>{{ $mission->title }}</td><td>{{ $mission->required_level }}</td><td>{{ $mission->xp_reward }} XP</td>
    <td>{{ $mission->is_active ? 'Aktif' : 'Nonaktif' }}</td><td><a href="{{ route('admin.missions.edit', $mission) }}">Edit</a></td></tr>
@empty <tr><td colspan="5">Belum ada misi.</td></tr>
@endforelse
</tbody></table></div>
@endsection
