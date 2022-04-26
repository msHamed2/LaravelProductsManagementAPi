<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ProductsController;
use App\Http\Controllers\AuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::controller(AuthController::class)->prefix('users')->group(function (){
    Route::post('/signup','register')->middleware('guest');
    Route::post('/login','login')->middleware('guest');
    Route::get('/logout','logout')->middleware('auth:sanctum');
});
Route::resource('products', ProductsController::class);
Route::post('/send-notification',[\App\Http\Controllers\FirebaseController::class,'notification'])->name('notification')->can('create');
Route::post('/send-notification-to-one',[\App\Http\Controllers\FirebaseController::class,'oneNotification'])->can('create');
Route::get('/get-notification',[\App\Http\Controllers\FirebaseController::class,'getNotification'])->middleware('auth:sanctum');
