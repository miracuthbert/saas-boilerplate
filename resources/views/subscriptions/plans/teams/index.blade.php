@component('subscriptions.plans.layouts.default', compact('plans'))

    @slot('plansTitle')
        Team plans
    @endslot

    @slot('links')
        <!-- User plans link -->
        <a href="{{ route('plans.index') }}" class="btn btn-secondary btn-lg">User plans</a>
    @endslot

@endcomponent