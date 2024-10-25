<aside
    class="navbar navbar-vertical navbar-expand-lg border
     {{ request()->cookie('sidebarState') === 'collapsed' ? 'state-collapsed' : '' }}"
    id="sidebar-wrapper" style="z-index: 999">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
                aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-brand navbar-brand-autodark">
            <a href=".">
                <svg xmlns="http://www.w3.org/2000/svg" width="110" height="40" viewBox="0 0 232 68" class="navbar-brand-image">
                    <text x="46" y="60" fill="#4a4a4a" font-family="Arial" font-size="47" font-weight="bold">FUTURE</text>
                </svg>
            </a>
        </div>
        <livewire:future::admin.menu-header></livewire:future::admin.menu-header>
    </div>
</aside>
