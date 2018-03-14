@if($style == 'link')

    @foreach($map as $value => $name)
        @if(request($key))
            <a class="nav-item nav-link btn btn-primary"
               href="{{ route('admin.users.index', array_except(request()->query(), [$key, 'page'])) }}">
                {{ $name }} <i class="fa fa-times-circle"></i>
            </a>
        @else
            <a class="nav-item nav-link{{ request($key) === $value ? ' active' : '' }}"
               href="{{ route('admin.users.index', array_merge(request()->query(), [$key => $value, 'page' => 1])) }}">
                {{ $name }}
            </a>
        @endif
    @endforeach

@elseif($style == 'list')

    <div class="btn-group" role="group">
        <div class="dropdown btn-group">
            <a href="#" class="nav-item nav-link dropdown-toggle" data-toggle="dropdown">
                {{ $heading }}
            </a>
            <div class="dropdown-menu">
                @foreach($map as $value => $name)
                    <a class="dropdown-item"
                       href="{{ route('admin.users.index', array_merge(request()->query(), [$key => $value, 'page' => 1])) }}">
                        {{ $name }}
                    </a>
                @endforeach
            </div>
        </div>

        @if(request($key))
            <a class="nav-item nav-link btn btn-primary"
               href="{{ route('admin.users.index', array_except(request()->query(), [$key, 'page'])) }}">
                <i class="fa fa-times-circle"></i>
            </a>
        @endif
    </div>
@endif