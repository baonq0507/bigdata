<div class="tree-radio mt-2" x-data="radio{{$name}}" wire:ignore>
    <label class="mb-2 form-label {{$required ? 'required':''}}" for="{{ $name }}">{{ $label }}</label>
    <div class="radio-group">
        <!-- Recursive category rendering -->
        <template x-for="(option, index) in options" :key="option.id">
            <div x-data="{ open: false }">
                <div  class="mb-3 form-check d-flex align-items-center" style="cursor: pointer;">
                    <i @click="open = !open" class="fa" :class="open ? 'fa-folder-open' : 'fa-folder'"></i>
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" :id="option.id" :value="option.id" :checked="selected === option.id" @click="selectOption(option.id)">
                        <span x-text="option.name"></span>
                    </label>
                </div>
                <!-- Recursive Sub-options -->
                <div x-show="open" class="sub-radio" style="transition: all 0.3s ease;">
                    <div x-html="renderSubOptions(option.children)"></div>
                </div>
            </div>
        </template>
    </div>
    @error('data.'.$name)
    <div class="invalid-feedback d-block">
        {{ $message }}
    </div>
    @enderror
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Alpine.data('radio{{$name}}', () => ({
            selected: @this.get('data.{{ $name }}'),
            options: [],
            toggle: function(option) {
                option.open = !option.open;
            },
            selectOption: function(id) {
                if (this.selected == id) {
                    this.selected = null;
                } else {
                    this.selected = id;
                }
                @this.set('data.{{ $name }}', this.selected);
            },
            init: function() {
            @this.optionsRadioTree('{{ $name }}').then(response => {
                this.options = response.map(option => ({
                    ...option,
                    open: false  // Ensure each option has an 'open' property
                }));
            });
            },
            renderSubOptions: function(children) {
                if (!children.length) return '';
                let html = '<div>';
                children.forEach((sub) => {
                    sub.open = sub.open || false; // Ensure 'open' state is defined
                    html += `<div x-data="{ open: false }">
                    <div class="mb-3 form-check d-flex align-items-center">
                        <i @click="open = !open" class="fa ${sub.children && sub.children.length ? (open ? 'fa-folder-open' : 'fa-folder') : 'fa-file-text'}"></i>
                        <label class="form-check-label" @click="selectOption('${sub.id}')">
                            <input type="radio" class="form-check-input" id="${sub.id}" value="${sub.id}" :checked="selected == '${sub.id}'">
                            <span>${sub.name}</span>
                        </label>
                    </div>`;
                    if (sub.children && sub.children.length) {
                        html += '<div class="sub-radio" style="transition: all 0.3s ease;" x-show="open">' + this.renderSubOptions(sub.children) + '</div>';
                    }
                    html += '</div>';
                });
                html += '</div>';
                return html;
            }
        }));
    });
</script>

