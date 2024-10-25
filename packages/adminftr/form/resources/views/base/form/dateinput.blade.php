@php
    $required = $isRequired ? 'required' : '';
    $classes = !empty($classes) ? 'form-control '.$classes : 'form-control';
    $placeholder = isset($placeholder) ? 'placeholder='.$placeholder : '';
@endphp

@if(!$canHide)
    <div wire:ignore>
        <div id="{{ $name }}_datepicker" x-data="{{ $name }}datepicker" >
            @if($label)
                <label class="mb-2 form-label {{$required ? 'required':''}}" for="{{ $name }}">{{ $label }}</label>
            @endif
            <input name="{{ $name }}" id="{{ $name }}"
                   {{ $required }} class="{{ $classes }}" {{ $attributes }} {{ $placeholder }}>
            @error('data.'.$name)
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
            @enderror
        </div>
        <script>
            document.addEventListener('livewire:init', () => {
                Alpine.data('{{ $name }}datepicker', () => ({
                    init() {
                        flatpickr("#{{ $name }}", {
                            enableTime: true,
                            dateFormat: "{{ $format }}",
                            time_24hr: true,
                            onChange: function (selectedDates, dateStr, instance) {
                            @this.set("data.{{ $name }}", dateStr, {{$reactive ? "true" : "false"}})
                                ;
                            },
                            defaultDate: @this.get("data.{{ $name }}"),
                            locale: {
                                firstDayOfWeek: 1,
                                weekdays: {
                                    shorthand: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
                                    longhand: [
                                        "Sunday",
                                        "Monday",
                                        "Tuesday",
                                        "Wednesday",
                                        "Thursday",
                                        "Friday",
                                        "Saturday",
                                    ],
                                },
                                months: {
                                    shorthand: [
                                        "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                                        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
                                    ],
                                    longhand: [
                                        "January", "February", "March",
                                        "April", "May", "June", "July",
                                        "August", "September", "October",
                                        "November", "December",
                                    ],
                                },
                            },
                        });
                    }
                }));
            });
        </script>
        @error('data.'.$name)
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
        @enderror
    </div>
@endif
