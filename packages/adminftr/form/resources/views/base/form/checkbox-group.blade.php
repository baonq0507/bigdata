@if(!$canHide)
    <label class="mb-2 form-label {{$required ? 'required':''}}" for="{{ $name }}">{{ $label }}</label>
    @if(!empty($groupedOptions))
        <div x-data="{ groups: @entangle('data.'.$name) }">
            @foreach($groupedOptions as $group => $options)
                <div class="checkbox-group" id="group-{{ $group }}"
                     x-data="{
                            selectAll: false,
                            cantToggleAll: true,
                            selectedOptions: [],
                            toggleAll() {
                                this.selectAll = !this.selectAll;
                                this.selectedOptions = this.selectAll ? {{ json_encode(array_column($options, 'value')) }} : [];
                                groups['{{ $group }}'] = this.selectedOptions;
                                $wire.set('data.{{ $name }}', groups);
                            }
                         }"
                     x-init="groups['{{ $group }}'] = []">
                    <label class="mb-2 form-label">
                        <input class="form-check-input" type="checkbox" x-model="selectAll"
                               @click="toggleAll"> {{ $group }}
                    </label>
                    @foreach($options as $key => $option)
                        <label class="form-check me-2 form-check-inline">
                            <input type="checkbox"
                                   wire:model="data.{{ $name }}.{{ $group }}.{{ $option['value'] }}"
                                   id="{{ $name }}-{{ $group }}-{{ $key }}"
                                   value="{{ $option['value'] }}"
                                   {{ $required ? 'required' : '' }} class="{{ $classes }}" {{ $attributes }}
                                   x-model="selectedOptions" :value="'{{ $option['value'] }}'"
                                   @change="groups['{{ $group }}'] = selectedOptions">
                            <span class="form-check-label" for="{{ $name }}">{{ $option['label'] }}</span>
                            @if(isset($option['description']))
                                <span class="form-check-description">{{ $option['description'] }}</span>
                            @endif
                        </label>
                    @endforeach
                </div>
            @endforeach
        </div>
    @endif
    @if(!empty($ungroupedOptions))
        @foreach($ungroupedOptions as $key => $option)
            <label class="form-check me-2 form-check-inline">
                <input type="checkbox"
                       id="{{ $name }}"
                       value="{{ $option['value'] }}"
                       {{ $required ? 'required' : '' }} class="{{ $classes }}" {{ $attributes }}>
                <span class="form-check-label" for="{{ $name }}">{{ $option['label'] }}</span>
                @if(isset($option['description']))
                    <span class="form-check-description">{{ $option['description'] }}</span>
                @endif
            </label>
        @endforeach
    @endif

    @error('data.'.$name)
    <div class="invalid-feedback d-block">
        {{ $message }}
    </div>
    @enderror
@endif
