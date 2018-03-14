@extends('account.layouts.default')

@section('account.content')
    <div class="card">

        <div class="card-body">
            <h4 class="card-title">Resume Subscription</h4>
            <p>Confirm to resume your subscription.</p>

            <form method="POST" action="{{ route('account.subscription.resume.store') }}">
                {{ csrf_field() }}

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        Resume
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
