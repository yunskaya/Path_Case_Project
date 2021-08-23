<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;


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

Route::post('/login', [AuthController::class ,'login'])->name('login');    

Route::middleware('auth:api')->group(function () {

    Route::post('/logout', [AuthController::class ,'logout'])->name('logout');    

    Route::get('/order',[OrderController::class , 'index'])->name('order');
    Route::post('/order',[OrderController::class , 'store'])->name('order.store');
    Route::get('/order/{order}',[OrderController::class , 'show'])->name('order.show');
    Route::match(['put', 'patch'], '/order/{order}',[OrderController::class , 'update'])->name('order.update');

});

