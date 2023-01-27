@extends('account.layouts.default')

@section('account.content')
    <div class="card">

        <div class="card-body">
            <h4 class="card-title">{{ __('Swap subscription') }}</h4>
            <p class="card-subtitle mb-2">
                {{ __('Current plan: :name', ['name' => optional(auth()->user()->plan)->name]) }}
                ({{ config('settings.cashier.currency.symbol') }}{{ optional(auth()->user()->plan)->price }})
            </p>

            <form method="POST" action="{{ route('account.subscription.swap.store') }}">
                @csrf

                <div class="form-group row{{ $errors->has('plan') ? ' has-error' : '' }}">
                    <label for="plan" class="col-md-4 control-label">{{ __('Plan') }}</label>

                    <div class="col-md-6">

                        <select name="plan" id="plan"
                                class="form-control custom-select{{ $errors->has('plan') ? ' is-invalid' : '' }}"
                                required>
                            @foreach($plans as $plan)
                                <option value="{{ $plan->gateway_id }}"
                                        {{ request('plan') === $plan->slug ||
                                        old('plan') === $plan->gateway_id ? 'selected' : '' }}>
                                    {{ $plan->name }} (${{ $plan->price }})
                                </option>
                            @endforeach
                        </select>

                        @if ($errors->has('plan'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('plan') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Update') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
