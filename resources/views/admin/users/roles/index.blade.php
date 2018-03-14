@extends('admin.layouts.default')

@section('admin.breadcrumb')
    <li class='breadcrumb-item'>
        <a href="{{ route('admin.users.index') }}">Users</a>
    </li>
    <li class='breadcrumb-item'>Roles</li>
@endsection

@section('admin.content')
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <strong>Roles</strong>

                @can('manage blog')
                    <a class="pull-right" href="{{ route('admin.roles.create') }}">Add new role</a>
                @endcan
            </div>
        </div>

        @if($roles->total())
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
                    <th>Permissions</th>
                    <th>Users</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    @include('admin.users.roles.partials._role', compact('roles'))
                </tbody>
            </table>
            <div class="card-body">
                {{ $roles->links() }}
            </div>
        @else
            <div class="card-body">
                <div class="card-text">No roles found.</div>
            </div>
        @endif
    </div>
@endsection