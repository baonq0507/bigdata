@if($can)
    <a class="btn btn-{{$color ?:'light-primary'}}" @if($url)href="{{$url}}" @endif
    @if($modal)data-bs-toggle="modal" x-on:click="$wire.dispatch('setModel',{id:null})"
       data-bs-target="#{{$name}}"@endif>
        @if($icon)
            <i class="{{$icon}}"></i>
        @endif <span class="ms-2">{{$label}}</span>
    </a>
@endif
