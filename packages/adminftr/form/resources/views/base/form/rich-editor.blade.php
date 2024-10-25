<div id="{{ $name }}_container" x-data="{{ $name }}editor">
    <label class="form-label {{$required ? 'required':''}}" for="{{$name}}">{{$label}}</label>
    <textarea id="{{$name}}" name="{{$name}}" wire:model="data.{{$name}}" :class="classes" :required="required"></textarea>
</div>
<script>
    document.addEventListener('livewire:init', () => {
        Alpine.data('{{ $name }}editor', () => ({
            init() {
                this.initTinyMCE();
            },
            name: '{{ $name }}',
            classes: '{{ $classes }}',
            required: '{{ $required }}',
            attributes: '{{ $attributes }}',
            initTinyMCE() {
                if (tinymce.get("{{ $name }}")) {
                    tinymce.remove('#' + '{{ $name }}');
                }
                tinymce.init({
                    selector: '#{{ $name }}',
                    plugins: '{{ $plugins }}',
                    toolbar_mode: 'floating',
                    branding: false,
                    promotion: false,
                    readonly: false,
                    toolbar: '{{ $toolbar }}',
                    height: '{{ $height }}',
                    menubar: '{{ $menubar }}',
                    statusbar: true,
                    setup: (editor) => {
                        editor.on('change', () => {
                        @this.set('data.' + this.name, editor.getContent(), false)
                            ;
                        });
                    }
                });


            }
        }));
    });
</script>
