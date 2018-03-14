<div class="form-group row{{ $errors->has('permission_id') ? ' has-error' : '' }}">
    <label for="permission_id" class="control-label col-md-4">Permission</label>
    <div class="col-md-6">
        <select name="permission_id" id="permission_id"
                class="custom-select form-control{{ $errors->has('permission_id') ? ' is-invalid' : '' }}">
            @foreach($permitables as $permit)
                <option value="{{ $permit->id }}"
                        {{ old('permission_id') == $permit->id ? ' selected' : '' }}>
                    {{ $permit->name }}
                </option>
            @endforeach
        </select>

        @if($errors->has('permission_id'))
            <div class="invalid-feedback">
                <strong>{{ $errors->first('permission_id') }}</strong>
            </div>
        @endif
    </div>
</div>
