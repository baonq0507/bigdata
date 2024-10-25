<div x-data="checkbox{{ $name }}">
    @if(!$canHide)
        <div>
            @if(!is_null($label))
                <label class="mb-2 form-label {{ $required ? 'required' : '' }}" for="{{ $name }}">{{ $label }}</label>
            @endif
            <template x-for="option in options" :key="option.value">
                <label class="form-check">
                    <input class="form-check-input" type="checkbox" :value="option.value"
                           x-model="selectedOptions">
                    <span class="form-check-label" x-text="option.label"></span>
                    <template x-if="option.description">
                        <span class="form-check-description" x-html="option.description"></span>
                    </template>
                </label>
            </template>
            @error('data.' . $name)
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
            @enderror
        </div>
    @endif
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Alpine.data('checkbox{{ $name }}', () => ({
            selectedOptions: @this.entangle('{{$isRelationship ? 'relations':'data'}}.{{ $name }}') || [],
            options: [],
            init() {
                this.fetchOptions();
                @this.on('form-saved', () => {
                    this.fetchOptions();
                });
            },
            fetchOptions() {
            @this.call('checkBoxOptions', '{{ $name }}').then(response => {
                this.options = response.map(item => ({
                    value: item.{{$key}},
                    label: item.{{$titleAttribute}},
                    description: item.{{$description}} || null
                }));
                let selectedOptions = [];
                @if($isRelationship)
                    selectedOptions = @this.get('relations.{{ $name }}') || [],
                @else
                    selectedOptions = @this.get('data.{{ $name }}') || [],
                @endif
                this.selectedOptions = this.selectedOptions.map(option => option.id.toString());
            });
            }
        }));
    });
</script>
