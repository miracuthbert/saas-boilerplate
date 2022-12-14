@props(['key', 'permissionsGroup', 'role' => null])

@php
    $hasRole = !empty($role);
    $old_permissions = (count(request()->old('permissions', [])) == 0 && $hasRole) ? optional($role)->permissions : collect(request()->old('permissions'))->map(
        fn ($val) => (new \SAAS\Domain\Users\Models\Permission)->forceFill(['id' => $val])
    )
@endphp

<div class="form-group row">
    <label for="type" class="control-label col-md-4">{{ __(':type permissions', ['type' => $key]) }}</label>

    <div class="col-md-6">
        <div class="custom-control custom-checkbox mb-3">
            <input type="checkbox" class="custom-control-input perm-selector" data-key="{{ $key }}"
                id="customCheck{{ $key }}">
            <label class="custom-control-label" for="customCheck{{ $key }}">{{ __('Select all') }}</label>
        </div>

        <div class="row">
            @foreach ($permissionsGroup as $permission)
                <div class="col-12 col-md-6 mb-3">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input {{ $key }}-item"
                            id="permId{{ $permission->id }}" name="permissions[]" value={{ $permission->id }}
                            {{ $old_permissions->contains('id', $permission->id) ? ' checked' : '' }}>
                        <label class="custom-control-label" for="permId{{ $permission->id }}">
                            {{ $permission->name }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
    <script>
        const permselector = $('.perm-selector')
        const ukey = permselector.data('key')
        const perms = $(`.${ukey}-item`)

        const updateChecked = function () {
            const checked = $(`.${ukey}-item:checked`).length

            if (checked === 0) {
                permselector.prop('checked', false)
                permselector.prop('indeterminate', false)
            } else if (perms.length > checked) {
                permselector.prop('checked', false)
                permselector.prop('indeterminate', true)
            } else {
                permselector.prop('indeterminate', false)
                permselector.prop('checked', true)
            }
        }

        permselector.change(function() {
            if ($(this).prop('checked')) {
                $(`.${ukey}-item`).prop('checked', true)
            } else {
                $(`.${ukey}-item`).prop('checked', false)
            }
        })

        $(`.${ukey}-item`).change(function() {
            updateChecked()
        })

        updateChecked()
    </script>
@endpush
