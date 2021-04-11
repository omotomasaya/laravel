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
                <li class="nav-item"><a href="{{ route('wishlist') }}"></i>Wishlist</a></li>
                <li class="nav-item"><a href="{{ route('CheckoutProducts') }}"></i> Checkout</a></li>
                <li class="nav-item"><a href="{{ route('cartproducts') }}">
                @if(Session::has('cart'))
                
                <span class="cart-with-numbers">{{Session::get('cart')->totalQuantity}}</span> 

                @endif

                Cart</a></li>

                @if(Auth::user())

                <li class="nav-item"><a href="/home"></i>Profile</a></li>

                @else

                <li class="nav-item"><a href="/login"></i>Login</a></li>

                @endif
            </ul>
        </div>
    </header>