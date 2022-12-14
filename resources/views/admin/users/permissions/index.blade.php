@extends('admin.layouts.default')

@section('admin.breadcrumb')
    <li class='breadcrumb-item'>
        <a href="{{ route('admin.users.index') }}">{{ __('Users') }}</a>
    </li>
    <li class='breadcrumb-item active'>{{ __('Permissions') }}</li>
@endsection

@section('admin.content')
    <section class="mb-3">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <strong>{{ __('Permissions') }}</strong>
                    @can('create permission')
                        <a class="pull-right" href="{{ route('admin.permissions.create') }}">{{ __('Add new permission') }}</a>
                    @endcan
                </div>
            </div>
            @if($permissions->total())
                <table class="table table-responsive-sm table-hover table-outline mb-0">
                    <thead class="thead-light">
                    <tr>
                        <th>
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input checkbox-selector" data-key="permissions">
                                <span class="custom-control-label"></span>
                            </label>
                        </th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Usable') }}</th>
                        <th>{{ __('Roles') }}</th>
                        <th>{{ __('Users') }}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($permissions as $permission)
                        <tr>
                            <td>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input permissions-item">
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
                                            {{ __('Edit') }}
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
                                        {{ __('Manage roles') }}
                                    </a>
                                </nav>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="card-body">
                    <div class="card-text">{{ __('No permissions found.') }}</div>
                </div>
            @endif
        </div>

        @if ($permissions->lastPage() > 1)
            {{ $permissions->links() }}
        @endif
    </section>
@endsection