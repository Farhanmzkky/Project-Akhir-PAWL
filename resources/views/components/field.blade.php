@props(['name', 'label', 'type' => 'text', 'value' => '', 'required' => true])

<label class="flex flex-col gap-1.5 w-full">
    <span class="text-label text-ink">{{ $label }}</span>
    <input name="{{ $name }}" type="{{ $type }}" @if($required) required @endif
        @if($type !== 'password') value="{{ old($name, $value) }}" @endif
        {{ $attributes->merge(['class' => 'w-full bg-white border border-line text-ink rounded-btn px-4 py-2.5 text-body focus:outline-none focus:ring-2 focus:ring-forest focus:border-transparent transition-all']) }}>
</label>
