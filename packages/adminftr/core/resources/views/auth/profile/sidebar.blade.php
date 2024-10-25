<div class="col-12 col-md-3 border-end">
    <div class="card-body">
        <h4 class="subheader">{{ __('future::profile.settings') }}</h4>
        <div class="list-group list-group-transparent">
            <a href="{{ route('admin.profile') }}"
               class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                {{ __('future::profile.my_account') }}
            </a>
            @if (config('future.future.notifications'))
            <a href="{{ route('admin.notifications') }}"
               class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('admin.notifications') ? 'active' : '' }}">
                {{ __('future::profile.my_notifications') }}
            </a>
            @endif
        </div>
    </div>
</div>
