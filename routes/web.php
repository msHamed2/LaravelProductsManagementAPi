<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/auth/{provider}',[\App\Http\Controllers\AuthController::class,'faceBookRedirect']);
Route::get('/auth/{provider}/callback',[\App\Http\Controllers\AuthController::class,'facebookLogin']);
Route::get('home', [\App\Http\Controllers\FirebaseController::class, 'index'])->name('home');
Route::post('/fcm-token', [\App\Http\Controllers\FirebaseController::class, 'updateToken'])->name('fcmToken')->middleware('auth:sanctum');
Route::post('/send-notification',[\App\Http\Controllers\FirebaseController::class,'notification'])->name('notification');
Route::get('/dashboard',function (){
    return view('dashboard');
});

//Auth::routes();

