@props(['type' => 'text', 'name', 'value' => old($name), 'label' => false, 'placeholder', 'messages' => null])

<div class="form-group">
    @if($label)
        <label for="{{ $name }}" class="mb-1">{{ $label }}</label>
    @endif
    <input type="{{ $type }}"
           class="form-control {{ !empty($messages) ? 'is-invalid' : '' }}"
           name="{{ $name }}"
           value="{{ $value }}"
           id="{{ $name }}"
           placeholder="{{ $placeholder }}"
        {{ $attributes }} >
        <x-input-error :messages="$messages"/>
</div>




