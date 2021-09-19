<?php

use App\Http\Controllers\DeliveryMan\AuthenticationController;
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

Route::group( ['prefix' => '/v1','middleware' => ['auth:delivery_man-api','scopes:delivery_man'] ],function(){
    // authenticated staff routes here 
    Route::get('/details',[AuthenticationController::class, 'details']);
 

    Route::post('logout',[AuthenticationController::class, 'logout']);


});