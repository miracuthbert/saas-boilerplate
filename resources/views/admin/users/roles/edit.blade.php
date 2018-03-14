@extends('admin.layouts.default')

@section('admin.breadcrumb')
    <li class='breadcrumb-item'>
        <a href="{{ route('admin.users.index') }}">Users</a>
    </li>
    <li class='breadcrumb-item'>
        <a href="{{ route('admin.roles.index') }}">Roles</a>
    </li>
    <li class='breadcrumb-item active'>Edit</li>
@endsection

@section('admin.content')

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit role</h4>
            @if(!$role->parent_id && ($role->children->count()))
                <p class="card-subtitle">
                    You can only update the details field of this role
                </p>
            @endif

            <form class="my-1" action="{{ route('admin.roles.update', $role) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <fieldset{{ (!$role->parent_id && ($role->children->count())) ? ' disabled' : ''  }}>
                    <div class="form-group row{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="control-label col-md-4">Name</label>
                        <div class="col-md-6">
                            <input type="text" name="name"
                                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name"
                                   value="{{ old('name', $role->name) }}" required autofocus>

                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </fieldset>

                <div class="form-group row{{ $errors->has('details') ? ' has-error' : '' }}">
                    <label for="details" class="control-label col-md-4">Details</label>
                    <div class="col-md-6">
                        <textarea name="details" id="details" rows="5"
                                  class="form-control{{ $errors->has('details') ? ' is-invalid' : '' }}">{{ old('details', $role->details) }}</textarea>

                        @if($errors->has('details'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('details') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                @include('admin.users.roles.partials.forms._roles', compact('role'))

                <fieldset{{ (!$role->parent_id && ($role->children->count())) ? ' disabled' : ''  }}>
                    <div class="form-group row{{ $errors->has('usable') ? ' has-error' : '' }}">
                        <label for="usable" class="control-label col-md-4">Usable</label>
                        <div class="col-md-6">
                            <select name="usable" id="usable"
                                    class="custom-select form-control{{ $errors->has('usable') ? ' is-invalid' : '' }}">
                                <option value="0"{{ old('usable', $role->usable) == 0 ? ' selected' : '' }}>False
                                </option>
                                <option value="1"{{ old('usable', $role->usable) == 1 ? ' selected' : '' }}>True
                                </option>
                            </select>

                            @if($errors->has('usable'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('usable') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </fieldset>

                <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection