@extends('admin.layouts.default')

@section('admin.breadcrumb')
    <li class='breadcrumb-item'>
        <a href="{{ route('admin.users.index') }}">Users</a>
    </li>
    <li class='breadcrumb-item active'>Permissions</li>
@endsection

@section('admin.content')
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <strong>Permissions</strong>

                @can('manage blog')
                    <a class="pull-right" href="{{ route('admin.permissions.create') }}">Add new permission</a>
                @endcan
            </div>
        </div>

        @if($permissions->total())
            <table class="table table-responsive-sm table-hover table-outline mb-0">
                <thead class="thead-light">
                <tr>
                    <th>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input">
                            <span class="custom-control-label"></span>
                        </label>
                    </th>
                    <th>Name</th>
                    <th>Usable</th>
                    <th>Roles</th>
                    <th>Users</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($permissions as $permission)
                    <tr>
                        <td>
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input">
                                <span class="custom-control-label"></span>
                            </label>
                        </td>
                        <td>{{ $permission->name }}</td>
                        <td>
                            {{ $permission->usable ? 'True' : 'False' }}
                        </td>
                        <td>
                            {{ $permission->roles->count() }}
                        </td>
                        <td>
                            {{ $permission->roles->each->users->count() }}
                        </td>
                        <td>
                            <nav class="nav" role="navigation" aria-label="Role options">
                                @if($permission->parent_id || !($permission->roles->count()))
                                    <a class="nav-item nav-link"
                                       href="{{ route('admin.permissions.edit', $permission) }}">
                                        Edit
                                    </a>

                                    <a class="nav-item nav-link"
                                       href="{{ route('admin.permissions.toggleStatus', $permission) }}"
                                       onclick="event.preventDefault(); document.getElementById('permission-toggle-status-form-{{ $permission->id }}').submit()">
                                        {{ $permission->usable ? 'Disable' : 'Activate' }}
                                    </a>

                                    <!-- Toggle Status Form -->
                                    <form action="{{ route('admin.permissions.toggleStatus', $permission) }}"
                                          method="post"
                                          style="display: none;"
                                          id="permission-toggle-status-form-{{ $permission->id }}">
                                        {{ csrf_field() }}
                                        {{ method_field('PUT') }}
                                    </form>

                                    <!-- Delete Button -->
                                    <a class="nav-item nav-link text-danger"
                                       href="{{ route('admin.permissions.destroy', $permission) }}" data-toggle="modal"
                                       data-target="#permission-delete-modal-{{ $permission->id }}">
                                        Delete
                                    </a>

                                    @include('layouts.admin.partials.modals._confirm_modal', [
                                        'modalId' => "permission-delete-modal-{$permission->id}",
                                        'title' => "Delete confirmation",
                                        'action' => "permission-delete-form-{$permission->id}",
                                        'message' => "Do you want to delete: {$permission->name} permission?",
                                        'warning' => "Permission will only be removed if it has no users.
                                        To prevent further access disable permission and revoke it from users.",
                                        'type' => "danger"
                                    ])

                                    <form action="{{ route('admin.permissions.destroy', $permission) }}"
                                          method="post"
                                          style="display: none;"
                                          id="permission-delete-form-{{ $permission->id }}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                    </form>
                                @endif

                                <a class="nav-item nav-link"
                                   href="{{ route('admin.roles.index', ['permission' => $permission]) }}">
                                    Manage roles
                                </a>
                            </nav>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="card-body">
                {{ $permissions->links() }}
            </div>
        @else
            <div class="card-body">
                <div class="card-text">No permissions found.</div>
            </div>
        @endif
    </div>
@endsection