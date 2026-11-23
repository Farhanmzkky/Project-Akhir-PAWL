@extends('layouts.app')
@section('title', 'Form misi')
@section('content')
<h1>{{ $mission->exists ? 'Edit misi' : 'Tambah misi' }}</h1>
<form class="panel form-stack" method="POST" action="{{ $mission->exists ? route('admin.missions.update', $mission) : route('admin.missions.store') }}">
    @csrf @if($mission->exists) @method('PUT') @endif
    <x-field name="title" label="Nama misi" :value="$mission->title" maxlength="120" />
    <label>Deskripsi<textarea name="description" required maxlength="3000">{{ old('description', $mission->description) }}</textarea></label>
    <label>Kategori<select name="category">@foreach(config('gamification.categories') as $category)
        <option @selected(old('category', $mission->category) === $category)>{{ $category }}</option>
    @endforeach</select></label>
    <x-field name="required_level" type="number" label="Level minimum" :value="$mission->required_level ?? 1" min="1" max="5" />
    <x-field name="xp_reward" type="number" label="Reward XP" :value="$mission->xp_reward" min="1" max="10000" />
    <label>Petunjuk bukti<textarea name="evidence_instructions" required maxlength="1500">{{ old('evidence_instructions', $mission->evidence_instructions) }}</textarea></label>
    <label>Status<select name="is_active">
        <option value="1" @selected(old('is_active', $mission->is_active))>Aktif</option>
        <option value="0" @selected(!old('is_active', $mission->is_active))>Nonaktif</option>
    </select></label>
    <x-action>Simpan misi</x-action>
</form>
@endsection
