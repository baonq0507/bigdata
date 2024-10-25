<div class="{{ $fontWeightClass }}">
    <span
    @if($tooltip)
        data-toggle="tooltip" data-placement="{{$tooltip['placement']}}" title="{{$tooltip['title'] ?? $value}}"
    @endif
    >
        {{$iconHtml}} {{$value}} {{$iconCopy}}
    </span>
    <br>
    <span>{{$descriptionHtml}}</span>
</div>
