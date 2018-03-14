@component('mail::message')
# Team Deleted

This team no longer exists.

@component('mail::panel')
    Some features and services may not be accessible if your subscription was based on the team plan.
    Login to your account to see the changes.
@endcomponent

@component('mail::button', ['url' => route('account.index')])
View my account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
