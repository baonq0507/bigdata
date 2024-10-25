<div class="col
    @if($data->col)
     @foreach($data->col as $key=>$value)
        col-{{$key}}-{{$value}}
     @endforeach
     @else col-md-6 @endif
">
    <div class="card @if($data->isHover)card-hover @endif">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="subheader">{{$data->title ?? ''}}</div>
                @if($data->dropdown)
                    @include('widget::components.dropdown', ['dropdown' => $data->dropdown])
                @endif
            </div>
            <div class="d-flex align-items-baseline mb-2 mt-2">
                <div class="h2 me-2">
                    {{$data->value ?? ''}}
                </div>
                @if (!empty($data->subDescription))
                    <div class="ms-auto">
                        <span
                            class="text-{{ $data->subDescription['color'] ?? 'green' }} d-inline-flex align-items-center lh-1">
                            {{ $data->subDescription['title'] ?? 'No Title' }} &nbsp;
                            @if (!empty($data->subDescription['icon']))
                                <i class="{{ $data->subDescription['icon'] }}"></i>
                            @endif
                        </span>
                    </div>
                @endif

            </div>
            @if($data->description)
                <div class="d-flex mb-2">
                    <div>{{$data->description ?? ''}}</div>
                </div>
            @endif
{{--            <div class="progress progress-sm">--}}
{{--                <div class="progress-bar bg-primary" style="width: 75%" role="progressbar" aria-valuenow="75"--}}
{{--                     aria-valuemin="0" aria-valuemax="100" aria-label="75% Complete">--}}
{{--                    <span class="visually-hidden">75% Complete</span>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>
</div>
