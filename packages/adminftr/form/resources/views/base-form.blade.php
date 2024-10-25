<form wire:submit.prevent="save">
    <div class="d-flex justify-content-end mb-4 btn-list">
        @if($this->Actions())
            @foreach($this->Actions() as $action)
                @if($action->hidden)
                    {!! $action->render() !!}
                @endif
            @endforeach
        @endif
        <button type="submit" class="btn btn-primary me-2">
                <span class="indicator-label" wire:target="save" wire:loading.class="d-none">
                    <i class="fas fa-save"></i> {{ __('future::forms.save') }}
                </span>
            <span class="indicator-progress d-none" wire:target="save" wire:loading.class.remove="d-none">
                    {{ __('future::forms.please_wait') }}
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
        </button>
        <button type="reset" class="btn btn-secondary ">
            <i class="fas fa-undo"></i> <span class="ms-1">{{ __('future::forms.reset') }}</span>
        </button>
        <button type="button" class="btn" onclick="window.history.back();">
            <i class="fas fa-arrow-left"></i> <span class="ms-1">{{ __('future::forms.back') }}</span>
        </button>
    </div>
    @foreach($this->form->render() as $input)
        {!! $input->render() !!}
    @endforeach

</form>
