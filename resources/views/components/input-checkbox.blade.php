@props(['name', 'label', 'disabled' => false, 'checked' => false])

<div class="form-group clearfix">
    <div class="icheck-danger d-inline">
        <input type="checkbox" name="{{ $name }}" id="{{ $name }}"
            @disabled($disabled) @checked($checked)>
        <label for="{{ $name }}">
            {{ $label }}
        </label>
    </div>
</div>



