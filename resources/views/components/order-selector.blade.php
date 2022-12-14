@props(['id', 'name' => empty($name) ? $id : $name, 'current' => ''])

<select id="{{ $id || $name }}" name="{{ $name }}"
    class="custom-select form-control{{ $errors->has($name) ? ' is-invalid' : '' }}">
    <option value="">{{ __('Choose order') }}</option>
    <option value="child"{{ old($name, $current) === 'child' ? ' selected' : '' }}>{{ __('Child Of') }}</option>
    <option value="before"{{ old($name, $current) === 'before' ? ' selected' : '' }}>{{ __('Before') }}</option>
    <option value="after"{{ old($name, $current) === 'after' ? ' selected' : '' }}>{{ __('After') }}</option>
</select>
