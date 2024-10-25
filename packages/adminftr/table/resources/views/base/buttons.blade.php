<div class="d-flex">
    @foreach($actions as $index => $action)
        @if($index < 2)
            {{$action->render()}}
        @endif
    @endforeach
</div>
