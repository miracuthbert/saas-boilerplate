@extends('account.layouts.default')

@section('account.content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Account Overview</h4>
        </div>
        <div class="list-group list-group-flush">
            <div class="list-group-item">
                <h4>Name</h4>
                <p>{{ auth()->user()->name }}</p>
            </div>
            <div class="list-group-item">
                <h4>Email Address</h4>
                <p>{{ auth()->user()->email }}</p>
            </div>
            @subscribed
                @notpiggybacksubscription
                    <div class="list-group-item">
                        <h4>Plan</h4>
                        @if(auth()->user()->plan)
                            <p>{{ auth()->user()->plan->name }}</p>
                        @else
                            <p>{{ __('Failed getting subscription details.') }}</p>
                        @endif
                    </div>
                @endnotpiggybacksubscription
            @endsubscribed
            <div class="list-group-item">
                <h4>Joined</h4>
                <p>{{ auth()->user()->created_at->diffForHumans() }}</p>
            </div>
        </div>
    </div>
@endsection