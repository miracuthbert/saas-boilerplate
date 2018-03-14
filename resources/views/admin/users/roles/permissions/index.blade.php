@extends('admin.layouts.default')

@section('admin.breadcrumb')
    <li class='breadcrumb-item'>
        <a href="{{ route('admin.users.index') }}">Users</a>
    </li>
    <li class='breadcrumb-item'>
        <a href="{{ route('admin.roles.index') }}">Roles</a>
    </li>
    <li class='breadcrumb-item'>
        {{ $role->name }}
    </li>
    <li class='breadcrumb-item active'>Permissions</li>
@endsection

@section('admin.content')
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <strong>{{ $role->name }} Permissions</strong>
            </div>

            <form action="{{ route('admin.roles.permissions.store', $role) }}" method="post">
                {{ csrf_field() }}

                @include('admin.users.roles.partials.forms._permissions')

                <div class="form-group row">
                    <div class="col-sm-4 offset-sm-4">
                        <button type="submit" class="btn btn-primary">Add permission</button>
                    </div>
                </div>
            </form>

        </div>

        @if($permissions->count())
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
                            <nav class="nav" role="navigation" aria-label="Role options">
                                <a class="nav-item nav-link"
                                   href="{{ route('admin.roles.permissions.destroy', [$role, $permission]) }}"
                                   data-toggle="modal"
                                   data-target="#remove-role-permission-modal-{{ $permission->id }}">
                                    Remove
                                </a>
                            </nav>

                            @include('layouts.admin.partials.modals._confirm_modal', [
                                'modalId' => "remove-role-permission-modal-{$permission->id}",
                                'title' => "Remove permission confirmation",
                                'action' => "remove-role-permission-form-{$permission->id}",
                                'message' => "Do you want to remove: {$permission->name} permission from {$role->name} role?",
                                'warning' => "This may affect role users access to some features.",
                                'type' => "danger"
                            ])

                            <form action="{{ route('admin.roles.permissions.destroy', [$role, $permission]) }}"
                                  method="post"
                                  style="display: none;"
                                  id="remove-role-permission-form-{{ $permission->id }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="card-body">
                <div class="card-text">No permissions found.</div>
            </div>
        @endif
    </div>
@endsection