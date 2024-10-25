@if($data && count($data) > 0)
    <tbody>
    <div >
        <div class="empty position-absolute table-loading w-100" wire:loading
             style="
              z-index: 1000;
             "
        >
            <div class="empty-img"></div>
            <p class="empty-title">
                Waiting for loading data
            </p>
            <div class="empty-action">
                <div class="spinner-border text-primary" role="status"  >
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
    @foreach($data as $item)
        <tr wire:key="data-{{$item->id}}">
            {{--            <td>--}}
            {{--                <div x-sort:handle>--}}
            {{--                    <i class="fas fa-grip-lines"></i>--}}
            {{--                </div>--}}
            {{--            </td>--}}
            @if($this->canSelect())
                <td>
                    <div>
                        <input type="checkbox" class="form-check-input checkbox" :id="'check-' + {{$item->id}}"
                               :value="{{$item->id}}"
                               :checked="isChecked({{$item->id}})"
                               @click="toggleSelection({{$item->id}})">
                    </div>
                </td>
            @endif
            @foreach($this->defineColumns() as $column)
                @if($column->visible)
                    <td>{!! $column->render($item) !!}</td>
                @endif
            @endforeach
            @if($this->getActions())
                @if($this->getActions()->actions)
                    @if($this->defineActions($item))
                        <td class="text-center">
                            <div>
                                {{ $this->defineActions($item) }}
                            </div>
                        </td>
                    @endif
                @endif
            @endif

        </tr>
    @endforeach
    </tbody>
@else
    <div >
        <div class="empty position-absolute table-loading w-100" wire:loading
             style="
              z-index: 1000;
             "
        >
            <div class="empty-img"></div>
            <p class="empty-title">
                Waiting for loading data
            </p>
            <div class="empty-action">
                <div class="spinner-border text-primary" role="status"  >
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
    <tbody>
    <tr>
        <td colspan="{{ count($this->defineColumns()) + ($this->canSelect() ? 1 : 0) + ($this->getActions() ? 1 : 0) }}"
            class="text-center">
            @if($data && count($data) == 0)
                <div class="empty">
                    <div class="empty-img"></div>
                    <p class="empty-title">No results found</p>
                    <p class="empty-subtitle text-secondary">
                        Try adjusting your search or filter to find what you're looking for.
                    </p>
                    <div class="empty-action">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path><path d="M21 21l-6 -6"></path></svg>
                        Search again
                    </div>
                </div>
            @endif
        </td>
    </tr>
    </tbody>
@endif
