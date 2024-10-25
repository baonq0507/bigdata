<div wire:ignore>
    <form class="offcanvas offcanvas-end" wire:submit.prevent="submitFilter" tabindex="-1" id="offcanvasEnd"
          aria-labelledby="offcanvasEndLabel">
        <div class="offcanvas-header">
            <h2 class="offcanvas-title" id="offcanvasEndLabel">Filter</h2>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="row">
                @foreach($this->defineFilters() as $InputFilter)
                    <div class="col-md-12">
                        {{ $InputFilter->render() }}
                    </div>
                @endforeach
            </div>
        </div>
        <div class="offcanvas-footer mt-auto py-3">
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </div>
    </form>
</div>
