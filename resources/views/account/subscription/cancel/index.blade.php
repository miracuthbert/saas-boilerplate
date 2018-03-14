@extends('account.layouts.default')

@section('account.content')
    <div class="card">

        <div class="card-body">
            <h4 class="card-title">Cancel subscription</h4>
            <p class="card-subtitle">Confirm your subscription cancellation.</p>

            <form method="POST" action="{{ route('account.subscription.cancel.store') }}">
                {{ csrf_field() }}

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
