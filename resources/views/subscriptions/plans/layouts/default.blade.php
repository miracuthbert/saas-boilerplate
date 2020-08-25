@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex d-flex-wrap justify-content-center mb-3">
            <h1>{{ $plansTitle ?? '' }}</h1>
        </div><!-- /.d-flex -->

        @foreach($plans->chunk(3) as $plansRow)
            <div class="{{ $plansRow->count() == 1 ? 'd-flex flex-wrap justify-content-center' : 'card-deck' }} mb-3">

                @foreach($plansRow as $plan)
                    <div class="card {{ $plansRow->count() == 1 ? 'col-sm-6' : '' }} text-center">

                        <h2 class="my-3 text-truncate">
                            <small>$.</small> {{ $plan->price }}
                        </h2>

                        <div class="card-body">
                            <h5 class="card-title">{{ $plan->name }}</h5>

                            <a class="btn btn-link" href="{{ route('plans.show', $plan) }}">
                                Details
                            </a>

                            <a class="btn btn-primary" href="{{ route('subscription.index', ['plan' => $plan]) }}">
                                Subscribe
                            </a>
                        </div><!-- /.card-body -->

                        @if($plan->teams_enabled)
                            <div class="list-group list-group-flush">
                                <div class="list-group-item flex-column align-items-start">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">Team Limit</h5>
                                        <span>{{ $plan->teams_limit }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div><!-- /.card -->
                @endforeach

            </div><!-- /.d-flex or .card-deck -->
        @endforeach

        <div class="d-flex d-flex-wrap justify-content-center">
            {{ $links ?? '' }}
        </div><!-- /.d-flex -->
    </div>
@endsection