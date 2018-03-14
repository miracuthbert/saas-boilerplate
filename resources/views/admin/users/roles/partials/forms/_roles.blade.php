<fieldset{{ (isset($role) && !$role->parent_id && ($role->children->count())) ? ' disabled' : ''  }}>
    <div class="form-group row{{ $errors->has('parent_id') ? ' has-error' : '' }}">
        <label for="parent_id" class="control-label col-md-4">Parent</label>
        <div class="col-md-6">
            <select name="parent_id" id="parent_id"
                    class="custom-select form-control{{ $errors->has('parent_id') ? ' is-invalid' : '' }}">
                <option value=""></option>

                <?php
                $role = isset($role) ? $role : null;
                $traverse = function ($roleables) use (&$traverse, $role) {
                foreach ($roleables as $roleable):
                ?>

                <option value="{{ $roleable->id }}"
                        {{ old('parent_id', isset($role) ? $role->parent_id : '') == $roleable->id ? ' selected' : '' }}
                        {{ $roleable->usable ? ' disabled' : '' }}
                        {{ isset($role) && $role->id == $roleable->id ? ' disabled' : '' }}>
                    {{ $roleable->name }}
                </option>
                <?php
                endforeach;
                };

                $traverse($roleables);
                ?>

            </select>

            @if($errors->has('parent_id'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('parent_id') }}</strong>
                </div>
            @endif
        </div>
    </div>
</fieldset>
