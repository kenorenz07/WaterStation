<?php

use App\Http\Controllers\User\AuthenticationController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\ProductController;
use Illuminate\Http\Request;
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
Route::post('/test',function(){
    return "test";
});

Route::group( ['prefix' => '/v1','middleware' => ['auth:user-api','scopes:user'] ],function(){
    // authenticated staff routes here 
    Route::get('/details',[AuthenticationController::class, 'details']);
    Route::post('logout',[AuthenticationController::class, 'logout']);

    Route::get('/product/all',[ProductController::class,'index']);

    Route::get('/cart/all/{user}',[CartController::class,'index']);
    Route::post('/cart/add/{user}/{product}',[CartController::class,'addProductToCart']);
    Route::put('/cart/update/{cart}',[CartController::class,'updateProductQuantity']);
    Route::delete('/cart/delete/{cart}',[CartController::class,'removeProductToCart']);


});