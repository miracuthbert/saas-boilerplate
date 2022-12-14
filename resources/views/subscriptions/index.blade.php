@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('Subscription') }}</h4>

                        <form method="POST" action="{{ route('subscription.store') }}" id="payment-form">
                            @csrf

                            <div id="card-error" class="invalid-feedback mb-2"></div>

                            <div class="form-group row">
                                <label for="card-holder-name" class="col-md-4 control-label">{{ __('Full name') }}</label>

                                <div class="col-md-6">
                                    <input id="card-holder-name" type="text" value="{{ auth()->user()->name }}">
                                </div>
                            </div>

                            <div class="form-group row{{ $errors->has('plan') ? ' has-error' : '' }}">
                                <label for="plan" class="col-md-4 control-label">{{ __('Plan') }}</label>

                                <div class="col-md-6">

                                    <select name="plan" id="plan"
                                        class="form-control custom-select{{ $errors->has('plan') ? ' is-invalid' : '' }}"
                                        required>
                                        @foreach ($plans as $plan)
                                            <option value="{{ $plan->gateway_id }}"
                                                {{ request('plan') === $plan->slug || old('plan') === $plan->gateway_id ? 'selected' : '' }}>
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

                            <div class="form-group mb-3 {{ $errors->has('payment_method') ? ' has-error' : '' }}">
                                <label>{{ __('Payment details') }}</label>

                                <!-- Stripe Elements Placeholder -->
                                <div id="card-element"></div>

                                <x-input-error name="payment_method" />
                            </div>

                            <div class="form-group row{{ $errors->has('coupon') ? ' has-error' : '' }}">
                                <label for="coupon" class="col-md-4 control-label">{{ __('Coupon') }}</label>

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
                                    <button type="submit" class="btn btn-primary" id="card-button"
                                        data-secret="{{ $intent->client_secret }}">
                                        {{ __('Pay') }}
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

@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe(@js(config('services.stripe.key')));
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;

        cardButton.addEventListener('click', async (e) => {
            const { setupIntent, error } = await stripe.confirmCardSetup(clientSecret, {
                payment_method: {
                    card: cardElement,
                    billing_details: {
                        name: cardHolderName.value
                    }
                }
            });

            if (error) {
                // Display "error.message" to the user...
                console.log(error.message)
                $('#card-error').text(error.message)
                $('#card-button').prop('disabled', false)
            } else {
                let form = $('#payment-form')

                $('#card-button').prop('disabled', true)

                $('<input>').attr({
                    type: 'hidden',
                    name: 'payment_method',
                    value: setupIntent.payment_method,
                }).appendTo(form)

                form.submit();
            }
        });
    </script>
    {{-- <script src="https://checkout.stripe.com/checkout.js"></script>
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
    </script> --}}
@endpush
