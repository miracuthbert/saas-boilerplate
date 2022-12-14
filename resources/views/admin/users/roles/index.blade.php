@extends('admin.layouts.default')

@section('admin.breadcrumb')
    <li class='breadcrumb-item'>
        <a href="{{ route('admin.users.index') }}">{{ __('Users') }}</a>
    </li>
    <li class='breadcrumb-item'>{{ __('Roles') }}</li>
@endsection

@section('admin.content')
    <section class="mb-3">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <strong>{{ __('Roles') }}</strong>
                    @can('create role')
                        <a class="pull-right" href="{{ route('admin.roles.create') }}">{{ __('Add new role') }}</a>
                    @endcan
                </div>
            </div>

            @if ($roles->total())
                <table class="table table-responsive-sm table-hover table-outline mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input checkbox-selector" data-key="roles">
                                    <span class="custom-control-label"></span>
                                </label>
                            </th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Usable') }}</th>
                            <th>{{ __('Permissions') }}</th>
                            <th>{{ __('Users') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            @include('admin.users.roles.partials._role', compact('role'))
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="card-body">
                    <div class="card-text">{{ __('No roles found.') }}</div>
                </div>
            @endif
        </div>
        @if ($roles->lastPage() > 1)
            {{ $roles->links() }}
        @endif
    </section>
@endsection
