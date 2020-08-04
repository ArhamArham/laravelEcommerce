<?php

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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/checkout', function () {
    return view('products.checkout');
});
Route::resource('checkout', 'OrderController');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::group(['as' => 'products.','prefix'=>'products'], function () {
    Route::get('/','ProductController@show')->name('all');
    Route::get('/{product}','ProductController@single')->name('single');
    Route::get('/addToCart/{product}','ProductController@addToCart')->name('addToCart');
    
});
Route::group(['as'=>'cart.','prefix' => 'cart'], function () {
    Route::get('/','ProductController@cart')->name('cart');
    Route::post('/remove/{product}','ProductController@removeCart')->name('remove');
    Route::post('/update/{product}','ProductController@updateCart')->name('update');
});
Route::group(['as' => 'admin.','middleware'=>['auth','admin'], 'prefix'=>'admin' ], function () {
    Route::view('product/extras', 'admin.partials.extras')->name('product.extras');
    //category remove trash restore
    Route::get('category/{id}/remove','CategoryController@remove')->name('category.remove');
    Route::get('category/trash','CategoryController@trash')->name('category.trash');
    Route::get('category/{id}/recover','CategoryController@recover')->name('category.recover');

    //product remove trash restore
    Route::get('product/{id}/remove','ProductController@remove')->name('product.remove');
    Route::get('product/trash','ProductController@trash')->name('product.trash');
    Route::get('product/{id}/recover','ProductController@recover')->name('product.recover');

    //user remove trash restore
    Route::get('profile/{id}/remove','ProfileController@remove')->name('profile.remove');
    Route::get('profile/trash','ProfileController@trash')->name('profile.trash');
    Route::get('profile/{id}/recover','ProfileController@recover')->name('profile.recover');
    Route::get('profile/states/{id?}','ProfileController@getStates')->name('profile.states');
    Route::get('profile/cities/{id?}','ProfileController@getCities')->name('profile.cities');

    Route::get('dashboard','AdminController@index')->name('dashboard');
    Route::resource('product','ProductController');
    Route::resource('category', 'CategoryController');
    Route::resource('profile', 'ProfileController');
});
