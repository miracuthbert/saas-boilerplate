@component('mail::message')
# Team Membership

Hello {{ $user->first_name }},

You have been added as a member of {{ $team->name }}.

You can login into your account to find out more.

@component('mail::button', ['url' => route('account.index')])
    View my account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
