@if($data && count($data) > 0)
    <thead>
    <tr class="text-start text-muted fw-bold gs-0">
        @if($this->canSelect())
            <th id="selectAllHeader" class="position-sticky top-0" scope="col">
                <div>
                    <input type="checkbox" id="selectAllCheckbox" class="form-check-input"
                           x-model="selectAll" x-on:click="updateSelectAll">
                </div>
            </th>
        @endif
        @foreach($this->defineColumns() as $column)
            @if($column->visible)
                <th id="{{ $column->name }}Header" class="text-nowrap  position-sticky top-0" scope="col" style="
         @if($column->width)
            width: {{ $column->width }};
        @endif

        @if($column->height)
            height: {{ $column->height }};
        @endif
         text-align: {{ $column->textAlign ?? 'left' }};"
                    @if($column->sortable) wire:click="sortBy('{{ $column->name }}')" @endif style="cursor: pointer;">
                    {{ $column->label }}
                    @if($column->sortable)
                        @if($sortColumn == $column->name)
                            {!! $sortDirection == 'asc' ? '&#9650;' : '&#9660;' !!}
                        @endif
                    @endif
                </th>
            @endif
        @endforeach
        @if($this->getActions())
            @if($this->getActions()->actions)
                <th id="actionsHeader" scope="col"  class="text-center position-sticky top-0 text-nowrap min-w-100px">
                    {{ __('table::table.actions') }}
                </th>
            @endif
        @endif
    </tr>
    </thead>
@endif
