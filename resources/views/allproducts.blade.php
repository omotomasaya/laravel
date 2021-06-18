@extends('layouts.index')

@section('center')

<section class="heading">
        <div class="heading-container"> 
            <div class="heading-item">
                <div class="item-box">
                    <h2>理想の体と健康を手に入れよう！</h2>
                    <p>筋肉は、タンパク質でできており、タンパク質を含んだ食品が体に入ってから、さまざまな栄養素を介して筋肉となります。<br>
                    食事を制限することでエネルギー不足に陥ると、筋肉量も減ってしまう可能性があります。<br>体がエネルギー源として筋肉内にあるアミノ酸を放出し、それによりタンパク質の分解が増え、その結果筋肉量が減少してしまいます。<br>
                    筋肉の肥大のためには、過不足なく栄養素を摂ることが重要です。</p>
                </div>
            </div>
        </div>
    </section>
    
    <section class="products">
        <div class="main">
            <div class="main-row">
                <div class="left-sidebar">
                    <h2>Category</h2>
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="{{ route('equipmentProducts')}}">
                                Equipment
                            </a>
                        </h4>
                    </div>
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="{{ route('foodProducts')}}">
                                Food
                            </a>
                        </h4>
                    </div>
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="{{ route('supplementProducts')}}">
                                Supplement
                            </a>
                        </h4>
                    </div>
                </div>
                
                <div class="features-items">
                    <h2 class="features-center">Features Items</h2>
                    <div class="search-box">
                        <form action="search" method="get">
                            <input type="text" name="searchText"  placeholder="Search">
                        </form>
                    </div>
                    <div class="product-wrapper">
                        @foreach($products as $product)
                        <div class="product-box">
                            <div class="single-products">
                                <div class="prducts-content">
                                    <img src="{{asset ('storage')}}/product_images/{{$product['image']}}" class="products-image">
                                    <h2>¥{{$product->price}}</h2>
                                    <h3 class="product-name">{{$product->name}}</h3>
                                    <p class="product-description">{{ $product->description }}</p>
                                    <a href="{{ route('AddToCartProduct',['id'=>$product->id]) }}" class="add-to-cart">cart</a>
                                    @if( DB::table('wishlist')->where('user_id', Auth::id())->where('wishlist_id', $product->id)->exists() )

                                    <a href="{{ route('deleteWishlist',['id'=>$product->id]) }}" class="add-to-wishlist">nowish</a>

                                    @else

                                    <a href="{{ route('addToWishlist',['id'=>$product->id]) }}" class="add-to-wishlist">wish</a>

                                    @endif

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection