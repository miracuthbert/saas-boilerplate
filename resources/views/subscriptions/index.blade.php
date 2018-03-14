@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Subscription</h4>

                        <form method="POST" action="{{ route('subscription.store') }}" id="payment-form">
                            {{ csrf_field() }}

                            <div class="form-group row{{ $errors->has('plan') ? ' has-error' : '' }}">
                                <label for="plan" class="col-md-4 control-label">Plan</label>

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

                            <div class="form-group row{{ $errors->has('coupon') ? ' has-error' : '' }}">
                                <label for="coupon" class="col-md-4 control-label">Coupon</label>

                                <div class="col-md-6">
                                    <input id="coupon" type="text"
                                           class="form-control{{ $errors->has('coupon') ? ' is-invalid' : '' }}"
                                           name="coupon" value="{{ old('coupon') }}">

                                    @if ($errors->has('coupon'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('coupon') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary" id="pay">
                                        Pay
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container -->

@endsection

@section('scripts')
    <script src="https://checkout.stripe.com/checkout.js"></script>
    <script>
        let handler = StripeCheckout.configure({
            key: '{{ config('services.stripe.key') }}',
            locale: 'auto',
            token: function (token) {
                let form = $('#payment-form')

                $('#pay').prop('disabled', true)

                $('<input>').attr({
                    type: 'hidden',
                    name: 'token',
                    value: token.id,
                }).appendTo(form)

                form.submit();
            }
        })

        $('#pay').click(function (e) {
            handler.open({
                name: 'Laravel SaaS',
                description: 'Membership',
                currency: '{{ config('settings.cashier.currency') }}',
                key: '{{ config('services.stripe.key') }}',
                email: '{{ auth()->user()->email }}'
            })

            e.preventDefault();
        })
    </script>
@endsection
