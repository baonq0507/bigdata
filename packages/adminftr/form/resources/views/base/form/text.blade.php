<div>
    {!! $beforeText !!}
    <{{ $tag }}
        name
    ="{{ $name }}" id="{{ $id }}"
    class="{{ $classes }} {{ $colorClass }} m-0"
    @if($tag == "a")
        @if($link)
            href="{{ $link }}"
        @else
            href="javascript:void(0)"
        @endif
    @endif
    placeholder="{{ $placeholder }}"
    @foreach($attributes as $key => $value)
        {{ $key }}="{{ $value }}"
    @endforeach
    >

    <span x-text="'{{ trim($beforeValue) }}'+ $wire.data.{{$name}}"></span>
    {{trim($afterValue)}}
</{{ $tag }}>
{!! $afterText !!}
</div>
