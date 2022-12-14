@props([
    'buttonLabel' => __('Sign Up'),
    'title' => __('Sign Up'),
    'terms' => false,
    'password' => true,
    'route' => 'register',
])

<div class="card">
    <div class="card-body">
        <h4 class="card-title">{{ $title }}</h4>

        <form method="POST" action="{{ route($route) }}">
            @csrf

            <div class="form-group row{{ $errors->has('first_name') ? ' has-error' : '' }}">
                <label for="first_name" class="col-md-4 control-label">{{ __('First Name') }}</label>

                <div class="col-md-6">
                    <input id="first_name" type="text"
                        class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name"
                        value="{{ old('first_name') }}" required autofocus>

                    <x-input-error name="first_name" />
                </div>
            </div>

            <div class="form-group row{{ $errors->has('last_name') ? ' has-error' : '' }}">
                <label for="last_name" class="col-md-4 control-label">{{ __('Last Name') }}</label>

                <div class="col-md-6">
                    <input id="last_name" type="text"
                        class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name"
                        value="{{ old('last_name') }}" required autofocus>

                    <x-input-error name="last_name" />
                </div>
            </div>

            <div class="form-group row{{ $errors->has('username') ? ' has-error' : '' }}">
                <label for="username" class="col-md-4 control-label">{{ __('Username') }}</label>

                <div class="col-md-6">
                    <input id="username" type="text"
                        class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username"
                        value="{{ old('username') }}" required autofocus>

                    <x-input-error name="username" />
                </div>
            </div>

            <div class="form-group row{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">{{ __('E-Mail Address') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email"
                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                        value="{{ old('email') }}" required>

                    <x-input-error name="email" />
                </div>
            </div>

            {{ $slot }}

            @if ($password)
                <div class="form-group row{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-md-4 control-label">{{ __('Password') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password"
                            class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                            required>

                        <x-input-error name="password" />
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password-confirm" class="col-md-4 control-label">{{ __('Confirm Password') }}</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            required>
                    </div>
                </div>
            @endif

            @if ($terms)
                <div class="form-group row{{ $errors->has('terms') ? ' has-error' : '' }}">
                    <div class="col-md-6 offset-md-4">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="terms"
                                class="custom-control-input{{ $errors->has('terms') ? ' is-invalid' : '' }}"
                                id="terms">
                            <label class="custom-control-label" for="terms">
                                {{ __('I accept the') }} <a href="#"
                                    target="_blank">{{ __('terms of service') }}</a>
                            </label>

                            <x-input-error name="terms" />
                        </div>
                    </div>
                </div>
            @endif

            <div class="form-group row">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ $buttonLabel }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
