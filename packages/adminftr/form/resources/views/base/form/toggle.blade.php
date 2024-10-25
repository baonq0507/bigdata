@if(!$canHide)
    @if(!is_null($label))
        <label class="mb-2 form-label {{$required ? 'required':''}}" for="{{ $name }}">{{ $label }}</label>
    @endif
    <div class="form-check form-switch" x-data="{ checked: false }" x-init="checked = Boolean($wire.get('data.{{ $name }}'))">
        <input type="checkbox" name="{{ $name }}" id="{{$name}}" {{ $required ? 'required' : '' }}
        {{ $wireModelDirective }}="data.{{$name}}"
        class="form-check-input @error('data.'.$name) is-invalid @enderror {{ $classes }}"
        {{ $attributes }}
        :checked="checked"
        {{ !empty($placeholder) ? 'placeholder='.$placeholder : '' }}
        {{ $disabled ? 'disabled' : '' }} />
    </div>
    @error('data.'.$name)
    <div class="invalid-feedback d-block">
        {{ $message }}
    </div>
    @enderror
@endif
