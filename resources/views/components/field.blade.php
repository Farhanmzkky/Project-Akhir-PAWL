@props(['name', 'label', 'type' => 'text', 'value' => '', 'required' => true])
<label class="field">
    <span>{{ $label }}</span>
    <input name="{{ $name }}" type="{{ $type }}" @if($required) required @endif
        @if($type !== 'password') value="{{ old($name, $value) }}" @endif {{ $attributes }}>
</label>
