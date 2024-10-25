<div class="page-header mb-5">
    <div class="row align-items-center">
        <div class="col">
            @if($description)
                <div class="page-pretitle">
                    {{$description ?? ''}}
                </div>
            @endif
            @if($title)
                <h2 class="page-title">
                    {{$title ?? ''}}
                </h2>
            @endif
        </div>
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                @foreach( $this->headerActions() as $headerAction)
                    {{ $headerAction->render()}}
                @endforeach
                    @if($this->filters())
                        <a class="btn btn-primary" data-bs-toggle="offcanvas" href="#offcanvasEnd" role="button"
                           aria-controls="offcanvasEnd">
                            <i class="fa fa-filter"></i>
                        </a>
                    @endif
                    <div x-data="{ isToggled: false }">
                        <button type="button" class="btn btn-primary h-100"
                                data-bs-toggle="dropdown" data-bs-auto-close="outside"
                                @click="isToggled = !isToggled">
                            <i x-bind:class="isToggled ? 'fa fa-toggle-on' : 'fa fa-toggle-off'"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-arrow" wire:ignore>
                            @foreach($this->defineColumns() as $column)
                                @php
                                    $columnName = str_replace('.', '_', $column->name);
                                @endphp
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox"
                                           wire:loading.attr="disabled"
                                           wire:model.live="columnVisibility.{{ $columnName }}"
                                        {{ $column->visible ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ $columnName }}">
                                        {{ $column->label }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
