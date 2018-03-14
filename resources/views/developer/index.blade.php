@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-2">
                    <div class="card-body">
                        <h1 class="card-title">Developer Panel</h1>
                    </div>
                </div>

                <div class="mb-3">
                    <passport-clients></passport-clients>
                </div>

                <div class="mb-3">
                    <passport-authorized-clients></passport-authorized-clients>
                </div>

                <div class="mb-3">
                    <passport-personal-access-tokens></passport-personal-access-tokens>
                </div>
            </div>
        </div>
    </div>
@endsection
