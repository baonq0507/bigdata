<a class="btn btn-{{$action->color}}"
   @if($action->callback)
       wire:click="methodActions('{{$action->name}}')"
   @endif
   @if($action->confirm)
       wire:click="$dispatch('swalConfirm', {
             title: '{{$action->confirm['title']}}',
            text: '{{$action->confirm['text']}}',
            method: '{{$action->method}}',
            params: '{{$action->params}}'
        }
        })"
    @endif
>
    @if($action->icon)
        <i class="{{$action->icon}}"></i>
    @endif
    @if($action->label)
        <span class="ms-1">
        {{$action->label}}
    </span>
    @endif
</a>
