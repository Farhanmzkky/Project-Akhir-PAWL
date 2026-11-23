@props([
    'variant' => 'primary', // primary (Forest), secondary (White/Line), reward (Lime), danger (Red)
    'type' => 'submit'
])

@php
    $baseClass = "inline-flex items-center justify-center min-h-[44px] px-6 rounded-btn text-label transition-all cursor-pointer font-semibold select-none";
    $variants = [
        'primary' => "bg-forest text-white shadow-[0_4px_0_rgba(24,63,50,0.20)] hover:bg-forest-hover active:translate-y-0.5 active:shadow-none",
        'secondary' => "bg-white text-forest border border-line shadow-[0_4px_0_rgba(24,63,50,0.08)] hover:bg-soft active:translate-y-0.5 active:shadow-none",
        'reward' => "bg-lime text-forest shadow-[0_4px_0_rgba(24,63,50,0.15)] hover:bg-lime-hover active:translate-y-0.5 active:shadow-none",
        'danger' => "bg-[#903E35] text-white shadow-[0_4px_0_rgba(144,62,53,0.20)] hover:bg-[#7b332b] active:translate-y-0.5 active:shadow-none",
    ];
@endphp

<button {{ $attributes->merge(['type' => $type, 'class' => "$baseClass " . ($variants[$variant] ?? $variants['primary'])]) }}>
    {{ $slot }}
</button>
