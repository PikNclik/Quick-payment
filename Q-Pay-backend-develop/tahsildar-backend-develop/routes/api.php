<?php

use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\BankCrudController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\UserCrudController;
use App\Http\Controllers\Api\CityCrudController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\User\BankController;
use App\Http\Controllers\Api\User\NotificationCrudController;
use App\Http\Controllers\Api\User\PaymentCrudController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/* Admin Routes*/
Route::group(['prefix' => 'admin'], function () {

    Route::post('login', [AuthController::class, 'login']);

    // check ability for admin routes.
    Route::middleware(['auth:sanctum', 'lang', 'ability:admin'])->group(function () {

        Route::get('cities',[CityCrudController::class,'index']);

        Route::resource('bank', BankCrudController::class,[
            'only' => ['index','store','destroy']
        ]);
        Route::resource('user', UserCrudController::class);
        Route::post('block/{id}', [UserCrudController::class,'block']);
        Route::get('statistics', [DashboardController::class,'getStatistics']);
        Route::get('statistics/line-chart', [DashboardController::class,'getStatisticsCharts']);

        Route::get('payment',[\App\Http\Controllers\Api\Admin\PaymentCrudController::class,'index']);
        Route::get('payment/excel',[\App\Http\Controllers\Api\Admin\PaymentCrudController::class,'export']);
        Route::post('payment/excel',[\App\Http\Controllers\Api\Admin\PaymentCrudController::class,'import']);
        Route::post('payment/cancel/{id}',[\App\Http\Controllers\Api\Admin\PaymentCrudController::class,'cancel']);
    });
    Route::post('logout', [AuthController::class, 'logout']);
});



/* User Routes*/
Route::post('/login', [App\Http\Controllers\Api\User\AuthController::class, 'login'])->middleware('throttle:api/login');
Route::post('/verify-code', [\App\Http\Controllers\Api\User\AuthController::class, 'verifyUser'])->middleware('throttle:api/verify-code');

Route::get('payment/excel',[PaymentCrudController::class,'export']);

// check ability for user routes.
Route::middleware(['auth:sanctum', 'lang','ability:user'])->group(function () {

    Route::put('user',[UserController::class,'updateProfile']);
    Route::post('user/language',[UserController::class,'updateLanguage']);
    Route::post('user/fcm-token',[UserController::class,'updateFcm']);
    Route::delete('user/fcm-token',[UserController::class,'deleteFcm']);
    Route::get('payment/total-paid',[PaymentCrudController::class,'getSumPaidAmount']);
    Route::get('payment/excel',[PaymentCrudController::class,'export']);
    Route::post('payment/cancel/{id}',[\App\Http\Controllers\Api\Admin\PaymentCrudController::class,'cancel']);
    Route::resource('payment', PaymentCrudController::class,[
        'only' => ['index','store','show']
    ]);
    Route::get('bank',[BankController::class,'index']);
    Route::get('notification',[NotificationCrudController::class,'index']);

    Route::get('cities',[CityCrudController::class,'index']);

    Route::post('/logout', [\App\Http\Controllers\Api\User\AuthController::class, 'logout']);
});


Route::middleware(['auth:sanctum','lang','ability:admin,user'])->group(function (){

    // media routes
    Route::post('upload-media-url', [MediaController::class, 'uploadMediaFromUrl']);
    Route::post('upload-media', [MediaController::class, 'uploadMedia']);
    Route::delete('delete-media/{id}', [MediaController::class, 'deleteMedia']);

    // settings routes
    Route::get('settings/get-by-key/{key}',[SettingController::class,'get_by_key']);
});
