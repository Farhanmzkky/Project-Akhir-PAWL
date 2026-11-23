@extends('layouts.app')
@section('title', 'Kelola peserta')
@section('content')
<h1 class="text-heading text-ink mb-6">Kelola peserta</h1>

<div class="bg-white border border-line rounded-container overflow-hidden shadow-[0_6px_0_rgba(38,62,48,0.05)]">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-body border-collapse">
            <thead>
                <tr class="bg-soft border-b border-line text-forest font-semibold text-label">
                    <th class="px-6 py-4">Nama peserta</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Status akun</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line">
            @forelse($users as $user)
                <tr class="hover:bg-ivory/60 transition-colors">
                    <td class="px-6 py-4 font-bold text-ink">{{ $user->name }}</td>
                    <td class="px-6 py-4 text-muted">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-caption font-semibold {{ $user->is_active ? 'bg-soft text-forest' : 'bg-[#F8E2DC] text-[#903E35]' }}">
                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="inline"
                              data-confirm="Apakah kamu yakin ingin {{ $user->is_active ? 'menonaktifkan' : 'mengaktifkan kembali' }} akun peserta '{{ $user->name }}'?"
                              data-confirm-title="{{ $user->is_active ? 'Konfirmasi Nonaktifkan Akun' : 'Konfirmasi Aktifkan Akun' }}"
                              data-confirm-btn="Ya, {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                              data-confirm-variant="{{ $user->is_active ? 'danger' : 'primary' }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="is_active" value="{{ $user->is_active ? 0 : 1 }}">
                            <button type="submit" class="text-label font-semibold hover:underline cursor-pointer {{ $user->is_active ? 'text-[#903E35]' : 'text-forest' }}">
                                {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-muted">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <span class="text-3xl">👥</span>
                            <span class="text-label text-ink font-semibold">Belum ada peserta terdaftar</span>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $users->links() }}
</div>
@endsection
