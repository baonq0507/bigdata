<div class="card-header border-0 pt-2 pb-3 d-flex justify-content-between">
    <div class="card-toolbar">
        <div class="d-flex flex-column flex-md-row justify-content-end">
            <select class="form-select form-select-solid me-2" wire:model.live.debounce.300ms="perPage">
                @foreach($this->pages as $page)
                    <option value="{{ $page }}" {{ $page == $perPage ? 'selected' : '' }}>{{ $page }}</option>
                @endforeach
            </select>
            @if($this->bulkActions())
                <div class="dropdown" :class="{'d-none': selectedRows.length === 0 ? 'd-none' : ''}">
                    <button class='btn align-text-top dropdown-toggle' type='button' data-bs-auto-close="outside" data-bs-toggle='dropdown'>{{ __('table::table.bulk_actions') }}</button>
                        <ul class='dropdown-menu'>
                            @foreach($this->bulkActions() as $bulkAction)
                                <li>{{ $bulkAction->render() }}</li>
                            @endforeach
                        </ul>
                </div>
            @endif
        </div>
    </div>
    <div class="card-title">
        <div class="d-flex align-items-center position-relative">
            <label class="form-label">
                <input type="text" class="form-control form-control-solid" wire:model.live.debounce.300ms="search"
                       placeholder="{{ __('future::messages.search') }}">
                <span class="input-icon-addon">
                    <div class="spinner-border spinner-border-sm text-secondary" wire:loading
                         wire:target="search"></div>
                    <svg xmlns="http://www.w3.org/2000/svg" wire:loading.class="d-none" wire:target="search"
                         class="icon"
                         width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <circle cx="10" cy="10" r="7"></circle>
                        <line x1="21" y1="21" x2="15" y2="15"></line>
                    </svg>
                </span>
            </label>
        </div>
    </div>
</div>
