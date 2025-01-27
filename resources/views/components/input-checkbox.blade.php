@props(['name', 'label', 'disabled' => false, 'checked' => false, 'class' => 'icheck-danger'])

<div class="form-group clearfix">
    <div class="{{ $class }} d-inline">
        <input type="checkbox" name="{{ $name }}" id="{{ $name }}"
            @disabled($disabled) @checked($checked)>
        <label for="{{ $name }}">
            {{ $label }}
        </label>
    </div>
</div>



