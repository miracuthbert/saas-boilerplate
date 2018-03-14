@extends('account.layouts.default')

@section('account.content')
    <div class="card">

        <div class="card-body">
            <h4 class="card-title">Profile</h4>

            <form method="POST" action="{{ route('account.profile.store') }}">
                {{ csrf_field() }}

                <div class="form-group row{{ $errors->has('first_name') ? ' has-error' : '' }}">
                    <label for="first_name" class="col-md-4 control-label">Firstname</label>

                    <div class="col-md-6">
                        <input id="first_name" type="text"
                               class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                               name="first_name"
                               value="{{ old('first_name', auth()->user()->first_name) }}" required autofocus>

                        @if ($errors->has('first_name'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group row{{ $errors->has('last_name') ? ' has-error' : '' }}">
                    <label for="last_name" class="col-md-4 control-label">Lastname</label>

                    <div class="col-md-6">
                        <input id="last_name" type="text"
                               class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name"
                               value="{{ old('last_name', auth()->user()->last_name) }}" required autofocus>

                        @if ($errors->has('last_name'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group row{{ $errors->has('username') ? ' has-error' : '' }}">
                    <label for="username" class="col-md-4 control-label">Username</label>

                    <div class="col-md-6">
                        <input id="username" type="text"
                               class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username"
                               value="{{ old('username', auth()->user()->username) }}" required autofocus>

                        @if ($errors->has('username'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('username') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group row{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                    <div class="col-md-6">
                        <input id="email" type="email"
                               class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                               value="{{ old('email', auth()->user()->email) }}" required>

                        @if ($errors->has('email'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group row{{ $errors->has('phone') ? ' has-error' : '' }}">
                    <label for="phone" class="col-md-4 control-label">Phone</label>

                    <div class="col-md-6">
                        <input id="phone" type="text"
                               class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone"
                               value="{{ old('phone', auth()->user()->phone) }}" required autofocus>

                        @if ($errors->has('phone'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group row{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-md-4 control-label">Password</label>

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
