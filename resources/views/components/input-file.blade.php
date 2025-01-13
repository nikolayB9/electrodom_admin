@props(['name', 'label' => false, 'placeholder' => 'Изображение', 'messages' => null])

<div class="form-group">
    @if($label)
        <label for="{{ $name }}" class="mb-1">{{ $label }}</label>
    @endif

    <div class="input-group">
        <div class="custom-file">
            <input type="file"
                   class="custom-file-input @error($name) is-invalid @enderror"
                   id="{{ $name }}"
                   name="{{ $name }}">
            <label class="custom-file-label" for="{{ $name }}">{{ $placeholder }}</label>
        </div>
    </div>
    <x-input-error :messages="$messages"/>
</div>



