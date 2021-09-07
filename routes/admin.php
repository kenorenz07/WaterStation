<?php

use App\Http\Controllers\Admin\AuthenticationController;
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

Route::post('/login',[AuthenticationController::class, 'login'])->name('login');

Route::group( ['prefix' => '/v1','middleware' => ['auth:admin-api'] ],function(){
    // authenticated staff routes here 
    Route::get('/details',[AuthenticationController::class, 'details']);
 

    Route::post('logout',[AuthenticationController::class, 'logout']);


});