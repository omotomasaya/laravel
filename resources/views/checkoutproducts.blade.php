
@extends('layouts.index')

@section('center')

<section class="checkout-wrapper">
    <div class="checkout-box">
        <div class="step-one">
            <h2 class="heading">Step1</h2>
        </div>

        @if(Auth::user())

        @if( DB::table('orders')->where('status', 'on_hold')->where('user_id', Auth::id())->count() > 0)

        <div>
        <a href="{{ route('ShowPayment') }}" class="">前回のお会計が済んでいません。</a>
        </div>

        @elseif(Session::has('cart'))

        @if(Session::get('cart')->totalQuantity > 0)

        <div class="register">
            <p>以下の情報に全て記入をお願いいたします</p>
        </div>
        <div class="error-text">
            {{ session('error') }}
        </div>
        <div class="shopper-informations">
            <div class="row">
                <div class="form">
                    <form action="{{ route('createNewOrder') }}">
                        @csrf
                        <input type="text" name="last_name" placeholder="姓（せい）">
                        <input type="text" name="first_name" placeholder="名（な／めい）">
                        <input type="text" name="zip" placeholder="郵便番号（ハイフンなし）">
                        <select name="prefectures">
                            <option hidden>-- 都道府県--</option>
                            <option value="北海道">北海道</option>
                            <option value="青森県">青森県</option>
                            <option value="岩手県">岩手県</option>
                            <option value="宮城県">宮城県</option>
                            <option value="秋田県">秋田県</option>
                            <option value="山形県">山形県</option>
                            <option value="福島県">福島県</option>
                            <option value="茨城県">茨城県</option>
                            <option value="栃木県">栃木県</option>
                            <option value="群馬県">群馬県</option>
                            <option value="埼玉県">埼玉県</option>
                            <option value="千葉県">千葉県</option>
                            <option value="東京都">東京都</option>
                            <option value="神奈川県">神奈川県</option>
                            <option value="新潟県">新潟県</option>
                            <option value="富山県">富山県</option>
                            <option value="石川県">石川県</option>
                            <option value="福井県">福井県</option>
                            <option value="山梨県">山梨県</option>
                            <option value="長野県">長野県</option>
                            <option value="岐阜県">岐阜県</option>
                            <option value="静岡県">静岡県</option>
                            <option value="愛知県">愛知県</option>
                            <option value="三重県">三重県</option>
                            <option value="滋賀県">滋賀県</option>
                            <option value="京都府">京都府</option>
                            <option value="大阪府">大阪府</option>
                            <option value="兵庫県">兵庫県</option>
                            <option value="奈良県">奈良県</option>
                            <option value="和歌山県">和歌山県</option>
                            <option value="鳥取県">鳥取県</option>
                            <option value="島根県">島根県</option>
                            <option value="岡山県">岡山県</option>
                            <option value="広島県">広島県</option>
                            <option value="山口県">山口県</option>
                            <option value="徳島県">徳島県</option>
                            <option value="香川県">香川県</option>
                            <option value="愛媛県">愛媛県</option>
                            <option value="高知県">高知県</option>
                            <option value="福岡県">福岡県</option>
                            <option value="佐賀県">佐賀県</option>
                            <option value="長崎県">長崎県</option>
                            <option value="熊本県">熊本県</option>
                            <option value="大分県">大分県</option>
                            <option value="宮崎県">宮崎県</option>
                            <option value="鹿児島県">鹿児島県</option>
                            <option value="沖縄県">沖縄県</option>
                        </select>
                        <input type="text" name="address" placeholder="住所">
                        <input type="text" name="phone" placeholder="電話番号（ハイフンなし）">
                        <input type="email" name="email" placeholder="メールアドレス" value="{!! Auth::user()->email !!}">
                        <select name="delivery_date">
                            <option>{{date('Y-m-d', strtotime("3 day"))}}</option>
                            <option>{{date('Y-m-d', strtotime("4 day"))}}</option>
                            <option>{{date('Y-m-d', strtotime("5 day"))}}</option>
                            <option>{{date('Y-m-d', strtotime("6 day"))}}</option>
                            <option>{{date('Y-m-d', strtotime("7 day"))}}</option>
                            <option>{{date('Y-m-d', strtotime("8 day"))}}</option>
                            <option>{{date('Y-m-d', strtotime("9 day"))}}</option>
                            <option>{{date('Y-m-d', strtotime("10 day"))}}</option>
                            <option>{{date('Y-m-d', strtotime("11 day"))}}</option>
                        </select>
                        <button class="btn-check-out" type="submit" name="submit" >支払いへ</button>
                    </form>
                </div>
            </div>
        </div>

        @else

        <div>
        <a href="{{ route('allProducts') }}" class="btn-check-out">商品一覧へ</a>カートに何も入っていません
        </div>
        
        @endif

        @else

        <div>
        <a href="{{ route('allProducts') }}" class="btn-check-out">商品一覧へ</a>カートに何も入っていません
        </div>

        @endif

        @else

        <div>
        <a href="{{ route('login') }}" class="btn-check-out">ログイン</a>ログインしてください
        </div>

        @endif


    </div>
</section>

@endsection