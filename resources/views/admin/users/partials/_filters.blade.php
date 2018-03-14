<nav class="nav">
    <!-- User Mapped Filter -->
    @foreach($users_mappings as $key => $filter)
        @include('admin.users.partials._user_filters', [
            'map' => $filter['map'],
            'key' => $key,
            'heading' => $filter['heading'],
            'style' => isset($filter['style']) ? $filter['style'] : '',
        ])
    @endforeach

    @if(count(array_intersect(array_keys(request()->query()), array_keys($users_mappings))))
        <a class="nav-item nav-link btn btn-primary" href="{{ route('admin.users.index') }}">
            <i class="fa fa-times-circle"></i> Clear all filters
        </a>
    @endif
</nav>