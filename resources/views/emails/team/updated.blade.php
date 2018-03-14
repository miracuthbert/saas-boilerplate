@component('mail::message')
# Team Updated

Team details have been updated.

You can login to see changes.

@component('mail::button', ['url' => route('account.index')])
View my account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
