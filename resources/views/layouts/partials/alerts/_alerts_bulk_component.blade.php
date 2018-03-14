<div class="alert alert-{{ $type }}">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <ul>
        @foreach($alerts as $alert)
            <li>{{ $alert }}</li>
        @endforeach
    </ul>
</div>
