@section('sidebar')
    <li class="nav-title">USERS & ACCESS CONTROL</li>
    <!-- Users -->
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#">
            <i class="icon-people"></i> Users
        </a>
        <ul class="nav-dropdown-items">
            <li class="nav-item">
                <a class="nav-link{{ return_if(on_page('admin.users.create'), ' active') }}"
                   href="{{ route('admin.users.create') }}">
                    <i class="icon-plus"></i> Add User
                </a>
            </li>
            <!-- Impersonate User -->
            @role('admin-root')
                <li class="nav-item">
                    <a class="nav-link{{ return_if(on_page('admin.users.impersonate.index'), ' active') }}"
                       href="{{ route('admin.users.impersonate.index') }}">
                        <i class="icon-user"></i> Impersonate User
                    </a>
                </li>
            @endrole
            <li class="nav-item">
                <a class="nav-link{{ return_if(on_page('admin.users.index'), ' active') }}"
                   href="{{ route('admin.users.index') }}">
                    <i class="icon-people"></i> Users
                </a>
            </li>
        </ul>
    </li>

    <!-- Permissions -->
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#">
            <i class="icon-flag"></i> Permissions
        </a>
        <ul class="nav-dropdown-items">
            <li class="nav-item">
                <a class="nav-link{{ return_if(on_page('admin.permissions.create'), ' active') }}"
                   href="{{ route('admin.permissions.create') }}">
                    <i class="icon-plus"></i> Add Permission
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link{{ return_if(on_page('admin.permissions.index'), ' active') }}"
                   href="{{ route('admin.permissions.index') }}">
                    <i class="icon-flag"></i> Permissions
                </a>
            </li>
        </ul>
    </li>

    <!-- Roles -->
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#">
            <i class="icon-lock"></i> Roles
        </a>
        <ul class="nav-dropdown-items">
            <li class="nav-item">
                <a class="nav-link{{ return_if(on_page('admin.roles.create'), ' active') }}"
                   href="{{ route('admin.roles.create') }}">
                    <i class="icon-plus"></i> Add Role
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link{{ return_if(on_page('admin.roles.index'), ' active') }}"
                   href="{{ route('admin.roles.index') }}">
                    <i class="icon-lock"></i> Roles
                </a>
            </li>
        </ul>
    </li>
@endsection