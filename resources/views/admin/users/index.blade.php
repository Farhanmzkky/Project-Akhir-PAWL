@extends('layouts.app')
@section('title', 'Kelola peserta')
@section('content')
<h1>Kelola peserta</h1><div class="table-wrap"><table><thead><tr><th>Peserta</th><th>Email</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
@forelse($users as $user)
    <tr><td>{{ $user->name }}</td><td>{{ $user->email }}</td><td>{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</td><td>
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf @method('PATCH') <input type="hidden" name="is_active" value="{{ $user->is_active ? 0 : 1 }}">
            <button class="linklike">{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button>
        </form></td></tr>
@empty <tr><td colspan="4">Belum ada peserta terdaftar.</td></tr>
@endforelse
</tbody></table></div>{{ $users->links('pagination::simple-bootstrap-5') }}
@endsection
