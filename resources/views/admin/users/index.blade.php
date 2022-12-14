@extends('admin.layouts.default')

@section('admin.breadcrumb')
    <li class='breadcrumb-item active'>{{ __('Users') }}</li>
@endsection

@section('admin.content')
    <section class="mb-3">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <strong>{{ __('Users') }}</strong>
                    <a class="pull-right" href="{{ route('admin.users.create') }}">{{ __('Add new user') }}</a>
                </div>
                <div class="my-1">
                    <p class="h5">{{ __('Filters') }}</p>
                    <div class="row">
                        <div class="col-sm-12">
                            @include('admin.users.partials._filters')
                        </div>
                    </div>
                </div>
            </div>
            @if($users->total())
                <table class="table table-responsive-sm table-hover table-outline mb-0">
                    <thead class="thead-light">
                    <tr>
                        <th>
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input checkbox-selector" data-key="users" id="selectAll">
                                <label class="custom-control-label" for="selectAll"></label>
                            </label>
                        </th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Verified') }}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input users-item" id="user{{ $user->id }}">
                                    <label class="custom-control-label" for="user{{ $user->id }}"></label>
                                </label>
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>
                                {{ $user->email }}
                            </td>
                            <td>{{ $user->email_verified_at ? __('True') : __('False') }}</td>
                            <td>
                                <a href="{{ route('admin.users.roles.index', $user) }}">{{ __('Manage roles') }}</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="card-body">
                    <div class="card-text">{{ __('No users found.') }}</div>
                </div>
            @endif
        </div>
        
        @if ($users->lastPage() > 1)
            {{ $users->links() }}
        @endif
    </section>
@endsection