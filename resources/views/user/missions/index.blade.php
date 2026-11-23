@extends('layouts.app')
@section('title', 'Jelajahi misi')
@section('content')
<h1 class="text-heading text-ink mb-6 anim-fade-up">Ayo explore misimu!</h1>

<form class="bg-white border border-line rounded-container p-5 mb-8 flex flex-wrap items-end gap-4 shadow-sm anim-fade-up delay-1" method="GET" action="{{ route('user.missions.index') }}">
    <label class="flex flex-col gap-1.5 min-w-[180px]">
        <span class="text-label text-ink">Level</span>
        <select name="level" class="bg-ivory border border-line text-ink rounded-btn px-4 py-2 text-body focus:outline-none focus:ring-2 focus:ring-forest transition-all">
            <option value="">Semua level</option>
            @foreach(config('gamification.levels') as $number => $item)
                <option value="{{ $number }}" @selected(request('level') == $number)>Level {{ $number }}</option>
            @endforeach
        </select>
    </label>

    <label class="flex flex-col gap-1.5 min-w-[200px]">
        <span class="text-label text-ink">Kategori</span>
        <select name="category" class="bg-ivory border border-line text-ink rounded-btn px-4 py-2 text-body focus:outline-none focus:ring-2 focus:ring-forest transition-all">
            <option value="">Semua kategori</option>
            @foreach(config('gamification.categories') as $category)
                <option @selected(request('category') === $category)>{{ $category }}</option>
            @endforeach
        </select>
    </label>

    <div class="flex items-center gap-3">
        <x-action>Terapkan</x-action>
        <a href="{{ route('user.missions.index') }}" class="text-label text-muted hover:text-ink px-2 py-2 transition-colors">Reset filter</a>
    </div>
</form>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
@forelse($missions as $mission)
    <div class="row-anim" style="animation-delay: {{ $loop->index * 0.06 }}s">
        @include('components.mission-card', ['participation' => $joined->get($mission->id)])
    </div>
@empty
    <div class="col-span-1 md:col-span-2 lg:col-span-3 bg-white border border-line rounded-container p-12 text-center flex flex-col items-center justify-center gap-3 anim-fade shadow-sm">
        <div class="w-16 h-16 rounded-full bg-soft text-forest flex items-center justify-center text-2xl">
            🌱
        </div>
        <h3 class="text-section text-ink font-bold">Tidak ada misi yang cocok</h3>
        <p class="text-body text-muted max-w-md">
            Coba ubah filter level atau kategori untuk menemukan misi lain yang siap kamu kerjakan.
        </p>
        <a href="{{ route('user.missions.index') }}"
           class="mt-2 inline-flex items-center justify-center min-h-[42px] px-6 rounded-btn bg-forest text-white text-label font-semibold hover:bg-forest-hover transition-colors shadow-sm">
            Tampilkan Semua Misi
        </a>
    </div>
@endforelse
</div>
@endsection
