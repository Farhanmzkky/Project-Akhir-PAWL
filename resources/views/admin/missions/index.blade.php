@extends('layouts.app')
@section('title', 'Kelola misi')
@section('content')
<div class="flex items-center justify-between gap-4 mb-6">
    <h1 class="text-heading text-ink">Kelola misi</h1>
    <x-action :href="route('admin.missions.create')" onclick="window.location='{{ route('admin.missions.create') }}'">Tambah misi baru</x-action>
</div>

<div class="bg-white border border-line rounded-container overflow-hidden shadow-[0_6px_0_rgba(38,62,48,0.05)]">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-body border-collapse">
            <thead>
                <tr class="bg-soft border-b border-line text-forest font-semibold text-label">
                    <th class="px-6 py-4">Nama misi</th>
                    <th class="px-6 py-4">Level</th>
                    <th class="px-6 py-4">Reward XP</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line">
            @forelse($missions as $mission)
                <tr class="hover:bg-ivory/60 transition-colors">
                    <td class="px-6 py-4 font-bold text-ink">{{ $mission->title }}</td>
                    <td class="px-6 py-4 text-muted">Level {{ $mission->required_level }}</td>
                    <td class="px-6 py-4 text-forest font-semibold">+{{ $mission->xp_reward }} XP</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-caption font-semibold {{ $mission->is_active ? 'bg-soft text-forest' : 'bg-gray-200 text-gray-600' }}">
                            {{ $mission->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.missions.edit', $mission) }}" class="text-label text-forest font-semibold hover:underline">
                            Edit
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-muted">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <span class="text-3xl">🎯</span>
                            <span class="text-label text-ink font-bold">Belum ada misi yang dibuat</span>
                            <a href="{{ route('admin.missions.create') }}" class="text-caption text-forest font-bold hover:underline mt-1">
                                + Tambah Misi Baru Sekarang
                            </a>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
