<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\AdminProductsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//
Route::get('/', [ProductsController::class, 'index'])->name('allProducts');

Route::get('products', [ProductsController::class, 'index'])->name('allProducts');

//Equipment
Route::get('products/equipment', [ProductsController::class, 'equipmentProducts'])->name('equipmentProducts');

//Food
Route::get('products/food', [ProductsController::class, 'foodProducts'])->name('foodProducts');

//Supplement
Route::get('products/supplement', [ProductsController::class, 'supplementProducts'])->name('supplementProducts');

//検索
Route::get('search', [ProductsController::class, 'search'])->name('searchProducts');

Route::get('products/equipmentSearch', [ProductsController::class, 'equipmentSearch'])->name('equipmentSearchProducts');

Route::get('products/foodSearch', [ProductsController::class, 'foodSearch'])->name('foodSearchProducts');

Route::get('products/supplementSearch', [ProductsController::class, 'supplementSearch'])->name('supplementSearchProducts');

//ほしい物リストに追加
Route::get('product/addToWishlist/{id}', [ProductsController::class, 'addTowishlist'])->name('addToWishlist');

//ほしい物リストに追加
Route::get('wishlist', [ProductsController::class, 'wishlist'])->name('wishlist');

//ほしい物リストから削除
Route::get('product/deleteWishlist/{id}', [ProductsController::class, 'deleteWishlist'])->name('deleteWishlist');

//カートに商品に追加
Route::get('product/addToCart/{id}', [ProductsController::class, 'addProductToCart'])->name('AddToCartProduct');

//カートの商品を表示
Route::get('cart', [ProductsController::class, 'showCart'])->name('cartproducts');

//カートから商品を削除
Route::get('product/deleteItemFromCart/{id}', [ProductsController::class, 'deleteItemFromCart'])->name('DeleteItemFromCart');

//カート内で商品を増加
Route::get('product/increaseSingleProduct/{id}', [ProductsController::class, 'increaseSingleProduct'])->name('IncreaseSingleProduct');

//カート内で商品を減少
Route::get('product/decreaseSingleProduct/{id}', [ProductsController::class, 'decreaseSingleProduct'])->name('DecreaseSingleProduct');

//購入ページ
Route::get('product/checkoutProducts/', [ProductsController::class, 'checkoutProducts'])->name('CheckoutProducts');

//商品を購入
Route::get('product/createNewOrder/', [ProductsController::class, 'createNewOrder'])->name('createNewOrder');

//注文
Route::get('product/createOrder/', [ProductsController::class, 'createOrder'])->name('CreateOrder');

//支払い
Route::post('payment', [PaymentController::class, 'payment'])->name('payment');

//支払い
Route::get('showPayment', [PaymentController::class, 'showPayment'])->name('ShowPayment');

//ユーザー認証
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//管理画面
Route::get('admin/products', [AdminProductsController::class, 'index'])->name('adminDisplayProducts')->middleware('restrictAccess');

Route::group(['middleware' => ['restrictAccess']], function(){

    //管理画面から商品を編集
    Route::get('admin/editProductForm/{id}', [AdminProductsController::class, 'editProductForm'])->name('adminEditProductForm');

    //管理画面から商品の画像を編集
    Route::get('admin/editProductImageForm/{id}', [AdminProductsController::class, 'editProductImageForm'])->name('adminEditProductImageForm');

    //商品の画像を更新
    Route::post('admin/updateProductImage/{id}', [AdminProductsController::class, 'updateProductImage'])->name('adminUpdateProductImage');

    //商品を更新
    Route::post('admin/updateProduct/{id}', [AdminProductsController::class, 'updateProduct'])->name('adminUpdateProduct');

    //商品を作成
    Route::get('admin/createProductForm', [AdminProductsController::class, 'createProductForm'])->name('adminCreateProductForm');

    //作成した商品をデータベースに保存
    Route::post('admin/sendCreateProductForm', [AdminProductsController::class, 'sendCreateProductForm'])->name('adminSendCreateProductForm');

    //商品を削除
    Route::get('admin/deleteProduct/{id}', [AdminProductsController::class, 'deleteProduct'])->name('adminDeleteProduct');

    //注文一覧
    Route::get('admin/ordersPanel/', [AdminProductsController::class, 'ordersPanel'])->name('adminOrdersPanel');

    //注文一覧から削除
    Route::get('admin/deleteOrder/{order_id}', [AdminProductsController::class, 'deleteOrder'])->name('adminDeleteOrder');

    //注文一覧から更新画面へ
    Route::get('admin/editOrderForm/{order_id}', [AdminProductsController::class, 'editOrderForm'])->name('adminEditOrderForm');

    //注文一覧から更新
    Route::post('admin/updateOrder/{order_id}', [AdminProductsController::class, 'updateOrder'])->name('adminUpdateOrder');

});




