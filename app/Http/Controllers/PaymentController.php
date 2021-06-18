<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;
use Stripe\Charge;
use App\Product;
use App\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    //購入画面
    public function showPayment(){

     $payment_info = Session::get('payment_info');

        //
        if($payment_info['status'] == 'on_hold'){
            return view('payment.showPayment',['payment_info'=> $payment_info]);
         
        }else{
             return redirect()->route("allProducts");
           }

        


    }

    //支払い
    public function payment(Request $request){

        $payment_info = Session::get('payment_info');
        $order_id = $payment_info['order_id'];
        $status = $payment_info['status'];
        $amount = $payment_info['price'];
        $isUserLoggedIn = Auth::user()->id;
        $name = Auth::user()->name;

        \DB::beginTransaction();
        try{

          if($status == 'on_hold'){
       
            $newPaymentArray = array('stripe_id' => $isUserLoggedIn,'stripe_status'=>'paid', 'user_id'=>$isUserLoggedIn, 'name'=>$name);

            $created_order = DB::table("subscriptions")->insert($newPaymentArray);
       
            DB::table('orders')->where('order_id', $order_id)->update(['status' => 'paid']);

            Session::forget("cart");
       
          }

         Stripe::setApiKey(env('STRIPE_SECRET'));

           $charge = Charge::create(array(
                'amount' => $payment_info['price'],
                'currency' => 'jpy',
                'source'=> request()->stripeToken,
            ));
          return redirect()->route('allProducts')->with('message', 'ご購入ありがとうございました');
          \DB::commit();
        }catch(\Throwable $e){
          \DB::rollback();
          echo 'エラー：'.$e->getMessage();
        }
     }
}
