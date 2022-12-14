@props(['id', 'name' => empty($name) ? $id : $name, 'title' => '', 'current' => '', 'options' => []])

<select id="{{ $id || $name }}" name="{{ $name }}"
    class="custom-select form-control{{ $errors->has($name) ? ' is-invalid' : '' }}">
    <option value="">{{ $title }}</option>
    @forelse ($options as $key => $option)
        <option value="{{ $key }}"{{ old($name, $current) === $key ? ' selected' : '' }}>{{ $option }}</option>
    @empty
        {{ $slot }}
    @endforelse
</select>
