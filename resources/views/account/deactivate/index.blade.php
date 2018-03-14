@extends('account.layouts.default')

@section('account.content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Deactivate Account</h4>

            <form method="POST" action="{{ route('account.deactivate.store') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
                    <label for="current_password" class="control-label">Current password</label>

                    <input id="current_password" type="password"
                           class="form-control col-sm-8{{ $errors->has('current_password') ? ' is-invalid' : '' }}"
                           name="current_password"
                           required autofocus>

                    @if ($errors->has('current_password'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('current_password') }}</strong>
                        </div>
                    @endif
                </div>

                @subscriptionnotcancelled
                <div class="form-group">
                    <p class="form-text">
                        This will also cancel your active subscription.
                    </p>
                </div>
                @endsubscriptionnotcancelled

                <div class="form-group">
                    <button type="submit" class="btn btn-danger">
                        Deactivate account
                    </button>

                    <p class="form-text">
                        Read more on account deactivation in our
                        <a href="#">Privacy policy</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection
