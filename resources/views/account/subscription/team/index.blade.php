@extends('account.layouts.default')

@section('account.content')
    <div class="card">

        <div class="card-body">
            <h4 class="card-title">Manage team</h4>

            <form method="POST" action="{{ route('account.subscription.team.update') }}">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="control-label">Team name</label>

                    <input id="name" type="text"
                           class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                           name="name"
                           value="{{ old('name', $team->name) }}" required>

                    @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <div class="card-title">
                <div class="flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                        <h4>Team members</h4>
                    </div>
                </div>
            </div>

            <form action="{{ route('account.subscription.team.member.store') }}" method="POST" id="member-form">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="control-label">Add member by email address</label>

                    <input id="email" type="email"
                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                           name="email"
                           value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        Add member
                    </button>
                </div>
            </form>
        </div>
        <div class="list-group list-group-flush">
            @forelse($team->users as $user)
                <div class="list-group-item flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                        <h5>{{ $user->name }}</h5>
                        <div>
                            Joined {{ $user->pivot->created_at->toDateString() }}
                        </div>
                    </div>

                    <p>{{ $user->email }}</p>

                    <!-- Meta -->
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a href="{{ route('account.subscription.team.member.destroy', $user) }}"
                               data-toggle="modal"
                               data-target="#destroy-member-modal-{{ $user->id }}">
                                Delete
                            </a>

                            <form action="{{ route('account.subscription.team.member.destroy', $user) }}"
                                  method="POST"
                                  style="display: none" id="member-destroy-form-{{ $user->id }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                            </form>
                        </li>
                    </ul>
                </div>

                @include('layouts.partials.modals._confirm_modal', [
                    'modalId' => "destroy-member-modal-{$user->id}",
                    'type' => 'danger',
                    'title' => 'Delete member confirmation',
                    'message' => "Are you sure you want to remove '{$user->name}' from the team?",
                    'action' => "member-destroy-form-{$user->id}"
                ])
            @empty
                <div class="list-group-item">You have not added any team members yet.</div>
            @endforelse
        </div>
    </div>
@endsection
