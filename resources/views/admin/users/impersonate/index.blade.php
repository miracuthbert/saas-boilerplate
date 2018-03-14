@extends('admin.layouts.default')

@section('admin.breadcrumb')
    <li class='breadcrumb-item'>
        <a href="{{ route('admin.users.index') }}">Users</a>
    </li>
    <li class='breadcrumb-item active'>Impersonate User</li>
@endsection

@section('admin.content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                Impersonate a User
            </h4>

            <form method="POST" action="{{ route('admin.users.impersonate.store') }}">
                {{ csrf_field() }}

                <div class="form-group row{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label">User E-mail Address</label>

                    <div class="col-md-6">
                        <input id="email" type="email"
                               class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                               name="email"
                               value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">Impersonate</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
