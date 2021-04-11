<?php

namespace App\Http\Controllers;

use App\Product;
use App\Cart;
use Illuminate\Http\Request;
use Request as PostRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{

    //
    public function index(){

        $products = Product::all();

        return view('allproducts', compact('products'));

    }

    public function equipmentProducts(){

        $products = DB::table('products')->where('type','Equipment')->get();
        return view("equipmentProducts", compact("products"));

    }

    public function foodProducts(){

        $products = DB::table('products')->where('type','Food')->get();
        return view("foodProducts", compact("products"));
        
    }

    public function supplementProducts(){

        $products = DB::table('products')->where('type','Supplement')->get();
        return view("supplementProducts", compact("products"));
        
    }

    public function search(Request $request){

        $searchText = $request->get('searchText');
        $products = Product::where('name','Like',$searchText.'%')->get();
        return view("allProducts", compact("products"));

    }

    public function equipmentSearch(Request $request){

        $searchText = $request->get('searchText');
        $products = Product::where('name','Like',$searchText.'%')->where('type', 'Equipment')->get();

        return view("equipmentProducts", compact("products"));

    }

    public function foodSearch(Request $request){

        $searchText = $request->get('searchText');
        $products = Product::where('name','Like',$searchText.'%')->where('type', 'Food')->get();

        return view("foodProducts", compact("products"));

    }

    public function supplementSearch(Request $request){

        $searchText = $request->get('searchText');
        $products = Product::where('name','Like',$searchText.'%')->where('type', 'Supplement')->get();

        return view("supplementProducts", compact("products"));

    }

    public function wishlist(){

        $user_id = Auth::id();
        $products = DB::table('wishlist')->leftJoin('products','wishlist_id', '=', 'products.id')->where('user_id', $user_id)->get();

        return view("wishlist", compact("products"));

    }

    public function addToWishlist($id){

        $product = Product::find($id);
        $isUserLoggedIn = Auth::user();
        if($isUserLoggedIn){

            $user_id = Auth::id();

            $wishlistArray = array('user_id'=>$user_id, 'wishlist_id'=>$product['id']);
            $sameArray = 
            DB::table('wishlist')->where('user_id', $user_id)->where('wishlist_id', $product['id'])->get();
            $array = json_decode(json_encode($sameArray), true);

            if($array == null){

                DB::table('wishlist')->insert($wishlistArray);

            }

            return redirect()->route('allProducts');

        }

    }

    public function deleteWishlist($id){

        $isUserLoggedIn = Auth::user();
        if($isUserLoggedIn){

            $user_id = Auth::id();
            DB::table('wishlist')->where('user_id', $user_id)->where('wishlist_id',$id)->delete();

            return redirect()->back();

        }

    }

    public function addProductToCart(Request $request, $id){

        $productCart = $request->session()->get('cart');
        $cart = new Cart($productCart);

        $product = Product::find($id);
        $cart->addItem($id, $product);
        $request->session()->put('cart', $cart);

        return redirect()->route('allProducts');

    }

    public function showCart(){

        $cart = Session::get('cart');

        if($cart){

            return view('cartproducts', ['cartItems'=>$cart]);

        }else{

            return redirect()->route('allProducts');

        }
    }

    public function deleteItemFromCart(Request $request, $id){

        $cart = $request->session()->get('cart');

        if(array_key_exists($id, $cart->items)){

            unset($cart->items[$id]);

        }

        $productCart = $request->session()->get('cart');
        $updatedCart = new Cart($productCart);
        $updatedCart->updatePriceAndQuantity();

        $request->session()->put('cart', $updatedCart);

        return redirect()->route('cartproducts');

    }

    public function increaseSingleProduct(Request $request,$id){


        $productCart = $request->session()->get('cart');
        $cart = new Cart($productCart);

        $product = Product::find($id);
        $cart->addItem($id,$product);
        $request->session()->put('cart', $cart);

        return redirect()->route("cartproducts");

    }
    
    public function decreaseSingleProduct(Request $request,$id){
      
        $productCart = $request->session()->get('cart');
        $cart = new Cart($productCart);

        if( $cart->items[$id]['quantity'] > 1){

            $product = Product::find($id);
            $cart->items[$id]['quantity'] = $cart->items[$id]['quantity']-1;
            $cart->items[$id]['totalSinglePrice'] = $cart->items[$id]['quantity'] *  $product['price'];
            $cart->updatePriceAndQuantity();

            $request->session()->put('cart', $cart);
                  
          }

        return redirect()->route("cartproducts");

    }

    public function checkoutProducts(){

        return view('checkoutproducts');

    }

    public function createNewOrder(Request $request){

        $cart = Session::get('cart');

        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $zip = $request->input('zip');
        $prefectures = PostRequest::input('prefectures');
        $address = $request->input('address');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $delivery_date = PostRequest::input('delivery_date');

        $isUserLoggedIn = Auth::user();

        if($isUserLoggedIn){

            $user_id = Auth::id();

        }

        if($first_name && $last_name&& $zip&& $prefectures&& $address&& $phone&& $email&& $delivery_date){

            if(preg_match('/^[0-9]+$/', $zip) && preg_match('/^[0-9]+$/', $phone)){

                if($cart){

                    $date = date('Y-m-d H:i:s');
                    $newOrderArray = array('user_id'=>$user_id, 'status'=>'on_hold', 'date'=>$date, 'delivery_date'=>$delivery_date, 'price'=>$cart->totalPrice, 'first_name'=>$first_name, 'last_name'=>$last_name, 'zip'=>$zip, 'prefectures'=>$prefectures, 'address'=>$address, 'email'=>$email, 'phone'=>$phone);

                    $created_order = DB::table('orders')->insert($newOrderArray);
                    $order_id = DB::getPdo()->lastInsertId();

                    foreach ($cart->items as $cart_item){

                        $item_id = $cart_item['data']['id'];
                        $item_name = $cart_item['data']['name'];
                        $item_price = $cart_item['data']['price'];
                        $newItemsInCurrentOrder = array('item_id'=>$item_id,'order_id'=>$order_id,'item_name'=>$item_name,'item_price'=>$item_price);
                        $created_order_items = DB::table('order_items')->insert($newItemsInCurrentOrder);

                    }

                    $payment_info = $newOrderArray;
                    $payment_info['order_id'] = $order_id;
                    $request->session()->put('payment_info',$payment_info);
                    return redirect()->route('ShowPayment');

                }else{

                    return redirect()->route('allProducts');

                }

            }else{

                return redirect()->route('CheckoutProducts')->with('error','正しく記入してください');

            }

        }else{

            return redirect()->route('CheckoutProducts')->with('error','全て記入してください');

        }
        
    }
}
