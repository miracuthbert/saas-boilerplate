@component('subscriptions.plans.layouts.default', compact('plans'))

    @section('plansTitle')
        {{ __('User Plans') }}
    @endsection

    @section('links')
        <!-- Team plans link -->
        <a href="{{ route('plans.teams.index') }}" class="btn btn-outline-primary btn-lg">{{ __('Team plans') }}</a>
    @endsection

@endcomponent