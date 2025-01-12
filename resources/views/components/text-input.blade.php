@props(['type' => 'text', 'name', 'placeholder', 'icon' => null])

<div class="form-group">
    <div class="input-group">
        <input type="{{ $type }}"
               class="form-control @error($name) is-invalid @enderror"
               name="{{ $name }}"
               value="{{ old($name) }}"
               placeholder="{{ $placeholder }}"
            {{ $attributes }} >
        @if($icon)
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="{{ $icon }}"></span>
                </div>
            </div>
        @endif
    </div>
    @error($name)
    <div class="alert alert-danger text-sm mt-1 py-2">{{ $message }}</div>
    @enderror
</div>
