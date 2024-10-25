<div class="card rounded-3 {{ $classes }} card-link card-link-pop mt-3" @if($attributes)
    @foreach ($this->attributes as $name => $value)
        {{ $name }}="{{ $value }}"
    @endforeach
@endif>
{{--@if($ribbon)--}}
{{--    <div class="ribbon-wrapper ribbon-lg">--}}
{{--        <div class="ribbon bg-{{ $ribbonColor }}">{{ $ribbon }}</div>--}}
{{--    </div>--}}
{{--@endif--}}

@if($title)
    <div class="card-header {{ $headerClasses }} h3">{{ $title }}</div>
@endif
@if($subtitle)
    <div class="card-subtitle {{ $subTitleClasses }} h5">{{ $subtitle }}</div>
@endif
<div class="card-body {{ $bodyClasses }}">
    @foreach($fields as $field)
        {!! $field->render() !!}
    @endforeach
</div>
@if($footer)<div class="card-footer text-muted">{{ $footer }}</div>@endif
</div>
