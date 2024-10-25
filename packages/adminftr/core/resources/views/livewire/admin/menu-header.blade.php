<div class="collapse navbar-collapse" id="sidebar-menu">
    <ul class="navbar-nav pt-lg-3">
        @foreach ($menus as $menu)
            @if (Auth::user()->can($menu->permission) && (!$menu->parent_id || $menu->parent_id == $menu->id))
                @php
                    $isActive =
                        request()->is($menu->url) ||
                        $menu->children->contains(function ($child) {
                            return request()->is($child->url);
                        });
                    $menuClass = $isActive ? 'rounded rounded-2 bg-primary show' : '';
                @endphp

                <li class="nav-item{{ $menu->children->isEmpty() ? '' : ' dropdown' }}">
                    <a class="nav-link {{ $menuClass }}{{ $menu->children->isEmpty() ? '' : ' dropdown-toggle' }}"
                       href="{{ route($menu->permission) }}"
                       @if (!$menu->children->isEmpty()) data-bs-toggle="dropdown" data-bs-auto-close="false"
                       aria-expanded="true" @endif>
                        <span class="nav-link-icon d-md-none d-lg-inline-block {{ $isActive ? ' text-white' : '' }}">
                            <i class="{{ $menu->icon }}"></i>
                        </span>
                        <span class="nav-link-title {{ $isActive ? ' text-white' : '' }}">{{ $menu->title }}</span>
                    </a>
                    @if (!$menu->children->isEmpty())
                        <ul class="dropdown-menu {{ $isActive ? ' show' : '' }}"
                            aria-labelledby="navbarDropdown{{ $loop->index }}">
                            @foreach ($menu->children as $child)
                                @if (Auth::user()->can($child->permission) && $child->id != $menu->id)
                                    <li>
                                        <a class="dropdown-item nav-link {{ request()->is($child->url) ? 'bg-primary text-white' : '' }}"
                                           href="{{ route($child->permission) }}">{{ $child->title }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endif
        @endforeach
    </ul>

    <div class="collapse-menu d-none d-lg-block text-end">
        <button
            class="btn btn-collapse-menu
            {{ request()->cookie('sidebarState') === 'collapsed' ? 'state-collapsed' : '' }}
            "
            id="btn-collapse-menu">
            <svg class="icon-left" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-bar-left">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M4 12l10 0"/>
                <path d="M4 12l4 4"/>
                <path d="M4 12l4 -4"/>
                <path d="M20 4l0 16"/>
            </svg>

            <svg class="icon-right" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-bar-to-right">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M14 12l-10 0"/>
                <path d="M14 12l-4 4"/>
                <path d="M14 12l-4 -4"/>
                <path d="M20 4l0 16"/>
            </svg>
        </button>
    </div>
</div>
