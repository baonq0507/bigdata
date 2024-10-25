@php
    $required = $isRequired ? 'required' : '';
    $classes = !empty($classes) ? 'form-control ' . $classes : 'form-control';
@endphp

@if(!$canHide)
    <div wire:ignore>
        @if($label)
            <label class="form-label {{$required}}" for="{{$name}}">{{$label}}</label>
        @endif
        <div id="dropdown{{$name}}" x-data="dropdown{{$name}}" class="dropdown">
            <select id="{{$name}}"
                    {{$multiple ? 'multiple' : ''}} {{$required}} class="form-select {{ $classes }}"></select>
        </div>
        @error('data.'.$name)
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
        @enderror
        <script>
            document.addEventListener('livewire:init', () => {
                Alpine.data('dropdown{{$name}}', () => ({
                    init() {
                        if (!document.querySelector("#{{$name}}").classList.contains("tomselected")) {
                            const tomSelect{{$name}} = new TomSelect("#{{$name}}", {
                                valueField: "{{$valueField}}",
                                copyClassesToDropdown: false,
                                dropdownParent: "body",
                                onChange: value => this.onChange(value),
                                searchField: ["{{$labelField}}"],
                                plugins: {!! json_encode($plugins) !!},
                                maxOptions: {{$maxOptions}},
                                create: false,
                                render: {
                                    option: function (data, escape) {
                                        return "<div>" + escape(data.{{$labelField}}) + "</div>";
                                    },
                                    item: function (data, escape) {
                                        return "<div>" + escape(data.{{$labelField}}) + "</div>";
                                    }
                                },
                                load: function (query, callback) {

                                    if ({{$liveSearch ? 'true' : 'false'}}) {
                                        @this.call('searchSelect', query, "{{$name}}")
                                        .then(response => {
                                            const data = response.map(item => ({
                                            {{$valueField}}: item["{{$valueField}}"],
                                            {{$labelField}}: item["{{$labelField}}"]
                                            }));
                                            callback(data);
                                        })
                                    } else {
                                        callback();
                                    }
                                }
                            });


                            let dataParts = @this.get("relations.{{$name}}") ? @this.get("relations.{{$name}}") : @this.get("data.{{$name}}");
                            if (this.isRelationship) {
                            @this.call('searchSelect', '', "{{$name}}")
                                .then(response => {
                                    const data = response.map(item => ({
                                        {{$valueField}}: item["{{$valueField}}"],
                                        {{$labelField}}: item["{{$labelField}}"]
                                    }));
                                    tomSelect{{$name}}.addOption(data);
                                    if (Array.isArray(dataParts)) {
                                        dataParts.forEach(item => {
                                            tomSelect{{$name}}.addItem(item["{{$valueField}}"]);
                                        });
                                    }else{
                                        tomSelect{{$name}}.addItem(dataParts);
                                    }
                                });
                            } else {
                                tomSelect{{$name}}.addOption(@json($options));
                            }

                            if (!Array.isArray(dataParts)) {
                                tomSelect{{$name}}.addItem(@this.get("data.{{$name}}"));
                            }
                            document.querySelector("#{{$name}}").classList.add("tomselected");
                        }
                    },
                    onChange(value) {
                        if (@this.get("relations.{{$name}}")) {
                            @this.set("relations.{{$name}}", value,{{$reactive ? "true" : "false"}});
                        } else {
                            @this.set("data.{{$name}}", value,{{$reactive ? "true" : "false"}});
                        }
                    },
                    isRelationship: {{$isRelationship ? 'true' : 'false'}},
                }));
            });
        </script>
    </div>
@endif


