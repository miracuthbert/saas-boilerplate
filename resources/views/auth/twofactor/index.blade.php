@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Two Factor Authentication</h4>
                        <form method="POST" action="{{ route('login.twofactor.verify') }}">
                            {{ csrf_field() }}

                            <div class="form-group row{{ $errors->has('token') ? ' has-error' : '' }}">
                                <label for="token" class="col-md-4 control-label">Verification token</label>

                                <div class="col-md-6">
                                    <input id="token" type="text"
                                           class="form-control{{ $errors->has('token') ? ' is-invalid' : '' }}"
                                           name="token"
                                           required autofocus>

                                    @if ($errors->has('token'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('token') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Login
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
