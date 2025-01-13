@props(['name', 'selected' => false, 'disabled' => false, 'label' => false, 'values'])

<div class="form-group">
    @if($label)
        <label for="{{ $name }}" class="mb-1">{{ $label }}</label>
    @endif

    <select class="form-control" name="{{ $name }}" id="{{ $name }}">
        @if($disabled)
            <option disabled selected>{{ $disabled }}</option>
        @endif

        @foreach($values as $value)
            @if($value == $selected)
                <option value="{{ $value }}" selected>{{ $value }}</option>
            @else
                <option value="{{ $value }}" @selected(old($name) == $value)>{{ $value }}</option>
            @endif
        @endforeach
    </select>
</div>




