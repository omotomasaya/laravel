
@extends('layouts.index')

@section('center')

@if(Auth::user())

@if( DB::table('orders')->where('status', 'on_hold')->where('user_id', Auth::id())->get() )

<section class="checkout-wrapper">
    <div class="checkout-box">
        <div class="step-one">
            <h2 class="heading">Step2</h2>
        </div>
        <div class="register">
            <p>以下の情報に全て記入をお願いいたします</p>
        </div>
        <div class="shopper-informations">
            <div class="row">
                <div class="form">
                    <form action="{{ route('payment') }}" method="POST">
                    @csrf
                    <script
                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                        data-key="{{ env('STRIPE_KEY') }}"
                        data-amount="{{ $payment_info['price'] }}"
                        data-name="Stripe決済デモ"
                        data-label="決済をする"
                        data-description="これはデモ決済です"
                        data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                        data-locale="auto"
                        data-currency="JPY">
                    </script>
                </form>
                </div>
            </div>
        </div>
    </div>
</section>

@else

<div>
<a href="{{ route('allProducts') }}" class="btn-check-out">商品一覧へ</a>
</div>

@endif

@endif

@endsection