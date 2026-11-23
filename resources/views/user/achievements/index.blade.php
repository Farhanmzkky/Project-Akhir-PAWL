@extends('layouts.app')
@section('title', 'Kebunku')
@section('content')
<header class="mb-6 anim-fade-up">
    <h1 class="text-heading text-ink">Kebunku</h1>
    <p class="text-body text-muted mt-1">{{ $owned->count() }} dari {{ $badges->count() }} badge pencapaian telah terbuka.</p>
</header>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
@foreach($badges as $badge)
    @php $isOwned = $owned->contains($badge->id); @endphp
    <article class="border rounded-container p-6 flex flex-col justify-between transition-all duration-200
                    shadow-[0_6px_0_rgba(38,62,48,0.05)] row-anim
                    {{ $isOwned
                        ? 'bg-white border-line hover:-translate-y-1.5 hover:shadow-[0_12px_30px_rgba(24,63,50,0.12)] hover:border-forest cursor-default'
                        : 'bg-soft/40 border-line/60 opacity-60' }}"
             style="animation-delay: {{ $loop->index * 0.07 }}s">
        <div>
            <span class="text-5xl block mb-3 transition-transform duration-300 {{ $isOwned ? 'hover:scale-110' : '' }}" aria-hidden="true">{{ $badge->icon }}</span>
            <h2 class="text-section text-ink">{{ $badge->name }}</h2>
            <p class="text-body text-muted mt-1">{{ $badge->description }}</p>
        </div>
        <div class="pt-4 border-t border-line/60 mt-4 flex items-center justify-between">
            <span class="text-caption font-semibold {{ $isOwned ? 'text-forest' : 'text-muted' }}">
                {{ $isOwned ? '✓ Sudah diperoleh' : '🔒 Masih terkunci' }}
            </span>
            @if($isOwned)
                <span class="text-caption bg-soft text-forest px-2.5 py-0.5 rounded-full font-semibold">🌿 Aktif</span>
            @endif
        </div>
    </article>
@endforeach
</div>
@endsection
