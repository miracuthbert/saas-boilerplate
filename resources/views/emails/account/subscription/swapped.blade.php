@component('mail::message')
# Subscription Plan Changed

{{--Hello {{ $user->first_name }},--}}

Your subscription has been changed.

@component('mail::panel')
    Some features and services may not be accessible according to the plan your are currently on.
    Login into your account to see the changes.
@endcomponent

@component('mail::button', ['url' => route('account.index')])
    View my account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
