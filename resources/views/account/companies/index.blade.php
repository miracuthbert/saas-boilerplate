@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Companies</h4>
                        <div class="card-subtitle">
                            A list of companies you own or are part of.
                        </div>
                    </div>
                    <div class="list-group list-group-flush">
                        @foreach($companies as $company)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $company->name }}

                                <aside>
                                    <a href="{{ route('tenant.dashboard', $company) }}">View</a>
                                    {{--<a href="#">--}}
                                        {{--Projects--}}
                                        {{--<span class="badge badge-primary badge-pill">10</span>--}}
                                    {{--</a>--}}
                                </aside>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection