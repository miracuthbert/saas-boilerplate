@foreach($roles as $role)
    <tr>
        <td>
            <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input">
                <span class="custom-control-label"></span>
            </label>
        </td>
        <td>{{ $role->name }}</td>
        <td>
            {{ $role->usable ? 'True' : 'False' }}
        </td>
        <td>
            {{ $role->permissions->count() }}
        </td>
        <td>
            {{ $role->users->count() }}
        </td>
        <td>
            <ul class="nav" role="navigation" aria-label="Role options">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.roles.edit', $role) }}">
                        Edit
                    </a>
                </li>

                @if($role->parent_id || !($role->children->count()))
                    <li class="nav-item">
                        <!-- Toggle Status Form -->
                        <a class="nav-link" href="{{ route('admin.roles.toggleStatus', $role) }}"
                           onclick="event.preventDefault(); document.getElementById('role-toggle-status-form-{{ $role->id }}').submit()">
                            {{ $role->usable ? 'Disable' : 'Activate' }}
                        </a>

                        <form action="{{ route('admin.roles.toggleStatus', $role) }}"
                              method="post"
                              style="display: none;"
                              id="role-toggle-status-form-{{ $role->id }}">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                        </form>
                    </li><!-- /.nav-item -->

                    @if(!($role->permissions->count()) && !($role->users->count()))
                        <li class="nav-item">
                            <!-- Delete Button -->
                            <a class="nav-link text-danger"
                               href="{{ route('admin.roles.destroy', $role) }}" data-toggle="modal"
                               data-target="#role-delete-modal-{{ $role->id }}">
                                Delete
                            </a>

                            @include('layouts.admin.partials.modals._confirm_modal', [
                                'modalId' => "role-delete-modal-{$role->id}",
                                'title' => "Delete confirmation",
                                'action' => "role-delete-form-{$role->id}",
                                'message' => "Do you want to delete: {$role->name} role?",
                                'warning' => "Role will only be removed if it has no users.
                                To prevent further access disable role and revoke it from users.",
                                'type' => "danger"
                            ])

                            <form action="{{ route('admin.roles.destroy', $role) }}"
                                  method="post"
                                  style="display: none;"
                                  id="role-delete-form-{{ $role->id }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                            </form>
                        </li><!-- /.nav-item -->
                    @endif
                @endif

                <li class="nav-item dropdown">
                    <!-- Users options -->
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        Users
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('admin.roles.revokeUsersAccess', $role) }}"
                           data-toggle="modal" data-target="#revoke-role-users-access-modal-{{ $role->id }}">
                            Revoke from all users
                        </a>

                        <a class="dropdown-item"
                           href="{{ route('admin.users.index', $role) }}">
                            Manage users
                        </a>
                    </div><!-- /.dropdown-menu -->

                    @include('layouts.admin.partials.modals._confirm_modal', [
                        'modalId' => "revoke-role-users-access-modal-{$role->id}",
                        'title' => "Revoke role from all users confirmation",
                        'action' => "revoke-role-users-access-form-{$role->id}",
                        'message' => "Do you want to revoke access of users with {$role->name} role?",
                        'warning' => "Once completed, this action cannot be undone.",
                        'type' => "danger"
                    ])

                    <!-- Revoke User Access Form -->
                    <form action="{{ route('admin.roles.revokeUsersAccess', $role) }}"
                          method="post"
                          style="display: none;"
                          id="revoke-role-users-access-form-{{ $role->id }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                    </form>
                </li><!-- /.nav-item -->

                <li class="nav-item">
                    <a class="nav-link"
                       href="{{ route('admin.roles.permissions.index', $role) }}">
                        Permissions
                    </a>
                </li><!-- /.nav-item -->
            </ul>
        </td>
    </tr>
@endforeach
