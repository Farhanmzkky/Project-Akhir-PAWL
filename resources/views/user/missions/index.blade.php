@extends('layouts.app')
@section('title', 'Jelajahi misi')
@section('content')
<h1>Jelajahi misi</h1>
<form class="filters" method="GET" action="{{ route('user.missions.index') }}">
    <label>Level<select name="level"><option value="">Semua level</option>
    @foreach(config('gamification.levels') as $number => $item)
        <option value="{{ $number }}" @selected(request('level') == $number)>Level {{ $number }}</option>
    @endforeach</select></label>
    <label>Kategori<select name="category"><option value="">Semua kategori</option>
    @foreach(config('gamification.categories') as $category)
        <option @selected(request('category') === $category)>{{ $category }}</option>
    @endforeach</select></label>
    <x-action>Terapkan</x-action><a href="{{ route('user.missions.index') }}">Reset</a>
</form>
<div class="grid cards">
@forelse($missions as $mission)
    @include('components.mission-card', ['participation' => $joined->get($mission->id)])
@empty <p>Belum ada misi yang cocok dengan filter ini.</p>
@endforelse
</div>
@endsection
