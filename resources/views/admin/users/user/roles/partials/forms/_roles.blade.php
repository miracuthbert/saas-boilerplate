<div class="form-group row{{ $errors->has('role') ? ' has-error' : '' }}">
    <label for="role" class="control-label col-sm-4">Role</label>
    <div class="col-sm-4">
        <select name="role" id="role"
                class="custom-select form-control{{ $errors->has('role') ? ' is-invalid' : '' }}">

            <?php
            $traverse = function ($roleables) use (&$traverse) {
            foreach ($roleables as $roleable):
            ?>

            @if($roleable->children->count())
                <optgroup label="{{ $roleable->name }}">
                    <?php $traverse($roleable->children); ?>
                </optgroup>
            @else
                <option value="{{ $roleable->id }}" {{ old('role', isset($role) ? $role->parent_id : '') == $roleable->id ? 'selected' : '' }}>
                    {{ $roleable->name }}
                </option>
            @endif
            <?php
            endforeach;
            };

            $traverse($roleables);
            ?>

        </select>

        @if($errors->has('role'))
            <div class="invalid-feedback">
                <strong>{{ $errors->first('role') }}</strong>
            </div>
        @endif
    </div>
</div>
