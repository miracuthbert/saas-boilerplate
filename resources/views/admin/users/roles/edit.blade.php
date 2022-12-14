@extends('admin.layouts.default')

@section('admin.breadcrumb')
    <li class='breadcrumb-item'>
        <a href="{{ route('admin.users.index') }}">{{ __('Users') }}</a>
    </li>
    <li class='breadcrumb-item'>
        <a href="{{ route('admin.roles.index') }}">{{ __('Roles') }}</a>
    </li>
    <li class='breadcrumb-item active'>{{ __('Edit') }}</li>
@endsection

@section('admin.content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">{{ __('Edit role') }}</h4>

            @if (!$role->parent_id && $role->children->count())
                <p class="card-subtitle">
                    {{ __('You can only update the details field of this role') }}
                </p>
            @endif

            <form class="my-1" action="{{ route('admin.roles.update', $role) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <fieldset{{ !$role->parent_id && $role->children->count() ? ' disabled' : '' }}>
                    <div class="form-group row{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="control-label col-md-4">{{ __('Name') }}</label>
                        <div class="col-md-6">
                            <input type="text" name="name"
                                class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name"
                                value="{{ old('name', $role->name) }}" required autofocus>

                            <x-input-error name="name" />
                        </div>
                    </div>
                    </fieldset>

                    <div class="form-group row{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description" class="control-label col-md-4">{{ __('Description') }}</label>
                        <div class="col-md-6">
                            <textarea name="description" id="description" rows="5"
                                class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}">{{ old('description', $role->description) }}</textarea>

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
                                @foreach ($flat_roles as $rol)
                                    <option
                                        value="{{ $rol->id }}"{{ old('node', $role->id) === $rol->id ? ' selected' : '' }}>
                                        {{ $rol->name }}
                                    </option>
                                @endforeach
                            </select>

                            <x-input-error name="node" />
                        </div>
                    </div>

                    <div class="form-group row{{ $errors->has('usable') ? ' has-error' : '' }}">
                        <label for="usable" class="control-label col-md-4">{{ __('Usable') }}</label>
                        <div class="col-md-6">
                            <x-custom-select id="usable" :current="$role->usable">
                                <option value="0"{{ old('usable', $role->usable) == false ? ' selected' : '' }}>
                                    {{ __('False') }}
                                </option>
                                <option value="1"{{ old('usable', $role->usable) == true ? ' selected' : '' }}>
                                    {{ __('True') }}
                                </option>
                            </x-custom-select>

                            <x-input-error name="usable" />
                        </div>
                    </div>

                    @foreach ($permissions as $key => $permissionsGroup)
                        <x-permissions-form-group-row :key="$key" :permissionsGroup="$permissionsGroup" :role="$role" />
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
