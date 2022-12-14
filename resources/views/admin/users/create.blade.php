@extends('admin.layouts.default')

@section('admin.breadcrumb')
    <li class='breadcrumb-item'>
        <a href="{{ route('admin.users.index') }}">{{ __('Users') }}</a>
    </li>
    <li class='breadcrumb-item active'>{{ __('Create User') }}</li>
@endsection

@section('admin.content')
    <x-user-register-card :title="__('Create User')" :button-label="__('Create')" :password="false" route="admin.users.store">

        <div class="form-group row{{ $errors->has('role_id') ? ' has-error' : '' }}">
            <label for="role_id" class="col-md-4 control-label">{{ __('Role') }}</label>

            @can('assign roles')
                <div class="col-md-6">
                    <x-custom-select :title="__('Choose Role')" id="role_id">
                        @forelse ($roleables as $role)
                            @if ($role->children->count())
                                <optgroup label="{{ $role->name }}">
                                    @foreach ($role->children as $child)
                                        <option value="{{ $child->id }}"{{ $child->id == old('role_id') }}>
                                            {{ $child->name }}</option>
                                    @endforeach
                                </optgroup>
                            @else
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endif
                        @empty
                        @endforelse
                    </x-custom-select>
                </div>
            @endcan
        </div>
    </x-user-register-card>
@endsection
