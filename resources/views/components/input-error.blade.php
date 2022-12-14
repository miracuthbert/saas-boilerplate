@props([
    'name'
])

@if ($errors->has($name))
    <div class="invalid-feedback">
        <strong>{{ $errors->first($name) }}</strong>
    </div>
@endif
