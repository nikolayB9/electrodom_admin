@props([
    'name',
    'label' => null,
    'messages' => null,
])

<div class="form-group">
    @if($label)
        <label for="{{ $name }}" class="mb-1">{{ $label }}</label>
    @endif

        <select name="{{ $name }}"
                class="custom-select @empty(!$messages) is-invalid @endempty"
                id="{{ $name }}">
            {{ $slot }}
        </select>
    <x-input-error :messages="$messages"/>
</div>




