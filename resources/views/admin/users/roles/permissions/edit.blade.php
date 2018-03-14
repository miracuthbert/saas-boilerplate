@extends('admin.layouts.default')

@section('admin.breadcrumb')
    <li class='breadcrumb-item'>
        <a href="{{ route('admin.users.index') }}">Users</a>
    </li>
    <li class='breadcrumb-item'>
        <a href="{{ route('admin.permissions.index') }}">Permissions</a>
    </li>
    <li class='breadcrumb-item active'>Edit</li>
@endsection

@section('admin.content')

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit permission</h4>

            <form class="my-1" action="{{ route('admin.permissions.update', $permission) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="form-group row{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="control-label col-md-4">Name</label>
                    <div class="col-md-6">
                        <input type="text" name="name"
                               class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name"
                               value="{{ old('name', $permission->name) }}" required autofocus>

                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group row{{ $errors->has('usable') ? ' has-error' : '' }}">
                    <label for="usable" class="control-label col-md-4">Usable</label>
                    <div class="col-md-6">
                        <select name="usable" id="usable"
                                class="custom-select form-control{{ $errors->has('usable') ? ' is-invalid' : '' }}">
                            <option value="0"{{ old('usable', $permission->usable) == 0 ? ' selected' : '' }}>False
                            </option>
                            <option value="1"{{ old('usable', $permission->usable) == 1 ? ' selected' : '' }}>True
                            </option>
                        </select>

                        @if($errors->has('usable'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('usable') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection