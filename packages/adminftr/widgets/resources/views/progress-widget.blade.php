<div
    class="
        {{ isset($data->col['xs']) ? 'col-xs-' . $data->col['xs'] : '' }}
        {{ isset($data->col['sm']) ? 'col-sm-' . $data->col['sm'] : '' }}
        {{ isset($data->col['md']) ? 'col-md-' . $data->col['md'] : '' }}
        {{ isset($data->col['lg']) ? 'col-lg-' . $data->col['lg'] : '' }}
        {{ isset($data->col['xl']) ? 'col-xl-' . $data->col['xl'] : '' }}
        {{ isset($data->col['xxl']) ? 'col-xxl-' . $data->col['xxl'] : '' }}">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                @if (isset($data->image) && $data->image)
                    <div class="col-3">
                        <img src="{{ $data->image }}" alt="{{ $data->title }}" class="rounded">
                    </div>
                @endif
                <div class="col">
                    <h3 class="card-title mb-1">
                        <a href="#" class="text-reset">{{ $data->title }}</a>
                    </h3>
                    <div class="text-secondary">
                        {{ $data->description }}
                    </div>
                    @if (isset($data->progress) && $data->progress)
                        <div class="mt-3">
                            <div class="row g-2 align-items-center">
                                <div class="col-auto">
                                    {{ $data->progress }} %
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm">
                                        <div class="progress-bar" style="width: {{ $data->progress }}%"
                                            role="progressbar" aria-valuenow="{{ $data->progress }}" aria-valuemin="0"
                                            aria-valuemax="100" aria-label="{{ $data->progress }}% Complete">
                                            <span class="visually-hidden">{{ $data->progress }}% Hoàn thành</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-auto">
                    @if ($data->actionButtons)
                        <div class="dropdown">
                            <a href="#" class="btn-action" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                    <path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                    <path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                </svg>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" style="">
                                @foreach ($data->actionButtons as $button)
                                    <a href="#"
                                        class="dropdown-item {{ $button->textColor }}">{{ $button->label }}</a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
