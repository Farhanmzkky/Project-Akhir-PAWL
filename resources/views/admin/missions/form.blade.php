@extends('layouts.app')
@section('title', 'Form misi')
@section('content')

<x-back-button :fallback="route('admin.missions.index')" label="Kembali ke Kelola Misi" />

<div class="max-w-2xl anim-scale">
    <h1 class="text-heading text-ink mb-6">{{ $mission->exists ? 'Edit misi' : 'Tambah misi baru' }}</h1>

    <form class="bg-white border border-line rounded-container p-8 shadow-[0_6px_0_rgba(38,62,48,0.05)] flex flex-col gap-6"
          method="POST"
          action="{{ $mission->exists ? route('admin.missions.update', $mission) : route('admin.missions.store') }}">
        @csrf
        @if($mission->exists) @method('PUT') @endif

        {{-- Nama misi --}}
        <div class="flex flex-col gap-1.5 anim-fade-up delay-1">
            <label class="text-label text-ink" for="title">Nama misi</label>
            <input id="title" name="title" type="text" required maxlength="120"
                   value="{{ old('title', $mission->title) }}"
                   class="w-full bg-ivory border border-line text-ink rounded-btn px-4 py-2.5 text-body
                          focus:outline-none focus:ring-2 focus:ring-forest transition-all">
            @error('title')
                <span class="text-caption text-[#903E35]">{{ $message }}</span>
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div class="flex flex-col gap-1.5 anim-fade-up delay-2">
            <label class="text-label text-ink" for="description">Deskripsi</label>
            <textarea id="description" name="description" required maxlength="3000" rows="4"
                      class="w-full bg-ivory border border-line text-ink rounded-2xl px-4 py-3 text-body
                             focus:outline-none focus:ring-2 focus:ring-forest transition-all resize-y">{{ old('description', $mission->description) }}</textarea>
            @error('description')
                <span class="text-caption text-[#903E35]">{{ $message }}</span>
            @enderror
        </div>

        {{-- Kategori --}}
        <div class="flex flex-col gap-1.5 anim-fade-up delay-3">
            <label class="text-label text-ink" for="category">Kategori</label>
            <select id="category" name="category"
                    class="w-full bg-ivory border border-line text-ink rounded-btn px-4 py-2.5 text-body
                           focus:outline-none focus:ring-2 focus:ring-forest transition-all">
                @foreach(config('gamification.categories') as $category)
                    <option @selected(old('category', $mission->category) === $category)>{{ $category }}</option>
                @endforeach
            </select>
        </div>

        {{-- Level minimum & Reward XP (2 kolom) --}}
        <div class="grid grid-cols-2 gap-4 anim-fade-up delay-4">
            <div class="flex flex-col gap-1.5">
                <label class="text-label text-ink" for="required_level">Level minimum</label>
                <input id="required_level" name="required_level" type="number" required min="1" max="5"
                       value="{{ old('required_level', $mission->required_level ?? 1) }}"
                       class="w-full bg-ivory border border-line text-ink rounded-btn px-4 py-2.5 text-body
                              focus:outline-none focus:ring-2 focus:ring-forest transition-all">
                @error('required_level')
                    <span class="text-caption text-[#903E35]">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex flex-col gap-1.5">
                <label class="text-label text-ink" for="xp_reward">Reward XP</label>
                <input id="xp_reward" name="xp_reward" type="number" required min="1" max="10000"
                       value="{{ old('xp_reward', $mission->xp_reward) }}"
                       class="w-full bg-ivory border border-line text-ink rounded-btn px-4 py-2.5 text-body
                              focus:outline-none focus:ring-2 focus:ring-forest transition-all">
                @error('xp_reward')
                    <span class="text-caption text-[#903E35]">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Petunjuk bukti --}}
        <div class="flex flex-col gap-1.5 anim-fade-up delay-5">
            <label class="text-label text-ink" for="evidence_instructions">Petunjuk bukti</label>
            <small class="text-caption text-muted -mt-0.5">Instruksi singkat bagi peserta tentang foto yang perlu dikirim.</small>
            <textarea id="evidence_instructions" name="evidence_instructions" required maxlength="1500" rows="3"
                      class="w-full bg-ivory border border-line text-ink rounded-2xl px-4 py-3 text-body
                             focus:outline-none focus:ring-2 focus:ring-forest transition-all resize-y">{{ old('evidence_instructions', $mission->evidence_instructions) }}</textarea>
            @error('evidence_instructions')
                <span class="text-caption text-[#903E35]">{{ $message }}</span>
            @enderror
        </div>

        {{-- Status --}}
        <div class="flex flex-col gap-1.5 anim-fade-up delay-6">
            <label class="text-label text-ink" for="is_active">Status</label>
            <select id="is_active" name="is_active"
                    class="w-full bg-ivory border border-line text-ink rounded-btn px-4 py-2.5 text-body
                           focus:outline-none focus:ring-2 focus:ring-forest transition-all">
                <option value="1" @selected(old('is_active', $mission->is_active))>Aktif</option>
                <option value="0" @selected(!old('is_active', $mission->is_active))>Nonaktif</option>
            </select>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-4 pt-2 border-t border-line anim-fade-up delay-7">
            <x-action>Simpan misi</x-action>
            <a href="{{ route('admin.missions.index') }}"
               class="text-label text-muted hover:text-ink transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
