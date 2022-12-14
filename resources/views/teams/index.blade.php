@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="card-body">
                    <h4 class="card-title">{{ __('Teams') }}</h4>
                    <div class="card-subtitle">
                        {{ __('A list of teams you own or are part of.') }}
                    </div>
                </div>
            </div>
            <div class="col-sm-9">
                <div class="card">
                    <div class="list-group list-group-flush">
                        @foreach($teams as $team)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $team->name }}

                                <aside>
                                    <a href="{{ route('tenant.switch', $team) }}">{{ __('View') }}</a>
                                    <a href="{{ route('teams.show', $team) }}">{{ __('Settings') }}</a>
                                </aside>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection