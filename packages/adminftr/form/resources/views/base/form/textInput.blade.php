@if(!$canHide)
    @if(!is_null($label))
        <label class="mb-2 form-label {{$required ? 'required':''}}" for="{{ $name }}">{{ $label }}</label>
    @endif
    <div class="row g-1">
        <div class="col">
            <input type="{{ $type }}" name="{{ $name }}" id="{{$name}}" {{ $required ? 'required' : '' }}
            {{ $wireModelDirective }}="data.{{$name}}"
            class="form-control @error('data.'.$name) is-invalid @enderror {{ $classes }}"
            {{ $attributes }} {{ !is_null($defaultValue) ? 'value='.$defaultValue : '' }}
            {{ !empty($placeholder) ? 'placeholder='.$placeholder : '' }}
            {{ !is_null($maxLength) ? 'maxlength='.$maxLength : '' }}
            {{ !is_null($pattern) ? 'pattern='.$pattern : '' }}
            autocomplete="{{ $autocomplete }}" {{ $readOnly ? 'readonly' : '' }}
            {{ $disabled ? 'disabled' : '' }} {{ !is_null($size) ? 'size='.$size : '' }}
            {{ !is_null($step) ? 'step='.$step : '' }}>
        </div>
        <div class="col-auto">
            @if($action)
                @if($action['type'] == 'method')
                    <a href="#" class="btn btn-icon" wire:click="inputActions('{{$name}}')" aria-label="Button">
                        @if($action['icon'])
                            <i class="{{$action['icon']}}" wire:loading.remove wire:target="data.{{$name}}"></i>
                            <span class="spinner-border d-none spinner-border-sm me-2" role="status"
                                  wire:loading.class="d-none" wire:target="data.{{$name}}"
                            ></span>
                        @endif

                    </a>
                @elseif($action->type == 'modal')
                    <a href="#" class="btn btn-icon" aria-label="Button" data-bs-toggle="modal"
                       data-bs-target="#{{$action->modal}}">
                        @if($action->icon)
                            <i class="{{$action->icon}}"></i>
                        @endif
                        {{$action->label ?? ''}}
                    </a>
                @endif
            @endif

        </div>
    </div>

    @error('data.'.$name)
    <div class="invalid-feedback d-block">
        {{ $message }}
    </div>
    @enderror
@endif

