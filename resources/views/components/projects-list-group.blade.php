@props([
    'projects'
])

<div class="list-group list-group-flush">
    @foreach ($projects as $project)
        <div class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <h4>{{ $project->name }}</h4>

                <p class="text-xs">
                    {{ __('Last activity') }}
                    <span class="text-muted">{{ $project->updated_at->diffForHumans() }}</span>
                </p>
            </div>


            <aside class="mx-1">
                <a href="{{ route('tenant.projects.edit', $project) }}">{{ __('Edit') }}</a>
                <a href="#"
                    onclick="event.preventDefault(); document.getElementById('delete-project-form-{{ $project->id }}').submit()">
                    {{ __('Delete') }}
                </a>
                <form id="delete-project-form-{{ $project->id }}"
                    action="{{ route('tenant.projects.destroy', $project) }}" method="POST"
                    style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </aside>
        </div>
    @endforeach
</div><!-- /.list-group -->