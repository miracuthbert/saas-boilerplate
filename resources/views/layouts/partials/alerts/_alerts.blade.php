@if(session()->has('error'))
    @component('layouts.partials.alerts._alerts_component', [
    'type' => 'danger',
    'link' => session('error_link')
    ])
        {{ session('error') }}
    @endcomponent

@endif

@if(session()->has('success'))
    @component('layouts.partials.alerts._alerts_component', [
    'type' => 'success',
    'link' => session('success_link')
    ])
        {{ session('success') }}
    @endcomponent
@endif

@if(session()->has('info'))
    @component('layouts.partials.alerts._alerts_component', [
    'type' => 'info',
    'link' => session('info_link')
    ])
        {{ session('info') }}
    @endcomponent
@endif

@if(session()->has('bulk_error') && count(session('bulk_error')) > 0)
    @include('layouts.partials.alerts._alerts_bulk_component', [
    'type' => 'error',
    'alerts' => session('bulk_error')
    ])
@endif

@if(session()->has('bulk_success') && count(session('bulk_success')) > 0)
    @include('layouts.partials.alerts._alerts_bulk_component', [
    'type' => 'success',
    'alerts' => session('bulk_success')
    ])
@endif