@php
    $required = $isRequired ? 'required' : '';
    $classes = !empty($classes) ? 'form-control '.$classes : 'form-control';
    $min = isset($min) ? 'min='.$min : '';
    $max = isset($max) ? 'max='.$max : '';
    $step = isset($step) ? 'step='.$step : '';
    $placeholder = isset($placeholder) ? 'placeholder='.$placeholder : '';
@endphp
@if(!$canHide)
    <div>
        @if($label)
            <label class="form-label {{$required}}" for="{{ $name }}">{{ $label }}</label>
        @endif

        <input  name="{{ $name }}" wire:model="data.{{ $name }}"
               x-mask:dynamic="$money($input, ',')"
                {{ $wireModelDirective }}="data.{{$name}}"
               {{ $required }} class="{{ $classes }}
                @error('data.'.$name) is-invalid @enderror"
            {{ $attributes }} {{ $placeholder }}>
            @error('data.'.$name)
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
            @enderror
    </div>
@endif
