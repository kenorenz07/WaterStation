<?php

use App\Http\Controllers\User\AuthenticationController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\ReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login',[AuthenticationController::class, 'login']);
Route::post('/register',[AuthenticationController::class, 'register']);

Route::group( ['prefix' => '/v1','middleware' => ['auth:user-api','scopes:user'] ],function(){
    // authenticated staff routes here 
    Route::get('/details',[AuthenticationController::class, 'details']);
    Route::post('logout',[AuthenticationController::class, 'logout']);

    Route::get('/product/all',[ProductController::class,'index']);

    Route::get('/cart/all/',[CartController::class,'index']);
    Route::post('/cart/add/{product}',[CartController::class,'addProductToCart']);
    Route::put('/cart/update/{cart}',[CartController::class,'updateProductQuantity']);
    Route::delete('/cart/delete/{cart}',[CartController::class,'removeProductToCart']);

    Route::post('/place-order/',[OrderController::class,'placeOrder']);
    Route::get('/order/all/',[OrderController::class,'getAllOrdersOfUser']);

    Route::get('reviews',[ReviewController::class,'index']);
    Route::post('reviews/add',[ReviewController::class,'create']);
    Route::put('reviews/update/{review}',[ReviewController::class,'update']);
    Route::delete('reviews/delete/{review}',[ReviewController::class,'delete']);

});