@component('mail::message')
# Subscription Cancelled

{{--Hello {{ $user->first_name }},--}}

You have cancelled your subscription.

@component('mail::panel')
    Some features and services may not be accessible.
    Login into your account to learn more.
@endcomponent

@component('mail::button', ['url' => route('account.index')])
    View my account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
