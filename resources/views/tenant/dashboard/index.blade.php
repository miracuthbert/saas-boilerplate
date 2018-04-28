@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <h4 class="card-title">{{ config('app.name') }} Dashboard</h4>
                    </div>
                </div><!-- /.card -->

                <div class="card mb-3">
                    <div class="card-body">
                        <div class="card-title">
                            <div class="d-flex justify-content-between align-content-center">
                                <h4>Projects</h4>
                                <a href="{{ route('tenant.projects.create') }}">Create new project</a>
                            </div>
                        </div><!-- /.card-title -->
                    </div><!-- /.card-body -->
                    @if($projects->count())
                        <div class="list-group list-group-flush">
                            @foreach($projects as $project)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $project->name }}

                                    <aside>
                                        <a href="{{ route('tenant.projects.edit', $project) }}">Edit</a>
                                        <a href="#"
                                           onclick="event.preventDefault(); document.getElementById('delete-project-form-{{ $project->id }}').submit()">
                                            Delete
                                        </a>
                                        <form id="delete-project-form-{{ $project->id }}"
                                              action="{{ route('tenant.projects.destroy', $project) }}"
                                              method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </aside>
                                </div>
                            @endforeach
                            <a class="list-group-item" href="{{ route('tenant.projects.index') }}">View all</a>
                        </div><!-- /.list-group -->
                    @endif
                </div><!-- /.card -->
            </div>
        </div>
    </div>
@endsection