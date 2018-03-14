@component('subscriptions.plans.layouts.default', compact('plans'))

    @slot('plansTitle')
        User plans
    @endslot

    @slot('links')
        <!-- Team plans link -->
        <a href="{{ route('plans.teams.index') }}" class="btn btn-secondary btn-lg">Team plans</a>
    @endslot

@endcomponent