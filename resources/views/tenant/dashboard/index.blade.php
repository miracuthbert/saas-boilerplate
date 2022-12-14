@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="mb-3">
                    <h4>{{ tenant()->name }}</h4>
                </div><!-- / -->

                <div class="card mb-3">
                    <div class="card-body">
                        <div class="card-title">
                            <div class="d-flex justify-content-between align-content-center">
                                <h4>{{ __('Projects') }}</h4>
                                <a href="{{ route('tenant.projects.create') }}">{{ __('Create new project') }}</a>
                            </div>
                        </div><!-- /.card-title -->
                    </div><!-- /.card-body -->

                    @if($projects->count())
                        <x-projects-list-group :projects="$projects" />
                    @endif
                </div><!-- /.card -->
            </div>
        </div>
    </div>
@endsection