@component('mail::message')
# Card Updated

{{--Hello {{ $user->first_name }},--}}

Your card details have been updated.

@component('mail::panel')
    You can login into your account and change the card anytime.
@endcomponent

@component('mail::button', ['url' => route('account.index')])
View my account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
