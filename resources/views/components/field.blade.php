@props([
    'name',
    'label',
    'type' => 'text',
    'value' => '',
    'required' => true,
    'hint' => null
])

@php
    $hasError = $errors->has($name);
    $borderClass = $hasError ? 'border-[#903E35] focus:ring-[#903E35]' : 'border-line focus:ring-forest';
@endphp

<label class="flex flex-col gap-1.5 w-full">
    <div class="flex items-center justify-between">
        <span class="text-label text-ink">{{ $label }}</span>
        @if($required)
            <span class="text-caption text-muted">*wajib</span>
        @endif
    </div>
    <input name="{{ $name }}"
           id="{{ $attributes->get('id', $name) }}"
           type="{{ $type }}"
           @if($required) required @endif
           @if($type !== 'password') value="{{ old($name, $value) }}" @endif
           {{ $attributes->merge(['class' => "w-full bg-white border $borderClass text-ink rounded-btn px-4 py-2.5 text-body focus:outline-none focus:ring-2 focus:border-transparent transition-all"]) }}>
    @if($hint && !$hasError)
        <small class="text-caption text-muted">{{ $hint }}</small>
    @endif
    @error($name)
        <span class="text-caption text-[#903E35] font-semibold flex items-center gap-1.5 mt-0.5" role="alert">
            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            {{ $message }}
        </span>
    @enderror
</label>
