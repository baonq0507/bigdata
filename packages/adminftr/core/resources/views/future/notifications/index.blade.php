<div class="col-12 col-md-9 d-flex flex-column 1">
    <div class="card-header d-flex justify-content-between">
        <h3 class="card-title">{{ __('future::profile.my_notifications') }}</h3>
        <a wire:click="$dispatch('readAll')" wire:loading.remove class="btn btn-primary btn-pill">
            {{ __('future::notifications.mark_all_as_read') }}
        </a>
        <button wire:loading wire:target="$dispatch('readAll')" class="btn btn-bg-body text-primary" disabled>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            {{ __('future::global.handling') }}
        </button>
    </div>
    @if ($notifications->count() < 0)
        <div class="list-group list-group-flush">
            <div class="list-group-item fw-bold">
                <div class="row d-flex justify-content-center">
                    <div class="col-auto">
                        <h3 class="text-center">
                            {{ __('future::global.no') . ' ' . __('future::notifications.notification') }}</h3>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="list-group list-group-flush overflow-auto" style="max-height: 35rem">
            @php
                $previousDate = null;
            @endphp

            @foreach ($notifications as $key => $noti)
                @php
                    $currentDate = date('d/m/Y', strtotime($noti->created_at));
                @endphp

                @if ($currentDate !== $previousDate)
                    <div class="list-group-header sticky-top">{{ $currentDate }}</div>
                @endif

                <div type="button" class="list-group-item {{ $noti->read_at ? '' : 'fw-bold' }}"
                    wire:key="{{ $noti->id }}"
                    wire:click="$dispatch('markAsRead', {
                        'notificationId':'{{ $noti->id }}'
                    })">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            @if (!$noti->read_at)
                                <div class="badge bg-warning"></div>
                            @endif
                        </div>
                        <div class="col text-truncate">
                            <a href="#" class="text-body d-block">
                                {{ $noti->data['title'] }}
                            </a>
                            <div class="text-secondary text-truncate mt-n1">
                                {{ $noti->data['content'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <span class="text-secondary fs-5">
                                {{ \Carbon\Carbon::parse($noti->created_at)->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>

                @php
                    $previousDate = $currentDate;
                @endphp
            @endforeach

            <div x-data="{}" x-intersect="$wire.loadMore()"
                class="list-group-item {{ $notifications->total() > $perPage ? '' : 'd-none' }}">
                <div class="row align-items-center placeholder-glow">
                    <div class="col-auto">
                    </div>
                    <div class="col-auto">
                        <a href="#">
                            <span class="avatar placeholder"></span>
                        </a>
                    </div>
                    <div class="col-7">
                        <div class="placeholder placeholder-xs col-9"></div>
                        <div class="placeholder placeholder-xs col-7"></div>
                    </div>
                    <div class="col-2 ms-auto text-end">
                        <div class="placeholder placeholder-xs col-6"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
