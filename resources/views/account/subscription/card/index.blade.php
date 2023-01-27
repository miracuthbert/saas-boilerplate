@extends('account.layouts.default')

@section('account.content')
    <div class="card">

        <div class="card-body">
            <h4 class="card-title">{{ __('Update card') }}</h4>
            <p class="card-subtitle mb-2">Your card will be used for future payments.</p>

            <form method="POST" action="{{ route('account.subscription.card.store') }}" id="payment-form">
                {{ csrf_field() }}

                <div id="card-error mb-2"></div>

                <div class="form-group mb-5">
                    <label for="card-holder-name" class="control-label">{{ __('Full name') }}</label>
                    <input type="text" id="card-holder-name" class="form-control mt-1" value="{{ auth()->user()->name }}" />
                </div>

                <div class="form-group">
                    <label for="card-holder-name" class="control-label mb-3">{{ __('Card details') }}</label>
                    <!-- Stripe Elements Placeholder -->
                    <div id="card-element"></div>
                </div>

                <div class="form-group mt-5">
                    <button type="submit" class="btn btn-primary" id="card-button" data-secret="{{ optional($intent)->client_secret }}">
                        {{ __('Update card') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
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
        e.preventDefault()
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
            document.getElementById('card-error').innerText = error.message
            document.getElementById('card-button').disabled = false
        } else {
            let form = document.getElementById('payment-form')

            cardButton.disabled = true

            $input = document.createElement('input')
            $input.type = 'hidden'
            $input.name = 'payment_method'
            $input.value = setupIntent.payment_method

            form.append($input)

            form.submit()
        }
    });
</script>
@endpush
