<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Request as PostRequest;
use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminProductsController extends Controller
{
    //商品を表示
    public function index(){

        $products = Product::all();

        return view('admin.displayProducts', ['products'=>$products]);

    }

    //商品を作成
    public function createProductForm(){

        return view('admin.createProductForm');

    }

    //作成した商品をデータベースに保存
    public function sendCreateProductForm(Request $request){

        $name = $request->input('name');
        $description = $request->input('description');
        $type = PostRequest::input('type');
        $price = $request->input('price');
        $date = Carbon::now();

        Validator::make($request->all(),['image'=>"required|file|image|mimes:jpg,png,jpeg|max:5000"]);
        $ext = $request->file('image')->getClientOriginalExtension();
        $stringImage = str_replace(' ','',$date);

        $imageName = $stringImage.'.'.$ext;

        $imageEncoded = File::get($request->image);
        Storage::disk('local')->put('public/product_images/'.$imageName, $imageEncoded);

        $newProductArray = array('name'=>$name, 'description'=>$description, 'image'=>$imageName, 'type'=>$type, 'price'=>$price);

        $created = DB::table('products')->insert($newProductArray);

        if($created){

            return redirect()->route('adminDisplayProducts');

        }else{

            return '商品の登録に失敗しました';

        }

    }

    //商品を編集
    public function editProductForm($id){

        $products = Product::find($id);
        return view('admin.editProductForm', ['product'=>$products]);

    }

    //商品の画像を編集
    public function editProductImageForm($id){

        $products = Product::find($id);
        return view('admin.editProductImageForm', ['product'=>$products]);

    }

    //商品の画像を更新
    public function updateProductImage(Request $request, $id){

        Validator::make($request->all(),['image'=>"required|file|image|mimes:jpg,png,jpeg|max:5000"]);

        if($request->hasFile("image")){

            $product = Product::find($id);
            $exists = Storage::disk('local')->exists("public/product_images/".$product->image);

            if($exists){
                Storage::delete('public/product_images/'.$product->image);
            }

            $ext = $request->file('image')->getClientOriginalExtension();

            $request->image->storeAs("public/product_images/",$product->image);

            $arrayToUpdate = array('image'=>$product->image);
            DB::table('products')->where('id',$id)->update($arrayToUpdate);

            return redirect()->route('adminDisplayProducts');

        }else{

            $error = 'No image was selected';
            return $error;

        }

    }

    //商品を更新
    public function updateProduct(Request $request, $id){

        $name = $request->input('name');
        $description = $request->input('description');
        $type = PostRequest::input('type');
        $price = $request->input('price');

        $updateArray = array('name'=>$name, 'description'=>$description, 'type'=>$type, 'price'=>$price);

        DB::table('products')->where('id', $id)->update($updateArray);

        return redirect()->route('adminDisplayProducts');

    }

    //商品を削除
    public function deleteProduct($id){

        $product = Product::find($id);

        $exists = Storage::disk('local')->exists('public/product_images/'.$product->image);

        if($exists){

            Storage::delete('public/product_images/'.$product->image);

        }

        Product::destroy($id);

        return redirect()->route('adminDisplayProducts');

    }

    //注文一覧へ
    public function ordersPanel(){

        $orders = DB::table('orders')->get();

        return view('admin.ordersPanel', ['orders'=>$orders]);

    }

    //注文削除
    public function deleteOrder(Request $request, $id){

        $deleted = DB::table('orders')->where('order_id', $id)->delete();

        if($deleted){
            return redirect()->back()->with('orderDeletionStatus','Order '.$id.' was successfully deleted');
        }else{
            return redirect()->back()->with('orderDeletionStatus','Order '.$id.' was not deleted');
        }

    }

    //注文編集
    public function editOrderForm($order_id){

        $order = DB::table('orders')->where('order_id',$order_id)->get();

        return view('admin.editOrderForm',['order'=>$order[0]]);
    }

    //注文更新
    public function updateOrder(Request $request, $order_id){

        $date = $request->input('date');
        $delivery_date = $request->input('delivery_date');
        $price = $request->input('price');
        $status = $request->input('status');

        $updateArray = array('date'=>$date,'delivery_date'=>$delivery_date,'status'=>$status,'price'=>$price);

        DB::table('orders')->where('order_id',$order_id)->update($updateArray);

        return redirect()->route('adminOrdersPanel');
        
    }
}
