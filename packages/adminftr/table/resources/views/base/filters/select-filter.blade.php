@php
    $classes = !empty($classes) ? 'form-control ' . $classes : 'form-control';
    $parts = str_replace('.', '_', $name);
@endphp

@if($label)
    <label class="form-label" for="{{$parts}}">{{$label}}</label>
@endif
<div x-data='{
        init() {
            if (!document.querySelector("#{{$parts}}").classList.contains("tomselected")) {
                const tomSelect{{$parts}} = new TomSelect("#{{$parts}}", {
                    valueField: "{{$valueField}}",
                    onChange: value => this.onChange(value),
                    options: this.options,
                    searchField: ["{{$labelField}}"],
                    plugins: {!! json_encode($plugins) !!},
                    maxOptions: {{$maxOptions}},
                    create: false,
                    render: {
                        option: function(data, escape) {
                            return "<div>" + escape(data.{{$labelField}}) + "</div>";
                        },
                        item: function(data, escape) {
                            return "<div>" + escape(data.{{$labelField}}) + "</div>";
                        }
                    },
                    @if($liveSearch)
                    load: function(query, callback) {

                        $wire.call("filterSelect", query, "{{$name}}").then(response => {
                            const data = response.map(item => ({
                                "{{$valueField}}": item["{{$valueField}}"],
                                "{{$labelField}}": item["{{$labelField}}"]
                            }));
                            callback(data);
                        });
                    }
                    @endif
                });

                const dataParts = $wire.get("selectedRows.{{$parts}}");
                if (dataParts instanceof Object) {
                    dataParts.forEach(item => {
                        tomSelect{{$parts}}.addItem(item["{{$valueField}}"]);
                    });
                } else {
                    tomSelect{{$parts}}.addItem($wire.get("selectedRows.{{$name}}"));
                }
                document.querySelector("#{{$parts}}").classList.add("tomselected");
            }
        },
        onChange(value) {
            $wire.set("selectedRows.{{$parts}}", value,false);
        },
        searchSelect(query, name) {
            $wire.call("searchSelect", query, name).then(response => {
                this.options = response.map(item => ({
                    "{{$valueField}}": item["{{$valueField}}"],
                    "{{$labelField}}": item["{{$labelField}}"]
                }));
            });
        },
        options: @json($options)
    }' class="dropdown">
    <select id="{{$parts}}" {{$multiple ? 'multiple' : ''}}  class="{{ $classes }}"></select>
</div>
@error('data.'.$name)
<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
    <div data-field="{{$name}}" data-validator="notEmpty">{{$message}}</div>
</div>
@enderror
