@component('mail::message')
# Account Activation

Hello,

Thank you for signing up.

Please activate your account to get started.

@component('mail::button', ['url' => route('activation.activate', $token), 'color' => 'green'])
    Activate
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
