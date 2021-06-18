@extends('layouts.index')

@section('center')
    
    <section class="wishlist-products">
        <div class="wishlist-main">
            <div class="wishlist-row">
                <h2 class="wishlist-heading">Wishlist</h2>
                <div class="wishlist-wrapper">
                    @foreach($products as $product)
                    <div class="wishlist-box">
                        <img class="product-wishlist-image">
                        <div class="wishlist-product-information">
                            <h2>{{ $product->name }}</h2>
                            <p>商品ID: {{ $product->id }}</p>
                            <span>¥{{ $product->price }}</span>
                            <div class="wishlist-product-description">
                                <span>説明</span>
                                <p>{{ $product->description }}</p>
                            </div>
                        </div>
                        <div class="product-add">
                            <a href="{{ route('AddToCartProduct',['id'=>$product->id]) }}" class="add-to-cart">cart</a>
                            <a href="{{ route('deleteWishlist',['id'=>$product->id]) }}" class="add-to-wishlist">nowish</a>
                        </div>
                    </div>
                    @endforeach
                </div>>
            </div>
        </div>
    </section>
@endsection