@props(['name', 'rows' => 3, 'label' => false, 'text' => '', 'placeholder', 'messages' => null])

<div class="form-group">
    @if($label)
        <label for="{{ $name }}" class="mb-1">{{ $label }}</label>
    @endif
    <textarea name="{{ $name }}"
              id="{{ $name }}"
              class="form-control"
              rows="{{ $rows }}"
              placeholder="Описание продукта">{{ $text }}</textarea>
    <x-input-error :messages="$messages"/>
</div>







