<div
    class="d-flex align-items-center
        {{ isset($data->col['xs']) ? 'col-xs-' . $data->col['xs'] : '' }}
        {{ isset($data->col['sm']) ? 'col-sm-' . $data->col['sm'] : '' }}
        {{ isset($data->col['md']) ? 'col-md-' . $data->col['md'] : '' }}
        {{ isset($data->col['lg']) ? 'col-lg-' . $data->col['lg'] : '' }}
        {{ isset($data->col['xl']) ? 'col-xl-' . $data->col['xl'] : '' }}
        {{ isset($data->col['xxl']) ? 'col-xxl-' . $data->col['xxl'] : '' }}">
    <div class="card card-sm w-100">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-auto">
                    @if (isset($data->icon) && $data->icon)
                        <span class="bg-{{ $data->color }} text-white avatar">
                            <i class="{{ $data->icon }}"></i>
                        </span>
                    @else
                        <span class="avatar">
                            {{ collect(explode(' ', $data->title))->map(fn($word) => substr($word, 0, 1))->implode('') }}
                        </span>
                    @endif
                </div>
                <div class="col text-start">
                    <div class="font-weight-medium">
                        {{ $data->title ?? '' }}
                        @if (isset($data->extraAttributes['subtitle']))
                            <span
                                class="float-right font-weight-medium {{ $data->extraAttributes['subtitleColor'] ?? '' }}">
                                ({{ $data->extraAttributes['subtitle'] }})
                            </span>
                        @endif
                    </div>
                    <div class="text-secondary">
                        {{ $data->description ?? '' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
