@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <div class="d-flex justify-content-between align-content-center">
                                <h4>{{ __('Projects') }}</h4>

                                <a href="{{ route('tenant.projects.create') }}">{{ __('Create new project') }}</a>
                            </div>
                        </div>
                    </div>

                    <x-projects-list-group :projects="$projects" />
                </div>

                @if ($projects->lastPage() > 1)
                    <div class="mt-3">
                        {{ $projects->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
