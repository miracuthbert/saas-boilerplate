@extends('admin.layouts.default')

@section('admin.breadcrumb')
    <li class='breadcrumb-item'>
        <a href="{{ route('admin.users.index') }}">Users</a>
    </li>
    <li class='breadcrumb-item'>
        <a href="{{ route('admin.roles.index') }}">Roles</a>
    </li>
    <li class='breadcrumb-item active'>Create</li>
@endsection

@section('admin.content')

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add new role</h4>

            <form action="{{ route('admin.roles.store') }}" method="post">
                {{ csrf_field() }}

                <div class="form-group row{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="control-label col-md-4">Name</label>
                    <div class="col-md-6">
                        <input type="text" name="name"
                               class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name"
                               value="{{ old('name') }}" required autofocus>

                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group row{{ $errors->has('details') ? ' has-error' : '' }}">
                    <label for="details" class="control-label col-md-4">Details</label>
                    <div class="col-md-6">
                        <textarea name="details" id="details" rows="5"
                                  class="form-control{{ $errors->has('details') ? ' is-invalid' : '' }}">{{ old('details') }}</textarea>

                        @if($errors->has('details'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('details') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                @include('admin.users.roles.partials.forms._roles')

                <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection