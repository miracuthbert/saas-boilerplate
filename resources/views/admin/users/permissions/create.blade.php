@extends('admin.layouts.default')

@section('admin.breadcrumb')
    <li class='breadcrumb-item'>
        <a href="{{ route('admin.users.index') }}">{{ __('Users') }}</a>
    </li>
    <li class='breadcrumb-item'>
        <a href="{{ route('admin.permissions.index') }}">{{ __('Permissions') }}</a>
    </li>
    <li class='breadcrumb-item active'>{{ __('Create') }}</li>
@endsection

@section('admin.content')

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">{{ __('Add new permission') }}</h4>

            <form action="{{ route('admin.permissions.store') }}" method="post">
                @csrf

                <div class="form-group row{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="control-label col-md-4">{{ __('Name') }}</label>
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

                <div class="form-group row{{ $errors->has('usable') ? ' has-error' : '' }}">
                    <label for="usable" class="control-label col-md-4">{{ __('Usable') }}</label>
                    <div class="col-md-6">
                        <select name="usable" id="usable"
                                class="custom-select form-control{{ $errors->has('usable') ? ' is-invalid' : '' }}">
                            <option value="0"{{ old('usable') == 0 ? ' selected' : '' }}>False
                            </option>
                            <option value="1"{{ old('usable') == 1 ? ' selected' : '' }}>True
                            </option>
                        </select>

                        @if($errors->has('usable'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('usable') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group row{{ $errors->has('type') ? ' has-error' : '' }}">
                    <label for="type" class="control-label col-md-4">{{ __('Type') }}</label>
                    <div class="col-md-6">
                        <select name="type" id="type"
                            class="custom-select form-control{{ $errors->has('type') ? ' is-invalid' : '' }}"
                        >
                            <option value="">Choose type</option>
                            @foreach ($types as $key => $type)
                                <option value="{{ $key }}"{{ old('type') == $key ? ' selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>

                        @if($errors->has('type'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('type') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection