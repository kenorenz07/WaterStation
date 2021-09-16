<?php

use App\Http\Controllers\Admin\AuthenticationController;
use App\Http\Controllers\Admin\DashboardController;
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

Route::group( ['prefix' => '/v1','middleware' => ['auth:admin-api','scopes:admin'] ],function(){
    // authenticated staff routes here 

    //Authentication Controller
    Route::get('/details',[AuthenticationController::class, 'details']);
    Route::post('/logout',[AuthenticationController::class, 'logout']);

    Route::get('/dashboard-statistics/{year}',[DashboardController::class,'getStatistics']);
 



});