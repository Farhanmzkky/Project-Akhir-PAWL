@extends('layouts.app')
@section('title', 'Jelajahi misi')
@section('content')
<h1 class="text-heading text-ink mb-6">Jelajahi misi</h1>

<form class="bg-white border border-line rounded-container p-5 mb-8 flex flex-wrap items-end gap-4 shadow-sm" method="GET" action="{{ route('user.missions.index') }}">
    <label class="flex flex-col gap-1.5 min-w-[180px]">
        <span class="text-label text-ink">Level</span>
        <select name="level" class="bg-ivory border border-line text-ink rounded-btn px-4 py-2 text-body focus:outline-none focus:ring-2 focus:ring-forest">
            <option value="">Semua level</option>
            @foreach(config('gamification.levels') as $number => $item)
                <option value="{{ $number }}" @selected(request('level') == $number)>Level {{ $number }}</option>
            @endforeach
        </select>
    </label>

    <label class="flex flex-col gap-1.5 min-w-[200px]">
        <span class="text-label text-ink">Kategori</span>
        <select name="category" class="bg-ivory border border-line text-ink rounded-btn px-4 py-2 text-body focus:outline-none focus:ring-2 focus:ring-forest">
            <option value="">Semua kategori</option>
            @foreach(config('gamification.categories') as $category)
                <option @selected(request('category') === $category)>{{ $category }}</option>
            @endforeach
        </select>
    </label>

    <div class="flex items-center gap-3">
        <x-action>Terapkan</x-action>
        <a href="{{ route('user.missions.index') }}" class="text-label text-muted hover:text-ink px-2 py-2">Reset filter</a>
    </div>
</form>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
@forelse($missions as $mission)
    @include('components.mission-card', ['participation' => $joined->get($mission->id)])
@empty
    <div class="col-span-3 bg-white border border-line rounded-container p-12 text-center text-body text-muted">
        Belum ada misi yang cocok dengan filter yang dipilih.
    </div>
@endforelse
</div>
@endsection
