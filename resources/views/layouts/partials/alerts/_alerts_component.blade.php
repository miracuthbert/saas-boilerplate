<div class="alert alert-{{ $type }}">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    {{ $slot }}

    @if(isset($link) && !empty($link))
        <a href="{{ $link }}" class="alert-link">
            {{ session('alert_link_name') }}
        </a>
    @endif
</div>
