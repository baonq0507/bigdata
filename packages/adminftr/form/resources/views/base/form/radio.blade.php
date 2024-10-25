@if(!$canHide)
    @php
        $required = $isRequired ? 'required' : '';
        $classes = !empty($classes) ? 'form-check-input '.$classes : 'form-check-input';
        $wireModelDirective = $reactive ? 'wire:model.live.debounce.500ms' : 'wire:model';
    @endphp

    @if($label)
        <label class="mb-2 form-label {{ $isRequired ? 'required' : '' }}" for="{{ $name }}">{{ $label }}</label>
    @endif

    @foreach($options as $index => $option)
        <div class="form-check">
            <input type="radio" name="{{ $name }}" value="{{ $option['value'] }}"
            {{ $wireModelDirective }}="data.{{ $name }}"
            id="{{ $name }}-{{ $option['value'] }}-{{ $index }}"
            {{ $required }} class="{{ $classes }}" {!! $attributes !!}>
            <label class="form-check-label" for="{{ $name }}-{{ $option['value'] }}-{{ $index }}">
                {{ $option['label'] }}
            </label>
        </div>
    @endforeach

    @error('data.'.$name)
    <div class="invalid-feedback d-block">
        {{ $message }}
    </div>
    @enderror
@endif
