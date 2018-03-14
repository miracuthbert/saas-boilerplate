@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-3 col-4">
                @include('account.layouts.partials._navigation')
            </div><!-- /.col-sm-3 -->
            <div class="col-sm-9 col-8">
                @yield('account.content')
            </div><!-- /.col-sm-9 -->
        </div>
    </div>
@endsection
