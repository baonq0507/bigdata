<header class="navbar navbar-expand-md d-none d-lg-block border-0 d-print-none" id="navbar-header">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
                aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="d-flex align-items-center">
            <a href="{{ route('admin.dashboard.index') }}" class="d-inline-block navbar-logo me-4 text-">
                <img src="{{ asset('static/FeatureCMS-logo/vector/default-monochrome.svg') }}" class="d-block"
                     loading="lazy" alt="">
            </a>

            <div class="navbar-search position-relative">

            </div>
        </div>

        {{-- <div class="pe-0 pe-md-3" style="user-select: none;">
        </div> --}}
        <div class="navbar-nav flex-row order-md-last mt-2">

            <div class="d-none d-md-flex">
                <a href="?theme=dark" class="nav-link me-2 px-0 hide-theme-dark" title="Enable dark mode"
                   data-bs-toggle="tooltip" data-bs-placement="bottom" id="dark-mode-toggle">
                    <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                         viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z"/>
                    </svg>
                </a>
                <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode"
                   data-bs-toggle="tooltip" data-bs-placement="bottom" id="light-mode-toggle">
                    <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                         viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"/>
                        <path
                            d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7"/>
                    </svg>
                </a>
                @if (config('future.future.messages'))
                    <livewire:future::admin.messages.icon></livewire:future::admin.messages.icon>
                @endif
                @if (config('future.future.notifications'))
                    <livewire:future::notifications.icon></livewire:future::notifications.icon>
                @endif

            </div>
            <div class="nav-item dropdown">
                <a href="#" class=" nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                   aria-label="Open user menu">
                    <span class="avatar avatar-sm"
                          style="background-image: url({{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : asset('static/avatars/001f.jpg') }})"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div>{{ Auth::user()->name }}</div>
                        <div class="mt-1 small text-muted">{{ Auth::user()->roles->first()->name ?? 'Chưa có quyền' }}
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="{{ route('admin.profile') }}" class="dropdown-item">Profile</a>
                    <div class="dropdown-divider"></div>
                    <a href="./settings.html" class="dropdown-item">Settings</a>
                    <a href="{{ route('logout') }}" class="dropdown-item">Logout</a>
                </div>
            </div>
        </div>
    </div>
</header>
