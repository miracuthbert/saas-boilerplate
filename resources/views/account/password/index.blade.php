@extends('account.layouts.default')

@section('account.content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Change Password</h4>

            <form method="POST" action="{{ route('account.password.store') }}">
                {{ csrf_field() }}

                <div class="form-group row{{ $errors->has('current_password') ? ' has-error' : '' }}">
                    <label for="current_password" class="col-md-4 control-label">Current Password</label>

                    <div class="col-md-6">
                        <input id="current_password" type="password"
                               class="form-control{{ $errors->has('current_password') ? ' is-invalid' : '' }}"
                               name="current_password"
                               required autofocus>

                        @if ($errors->has('current_password'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('current_password') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group row{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-md-4 control-label">New Password</label>

                    <div class="col-md-6">
                        <input id="password" type="password"
                               class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                               required>

                        @if ($errors->has('password'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>


                <div class="form-group row">
                    <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                               required>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
