<?php

use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\AuthenticationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DeliveryManController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\UserController;
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

Route::group( ['prefix' => '/v1','middleware' => ['auth:admin-api','scopes:admin'] ],function(){
    // authenticated staff routes here 

    //Authentication Controller
    Route::get('/details',[AuthenticationController::class, 'details']);
    Route::post('/logout',[AuthenticationController::class, 'logout']);
    Route::post('/update',[AuthenticationController::class, 'update']);

    Route::get('/dashboard-statistics/{year}',[DashboardController::class,'getStatistics']);
 

    // DELIVERY MAN
    Route::get('/delivery-man/all',[DeliveryManController::class,'index']);
    Route::get('/delivery-man/show/{delivery_man}',[DeliveryManController::class,'show']);
    Route::post('/delivery-man/create',[DeliveryManController::class,'store']);
    Route::put('/delivery-man/update/{delivery_man}',[DeliveryManController::class,'update']);
    Route::delete('/delivery-man/delete/{delivery_man}',[DeliveryManController::class,'delete']);

    // PRODUCTS    
    Route::get('/product/all',[ProductController::class,'index']);
    Route::get('/product/show/{product}',[ProductController::class,'show']);
    Route::post('/product/create',[ProductController::class,'store']);
    Route::put('/product/update/{product}',[ProductController::class,'update']);
    Route::delete('/product/delete/{product}',[ProductController::class,'delete']);

    // CUSTOMERS    
    Route::get('/user/all',[UserController::class,'index']);
    Route::get('/user/show/{user}',[UserController::class,'show']);
    Route::post('/user/create',[UserController::class,'store']);
    Route::put('/user/update/{user}',[UserController::class,'update']);
    Route::delete('/user/delete/{user}',[UserController::class,'delete']);

    // ORDERS
    Route::get('/order/all',[OrderController::class,'index']);
    Route::post('/order-set-delivery-man/{order}',[OrderController::class,'updateDeliveryMan']);
    Route::post('/order-set-delivery-time-date/{order}',[OrderController::class,'updateDateTimeDeliver']);
    Route::post('/order-status/{order}',[OrderController::class,'updateStatus']);
    Route::get('/order/generate-pdf/{start}/{end}/{status}', [OrderController::class, 'createPDF']);

    // SALES
    Route::get('/sales/all',[SaleController::class,'index']);
    Route::get('/sales/generate-pdf/{start}/{end}/{delivery_men}', [SaleController::class, 'createPDF']);

    // REVIEWS 
    Route::get('/reviews/all',[ReviewController::class,'index']);
    Route::get('/review/{review}',[ReviewController::class,'getReview']);
    Route::post('/review/add-reply/{review}',[ReviewController::class,'addReply']);
    Route::put('/review/update-reply/{reply}',[ReviewController::class,'updateReply']);
    Route::delete('/review/delete-reply/{reply}',[ReviewController::class,'deleteReply']);

     // CUSTOMERS    
     Route::get('/announcement/all',[AnnouncementController::class,'index']);
     Route::post('/announcement/create',[AnnouncementController::class,'store']);
     Route::put('/announcement/update/{announcement}',[AnnouncementController::class,'update']);
     Route::delete('/announcement/delete/{announcement}',[AnnouncementController::class,'delete']);
     
});