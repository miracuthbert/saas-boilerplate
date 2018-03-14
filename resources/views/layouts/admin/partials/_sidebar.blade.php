<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link{{ return_if(on_page('admin.dashboard'), ' active') }}"
                   href="{{ route('admin.dashboard') }}">
                    <i class="icon-speedometer"></i> Dashboard
                </a>
            </li>
            @yield('sidebar')
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
