@extends('admin.layouts.default')

@section('admin.breadcrumb')
    <li class='breadcrumb-item'>
        <a href="{{ route('admin.users.index') }}">{{ __('Users') }}</a>
    </li>
    <li class='breadcrumb-item'>
        <a href="{{ route('admin.roles.index') }}">{{ __('Roles') }}</a>
    </li>
    <li class='breadcrumb-item active'>{{ __('Create') }}</li>
@endsection

@section('admin.content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">{{ __('Add new role') }}</h4>

            <form action="{{ route('admin.roles.store') }}" method="post">
                @csrf

                <div class="form-group row{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="control-label col-md-4">{{ __('Name') }}</label>
                    <div class="col-md-6">
                        <input type="text" name="name"
                            class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name"
                            value="{{ old('name') }}" required autofocus>

                        <x-input-error name="name" />
                    </div>
                </div>

                <div class="form-group row{{ $errors->has('description') ? ' has-error' : '' }}">
                    <label for="description" class="control-label col-md-4">{{ __('Description') }}</label>
                    <div class="col-md-6">
                        <textarea name="description" id="description" rows="5"
                            class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}">{{ old('description') }}</textarea>

                        <x-input-error name="description" />
                    </div>
                </div>

                <div class="form-group row mt-3">
                    <label for="type" class="control-label col-md-4">{{ __('Set role group (optional)') }}</label>

                    <!-- Role Order -->
                    <div class="col-md-3">
                        <label for="order" class="control-label col-md-4">{{ __('Order') }}</label>
                        <x-order-selector id="order" name="order" />

                        <x-input-error name="order" />
                    </div>

                    <!-- Role Node -->
                    <div class="col-md-3">
                        <label for="node" class="control-label col-md-4">{{ __('Node') }}</label>
                        <select id="node" name="node" type="text"
                            class="custom-select form-control{{ $errors->has('node') ? ' is-invalid' : '' }}">
                            <option value="">{{ __('Choose node') }}</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}"{{ old('node') === $role->id ? ' selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>

                        <x-input-error name="node" />
                    </div>
                </div>

                <div class="form-group mt-3 row{{ $errors->has('type') ? ' has-error' : '' }}">
                    <label for="type" class="control-label col-md-4">{{ __('Type') }}</label>
                    <div class="col-md-6">
                        <select name="type" id="type"
                            class="custom-select form-control{{ $errors->has('type') ? ' is-invalid' : '' }}">
                            <option value="">Choose type</option>
                            @foreach (config('laravel-roles.permitables', []) as $key => $type)
                                <option value="{{ $key }}"{{ old('type') == $key ? ' selected' : '' }}>
                                    {{ $type }}</option>
                            @endforeach
                        </select>

                        <x-input-error name="type" />
                    </div>
                </div>

                @foreach ($permissions as $key => $permissionsGroup)
                    <x-permissions-form-group-row :key="$key" :permissionsGroup="$permissionsGroup" />
                @endforeach

                <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
