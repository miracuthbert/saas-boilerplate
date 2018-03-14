@component('mail::message')
# Subscription Resumed

{{--Hello {{ $user->first_name }},--}}

You have successfully resumed your subscription.

@component('mail::button', ['url' => route('account.index')])
    View my account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
