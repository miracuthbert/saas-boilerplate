@component('mail::message')
# Team Membership Cancelled

Hello {{ $user->first_name }},

You have been removed as a member of {{ $team->name }}.

@component('mail::panel')
    Some features and services may not be accessible.
@endcomponent

@component('mail::button', ['url' => route('account.index')])
    View my account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
