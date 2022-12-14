@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Email Verification</h4>

                        <div class="mt-2 font-medium text-sm text-success">
                            @if (session('status') == 'verification-link-sent')
                                A new email verification link has been emailed to you!
                            @else
                                Please check your email address for a verification.
                            @endif

                            <form class="mt-4" action="{{ route('verification.send') }}" method="post">
                                @csrf()
                                No email yet? <button class="btn btn-primary">{{ __('Resend Verification') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
