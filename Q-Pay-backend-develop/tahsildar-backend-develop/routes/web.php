<?php

use App\Http\Controllers\PaymentController;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('payForm/{id}',[PaymentController::class,'formPay'])->name('payForm');
Route::get('pay/{id}',[PaymentController::class,'pay'])->name('pay');
Route::get('confirm-payment/{uuid}',[PaymentController::class,'confirmPayment'])->name('confirm');
Route::get('reverse-payment/{uuid}',[PaymentController::class,'reversePayment'])->name('reverse');

Route::post('payment-callback',[PaymentController::class,'callBack'])->name('payment.callback');
Route::get('failed-payment',function (){
    return view('payment.error',['message' => 'Payment is Failed Please try again later']);
})->name('payment.error');
