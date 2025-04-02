@props([
    'type' => 'text',
    'name',
    'value' => old($name),
    'label' => null,
    'placeholder' => null,
    'messages' => null,
    'id' => null,
])

<div class="form-group">
    @if($label)
        <label for="{{ $name }}" class="mb-1">{{ $label }}</label>
    @endif
    <input type="{{ $type }}"
           name="{{ $name }}"
           value="{{ $value }}"
           class="form-control @empty(!$messages) is-invalid @endempty"
           id="{{ $id ?? $name }}"
           placeholder="{{ $placeholder }}"
        {{ $attributes }}>
    <x-input-error :messages="$messages"/>
</div>



