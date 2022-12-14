<!-- General Links -->
<ul class="nav flex-column nav-pills">
    <li class="nav-item">
        <a class="nav-link{{ return_if(on_page('account.index'), ' active') }}" href="{{ route('account.index') }}">
            {{ __('Account overview') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ return_if(on_page('account.profile.index'), ' active') }}"
            href="{{ route('account.profile.index') }}">
            {{ __('Profile') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ return_if(on_page('account.password.index'), ' active') }}"
            href="{{ route('account.password.index') }}">
            {{ __('Change password') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ return_if(on_page('account.deactivate.index'), ' active') }}"
            href="{{ route('account.deactivate.index') }}">
            {{ __('Deactivate account') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ return_if(on_page('account.twofactor.index'), ' active') }}"
            href="{{ route('account.twofactor.index') }}">
            {{ __('Two factor authentication') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ return_if(on_page('account.tokens.index'), ' active') }}"
            href="{{ route('account.tokens.index') }}">
            {{ __('API tokens') }}
        </a>
    </li>
</ul>

@subscribed
    @notpiggybacksubscription
        <!-- Subscription Links -->
        <ul class="nav flex-column nav-pills">
            <li class="nav-item py-2">
                {{ __('Subscription') }}
            </li>
            @subscriptionnotcancelled
                <li class="nav-item">
                    <a class="nav-link{{ return_if(on_page('account.subscription.swap.index'), ' active') }}"
                        href="{{ route('account.subscription.swap.index') }}">
                        {{ __('Change plan') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link{{ return_if(on_page('account.subscription.cancel.index'), ' active') }}"
                        href="{{ route('account.subscription.cancel.index') }}">
                        {{ __('Cancel subscription') }}
                    </a>
                </li>
            @endsubscriptionnotcancelled

            @subscriptioncancelled
                <li class="nav-item">
                    <a class="nav-link{{ return_if(on_page('account.subscription.resume.index'), ' active') }}"
                        href="{{ route('account.subscription.resume.index') }}">
                        {{ __('Resume subscription') }}
                    </a>
                </li>
            @endsubscriptioncancelled

            <li class="nav-item">
                <a class="nav-link{{ return_if(on_page('account.subscription.card.index'), ' active') }}"
                    href="{{ route('account.subscription.card.index') }}">
                    {{ __('Update card') }}
                </a>
            </li>

            @teamsubscription
                <li class="nav-item">
                    <a class="nav-link{{ return_if(on_page('account.subscription.team.index'), ' active') }}"
                        href="{{ route('account.subscription.team.index') }}">
                        {{ __('Manage team') }}
                    </a>
                </li>
            @endteamsubscription
        </ul>
    @endnotpiggybacksubscription
@endsubscribed

<!-- Developer Links -->
<ul class="nav flex-column nav-pills mt-3">
    <li class="nav-item">
        {{ __('Developer') }}
    </li>
    <li class="nav-item">
        <a class="nav-link{{ return_if(on_page('developer.index'), ' active') }}"
            href="{{ route('developer.index') }}">
            {{ __('Developer panel') }}
        </a>
    </li>
</ul>
