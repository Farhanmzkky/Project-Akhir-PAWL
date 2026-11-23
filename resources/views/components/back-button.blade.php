@props([
    'fallback' => null,
    'label' => 'Kembali',
])

@php
    $fallbackUrl = $fallback ?? (auth()->check() && auth()->user()->role === 'admin' ? route('admin.dashboard') : (auth()->check() ? route('user.dashboard') : route('landing')));
@endphp

<a href="{{ $fallbackUrl }}"
   onclick="if (window.history.length > 1 && document.referrer && document.referrer.indexOf(window.location.host) !== -1) { event.preventDefault(); window.history.back(); }"
   {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 text-label text-muted hover:text-ink transition-colors group mb-6 select-none']) }}>
    <span class="w-8 h-8 rounded-full bg-white border border-line flex items-center justify-center text-forest group-hover:bg-soft group-hover:border-forest/40 transition-all shadow-xs">
        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
        </svg>
    </span>
    <span class="font-semibold">{{ $label }}</span>
</a>
