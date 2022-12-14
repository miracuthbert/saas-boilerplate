@extends('admin.layouts.default')

@section('admin.breadcrumb')
    <li class='breadcrumb-item'>
        <a href="{{ route('admin.users.index') }}">{{ __('Users') }}</a>
    </li>
    <li class='breadcrumb-item'>{{ $user->name }}</li>
    <li class='breadcrumb-item active'>{{ __('Roles') }}</li>
@endsection

@section('admin.content')
    <div class="clearfix">
        <div class="card mb-3">
            <div class="card-body">
                <div class="card-title">
                    <strong>{{ $user->name }}</strong>
                </div>

                <form action="{{ route('admin.users.roles.store', $user) }}" method="post">
                    {{ csrf_field() }}

                    @include('admin.users.user.roles.partials.forms._roles')

                    @include('admin.users.partials.forms._datetimepicker')

                    <div class="form-group row">
                        <div class="col-sm-4 offset-sm-4">
                            <button type="submit" class="btn btn-primary">Assign role</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if($roles->count())
        <p class="h3">{{ __('Roles') }}</p>

        @foreach($roles as $role)
            <div class="clearfix">
                <div class="card mb-2">
                    <div class="card-body">
                        <h4 class="card-title">{{ $role->name }}</h4>
                        @if($role->pivot->expires_at)
                            <p>
                                {{ $role->pivot->expires_at->toDayDateTimeString() }}
                            </p>

                            @if($role->pivot->isActive())
                                <ul class="list-inline my-1">
                                    <li class="list-inline-item">
                                <span class="badge badge-success">
                                    Active / Valid | Expires {{ $role->pivot->expires_at->diffForHumans() }}
                                </span>
                                    </li>

                                    <li class="list-inline-item">
                                        <a href="{{ route('admin.users.roles.destroy', [$user, $role]) }}"
                                           class="btn btn-outline-primary"
                                           data-toggle="modal"
                                           data-target="#revoke-user-role-modal-{{ $role->pivot->id }}">
                                            Revoke / remove role
                                        </a>

                                        @include('layouts.admin.partials.modals._confirm_modal', [
                                            'modalId' => "revoke-user-role-modal-{$role->pivot->id}",
                                            'title' => "Revoke role confirmation",
                                            'action' => "revoke-user-role-form-{$role->pivot->id}",
                                            'message' => "Do you want to revoke: {$role->name} role from {$user->name}?",
                                            'type' => "danger"
                                        ])

                                        <form action="{{ route('admin.users.roles.destroy', [$user, $role]) }}"
                                              method="post"
                                              style="display: none;"
                                              id="revoke-user-role-form-{{ $role->pivot->id }}">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form>
                                    </li>
                                </ul>
                            @else
                                <p>
                                <span class="badge badge-danger">
                                    Expired {{ $role->pivot->expires_at->diffForHumans() }}
                                </span>
                                </p>
                            @endif
                        @else
                            <form action="{{ route('admin.users.roles.update', [$user, $role]) }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}

                                @include('admin.users.partials.forms._datetimepicker', ['id' => '_'.$role->pivot->id])

                                <div class="form-group row">
                                    <div class="col-sm-4 offset-sm-4">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="card card-body">
            <div class="card-text">No roles found.</div>
        </div>
    @endif
@endsection

@push('scripts')
    @include('admin.partials.forms.scripts._script_datetimepicker')
@endpush