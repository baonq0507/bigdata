<div class="ms-auto lh-1">
    <div class="dropdown">
        <a class="dropdown-toggle text-secondary" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
           aria-expanded="false">{{$dropdown['title'] ?? ''}}</a>
        <div class="dropdown-menu dropdown-menu-end">
            @foreach($dropdown['items'] as $item)
                <a class="dropdown-item"
                @if(!empty($item['attributes']))
                    @foreach($item['attributes'] ?? [] as $attr => $value)
                        {{ $attr }}="{{ $value }}"
                    @endforeach
                @endif
                >{{$item['title'] ?? ''}}</a>
            @endforeach
        </div>
    </div>
</div>
