<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{asset('css/main.css')}}" rel="stylesheet">
    <title>筋SHOP</title>
</head>

<body>
    <header class="header">
        <div class="header-row">
            <h1 class="logo">
                <a href="/">筋SHOP</a>
            </h1>
            <div class="thank-purchace-text">
                {{ session('message') }}
            </div>
            <ul class="nav header-nav">
                <li class="nav-item"><a href="{{ route('allProducts') }}"></i>Products</a></li>

                @if(Auth::user())

                <li class="nav-item"><a href="{{ route('wishlist') }}">

                @if( DB::table('wishlist')->where('user_id', Auth::id())->count() > 0 )
                <span class="cart-with-numbers">
                {{ DB::table('wishlist')->where('user_id', Auth::id())->count() }}</span>

                @endif

                Wishlist</a></li>

                @else

                <li class="nav-item"><a href="{{route('login') }}">Wishlist</a></li>

                @endif

                <li class="nav-item"><a href="{{ route('CheckoutProducts') }}"></i> Checkout</a></li>

                <li class="nav-item"><a href="{{ route('ShowPayment') }}">

                @if( DB::table('orders')->where('status', 'on_hold')->where('user_id', Auth::id())->count() > 0 )

                <span class="cart-with-numbers">
                {{ DB::table('orders')->where('status', 'on_hold')->where('user_id', Auth::id())->count() }}</span>

                @endif

                Payment</a></li>

                <li class="nav-item"><a href="{{ route('cartproducts') }}">
                @if(Session::has('cart'))

                @if(Session::get('cart')->totalQuantity != 0)
                <span class="cart-with-numbers">{{Session::get('cart')->totalQuantity}}</span> 
                @endif

                @endif

                Cart</a></li>

                @if(Auth::user())

                <li class="nav-item"><a href="{{route('home') }}">Profile</a></li>

                @else

                <li class="nav-item"><a href="{{route('login') }}">Login</a></li>

                @endif
            </ul>
        </div>
    </header>