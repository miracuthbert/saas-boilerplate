@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <h4 class="card-title">{{ __('Team Settings') }}</h4>
                <p class="text-muted">{{ __('Update your team profile here.') }}</p>
            </div>
            <div class="col-sm-8 offset-sm-1">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('teams.update', $team) }}">
                            {{ csrf_field() }}
                            @method('PATCH')

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="control-label">{{ __('Name') }}</label>

                                <input id="name" type="text"
                                    class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                                    value="{{ old('name', $team->name) }}" required autofocus>

                                @if ($errors->has('name'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
