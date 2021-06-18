@extends('layouts.index')

@section('center')

<section class="cart-items">
    <div class="cart-container">
        <table class="cart-table">
            <thead>
                <tr class="cart-menu">
                    <td class="image">Item</td>
                    <td class="description"></td>
                    <td class="price">Price</td>
                    <td class="quantity">Quantity</td>
                    <td class="total">Total</td>
                    <td class="delete"></td>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems->items as $item)
                <tr>
                    <td class="cart-image">
                        <img src="{{ Storage::disk('local')->url('product_images/'.$item['data']['image']) }}" class="cart-product-image">
                    </td>
                    <td class="cart_description">
                        <h4><a href="">{{ $item['data']['name'] }}</a></h4>
                        <p class="cart-product-description">{{ $item['data']['description'] }}</p>
                        <p>Web ID:{{ $item['data']['id'] }}</p>
                    </td>
                    <td class="cart_price">
                        <p>¥{{ $item['data']['price'] }}</p>
                    </td>
                    <td class="cart_quantity">
                        <div class="cart_quantity_button">
                            <a class="cart_quantity_up" href="{{ route('IncreaseSingleProduct',['id' => $item['data']['id']]) }}"> + </a>
                            <input class="cart_quantity_input" type="text" name="quantity" value="{{ $item['quantity'] }}" size="3">
                            <a class="cart_quantity_down" href="{{ route('DecreaseSingleProduct',['id' => $item['data']['id']]) }}"> - </a>
                        </div>
                    </td>
                    <td class="cart_total">
                        <p class="cart_total_price">¥{{ $item['totalSinglePrice'] }}</p>
                    </td>
                    <td class="cart-delete">
                        <a class="cart-quantity-delete" href="{{ route('DeleteItemFromCart', ['id'=>$item['data']['id']]) }}">delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

<section class="total-wrapper">
    <div class="total-box">
        <div class="heading">
            <h3>お会計</h3>
        </div>
        <div class="total-area">
            <ul>
                <li>量 : <span>{{ $cartItems->totalQuantity }}</span></li>
                <li>合計 : <span>¥{{ $cartItems->totalPrice }}</span></li>
            </ul>
            <a class="btn-check-out" href="{{ route('CheckoutProducts') }}">Check Out</a>
        </div>
    </div>
</section>

@endsection

