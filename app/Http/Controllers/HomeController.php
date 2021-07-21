<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function accountDelete(){

        return view('accountDelete');

    }

    public function delete(Request $request){

        $isUserLoggedIn = Auth::user();

        if($isUserLoggedIn){

            $user_id = Auth::id();

        }

        $userData = DB::table('users')->where('id', $user_id)->get();
        $userData = json_decode(json_encode($userData[0]), true);

        $email = $request->input('email');
        $pass = $request->input('password');
        $passConfirm = $request->input('passConfirm');

        //var_dump($userData);
        // var_dump($email);
        // var_dump($pass);
        // var_dump($passConfirm);

        if(empty($email) or empty($pass) or empty($passConfirm)){

            return redirect()->route('accountDelete')->with('error','全て記入してください');

        }else{

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){

                return redirect()->route('accountDelete')->with('error','メールアドレスの形式が不正です。');

            }elseif($pass === $passConfirm and $email === $userData['email']){

                if(password_verify($pass, $userData['password'])){

                    DB::table('users')->where('id',$userData['id'])->delete();
                    return redirect()->route('allProducts')->with('message', 'アカウント削除できました。');

                }else{

                    return redirect()->route('accountDelete')->with('error','削除できませんでした。');

                }
            }
        }

    }

}
