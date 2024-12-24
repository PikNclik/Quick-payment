<?php

use App\Http\Controllers\Api\Admin\ProfessionController;
use App\Http\Controllers\Api\Admin\RoleCrudController;
use App\Http\Controllers\Api\Admin\AdminCrudController;
use App\Http\Controllers\Api\Admin\AuditController;
use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\BankCrudController;
use App\Http\Controllers\Api\Admin\CommissionCrudController;
use App\Http\Controllers\Api\Admin\CustomerController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\PermissionCategoryCrudController;
use App\Http\Controllers\Api\Admin\PermissionCrudController;
use App\Http\Controllers\Api\Admin\SystemBankDataController;
use App\Http\Controllers\Api\Admin\TerminalBankController;
use App\Http\Controllers\Api\Admin\TransactionToDoController;
use App\Http\Controllers\Api\Admin\UserCrudController;
use App\Http\Controllers\Api\Admin\WorkingDayHolidaysController;
use App\Http\Controllers\Api\BusinessDomainCrudController;
use App\Http\Controllers\Api\BusinessTypeCrudController;
use App\Http\Controllers\Api\CityCrudController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\OriginCrudController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\ThirdParty\BeOrderController;
use App\Http\Controllers\Api\User\BankController;
use App\Http\Controllers\Api\User\NotificationCrudController;
use App\Http\Controllers\Api\User\PaymentCrudController;
use App\Http\Controllers\Api\User\TransferController;
use App\Http\Controllers\Api\User\UserController;
use App\Imports\PaymentRequestImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

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

    Route::middleware(['auth:sanctum', 'lang', 'idle.timeout'])->group(function () {

        Route::resource('role', RoleCrudController::class)->middleware('role:Super Admin');
        Route::resource('audit', AuditController::class, [
            'only' => ['index']
        ])->middleware('role:Super Admin');
        Route::post('role/permissions', [RoleCrudController::class, 'setPermissions'])->middleware('role:Super Admin');

        Route::resource('permission', PermissionCrudController::class, [
            'only' => ['index']
        ]);
        Route::resource('permission_category', PermissionCategoryCrudController::class, [
            'only' => ['index']
        ]);

        // Route::resource('bank', BankCrudController::class, [
        //     'only' => ['index', 'store', 'update', 'show']
        // ]);

        Route::get('bank', [BankCrudController::class, 'index'])
            ->middleware("permission:Banks Management,View")
            ->name('bank.index');

        Route::get('bank_search', [BankCrudController::class, 'index'])
            ->name('bank.index');

        Route::post('bank', [BankCrudController::class, 'store'])
            ->middleware("permission:Banks Management,Add")
            ->name('bank.store');

        Route::put('bank/{bank}', [BankCrudController::class, 'update'])
            ->middleware("permission:Banks Management,Edit")
            ->name('bank.update');

        Route::get('bank/{bank}', [BankCrudController::class, 'show'])
            ->name('bank.show');
        Route::resource('admin', AdminCrudController::class)->middleware('role:Super Admin');

        // Route::resource('working_day_holiday', \App\Http\Controllers\Api\Admin\WorkingDayHolidaysController::class);
        Route::get('working_day_holiday', [WorkingDayHolidaysController::class, 'index'])
            ->middleware("permission:Working days,View")
            ->name('working_day_holiday.index');

        Route::post('working_day_holiday', [WorkingDayHolidaysController::class, 'store'])
            ->middleware("permission:Working days,Add event")
            ->name('working_day_holiday.store');

        Route::get('working_day_holiday/{working_day_holiday}', [WorkingDayHolidaysController::class, 'show'])
            ->name('working_day_holiday.show');

        Route::put('working_day_holiday/{working_day_holiday}', [WorkingDayHolidaysController::class, 'update'])
            ->name('working_day_holiday.update');

        Route::delete('working_day_holiday/{working_day_holiday}', [WorkingDayHolidaysController::class, 'destroy'])
            ->name('working_day_holiday.destroy');


        Route::resource('system-bank-data', SystemBankDataController::class, [
            'only' => ['index', 'store', 'show']
        ]);
        Route::resource('system-bank-data', SystemBankDataController::class, [
            'only' => ['update']
        ]);

        // Route::resource('terminal-bank', TerminalBankController::class, [
        //     'only' => ['index', 'show']
        // ]);
        Route::get('terminal-bank', [TerminalBankController::class, 'index'])
            ->middleware("permission:Terminal accounts,View")
            ->name('terminal-bank.index');

        Route::get('terminal-bank/{terminal_bank}', [TerminalBankController::class, 'show'])
            ->name('terminal-bank.show');

        Route::resource('terminal-bank', TerminalBankController::class, [
            'only' => ['update']
        ])->middleware("permission:Terminal accounts,Edit");


        Route::resource('terminal-bank', TerminalBankController::class, [
            'only' => ['store']
        ])->middleware("permission:Terminal accounts,Add");

        Route::get('commission/internal/{terminal_bank_id}', [TerminalBankController::class, 'getInternalCommision'])
            ->middleware("permission:Terminal accounts,Edit Internal Commission");

        Route::get('commission/external/{terminal_bank_id}', [TerminalBankController::class, 'getExternalCommision'])
            ->middleware("permission:Terminal accounts,Edit External Commission");

        Route::post('commission/internal/{terminal_bank_id}', [TerminalBankController::class, 'setInternalCommision'])
            ->middleware("permission:Terminal accounts,Edit Internal Commission");

        Route::post('commission/external/{terminal_bank_id}', [TerminalBankController::class, 'setExternalCommision'])
            ->middleware("permission:Terminal accounts,Edit External Commission");

        // Route::resource('transaction-to-do', TransactionToDoController::class,[
        //     'only' => ['index','update','show']
        // ]);

        // Route::resource('customer', CustomerController::class, [
        //     'only' => ['index']
        // ]);
        Route::get('customer', [CustomerController::class, 'index'])
            ->middleware("permission:Customers,View")
            ->name('customer.index');

        Route::get('customer/excel', [CustomerController::class, 'export'])->middleware("permission:Customers,Export Excel");

        // Route::resource('setting', \App\Http\Controllers\Api\Admin\SettingController::class, [
        //     'only' => ['index', 'show']
        // ]);
        Route::get('setting', [\App\Http\Controllers\Api\Admin\SettingController::class, 'index'])
            ->middleware("permission:Settings,View")
            ->name('setting.index');

        Route::get('setting/{setting}', [\App\Http\Controllers\Api\Admin\SettingController::class, 'show'])
            ->name('setting.show');

        Route::put('setting/{setting}', [\App\Http\Controllers\Api\Admin\SettingController::class, 'update'])
            ->middleware("permission:Settings,Edit")
            ->name('setting.update');
        // Route::resource('setting', \App\Http\Controllers\Api\Admin\SettingController::class, [
        //     'only' => ['update']
        // ]);

        Route::get('transaction-to-do/excel', [TransactionToDoController::class, 'export'])->middleware("permission:Transaction to do,Export excel");
        Route::post('transaction-to-do/excel', [TransactionToDoController::class, 'import'])->middleware("permission:Transaction to do,Import excel");

        Route::post('user/block/{id}', [UserCrudController::class, 'block'])->middleware("permission:Merchants,Block/Unblock");

        Route::get('payment', [\App\Http\Controllers\Api\Admin\PaymentCrudController::class, 'index'])->middleware("permission:Reports,View");
        Route::get('payment/excel', [\App\Http\Controllers\Api\Admin\PaymentCrudController::class, 'export'])->middleware("permission:Reports,Export Excel");
        Route::post('payment/excel', [\App\Http\Controllers\Api\Admin\PaymentCrudController::class, 'import']);
        Route::post('payment/cancel/{id}', [\A\pp\Http\Controllers\Api\Admin\PaymentCrudController::class, 'cancel']);

        Route::get('transaction-to-do/export_albaraka_transactions', [TransactionToDoController::class, 'exportAlbarakaTransactions'])->middleware("permission:Transaction to do,Albaraka external report");


        Route::get('transaction-to-do', [TransactionToDoController::class, 'index'])
            ->middleware("permission:Transaction to do,View")
            ->name('transaction-to-do.index');

        Route::get('transaction-to-do/{transaction_to_do}', [TransactionToDoController::class, 'show'])
            ->name('transaction-to-do.show');

        Route::put('transaction-to-do/{transaction_to_do}', [TransactionToDoController::class, 'update'])
            ->middleware("permission:Transaction to do,Edit")
            ->name('transaction-to-do.update');


        Route::get('new-merchants-count', [UserCrudController::class, 'getNewMerchantsCount']);
        Route::get('statistics', [DashboardController::class, 'getStatistics']);
        Route::get('statistics/line-chart', [DashboardController::class, 'getStatisticsCharts']);
        Route::get('cities', [CityCrudController::class, 'index']);
        Route::get('professions', [ProfessionController::class, 'index']);
        Route::get('business_domains', [BusinessDomainCrudController::class, 'index']);
        Route::get('business_types', [BusinessTypeCrudController::class, 'index']);
        // Route::resource('user', UserCrudController::class, [
        //     'only' => ['index', 'store', 'show']
        // ]);

        Route::get('user', [UserCrudController::class, 'index'])
            ->middleware("permission:Merchants,View")
            ->name('user.index');
        Route::get('user_search', [UserCrudController::class, 'index'])
            ->name('user.index');

        Route::post('user', [UserCrudController::class, 'store'])
            ->middleware("permission:Merchants,Add")
            ->name('user.store');

        Route::get('user/{user}', [UserCrudController::class, 'show'])
            ->name('user.show');
        Route::put('user/{user}', [UserCrudController::class, 'update'])->middleware("permission:Merchants,Edit");
        Route::post('change-password', [AdminCrudController::class, 'changePassword']);


        Route::get('commission', [CommissionCrudController::class, 'index'])
            ->middleware("permission:Commission,View")
            ->name('commission.index');
        Route::get('commission/{id}', [CommissionCrudController::class, 'show'])
            ->name('commission.show');

        Route::post('commission', [CommissionCrudController::class, 'store'])
            ->middleware("permission:Commission,Add")
            ->name('commission.store');

        Route::put('commission/{id}', [CommissionCrudController::class, 'update'])
            ->middleware("permission:Commission,Edit")
            ->name('commission.update');
    });
    Route::post('logout', [AuthController::class, 'logout']);
});



/* User Routes*/
Route::post('/login', [App\Http\Controllers\Api\User\AuthController::class, 'login'])->middleware('throttle:api/login');
Route::post('/verify-code', [\App\Http\Controllers\Api\User\AuthController::class, 'verifyUser'])->middleware('throttle:api/verify-code');
Route::post('/login-password', [App\Http\Controllers\Api\User\AuthController::class, 'loginPassword']);
Route::post('/reset-password-request', [App\Http\Controllers\Api\User\AuthController::class, 'resetPasswordRequest']);
Route::post('/reset-password-verification', [App\Http\Controllers\Api\User\AuthController::class, 'resetPasswordVerification']);
Route::post('/reset-password', [App\Http\Controllers\Api\User\AuthController::class, 'resetPassword']);

//Route::get('payment/excel',[PaymentCrudController::class,'export']);

Route::middleware(['auth:sanctum', 'lang'])->group(function () {

    Route::put('user', [UserController::class, 'updateProfile']);
    Route::post('user/change-password', [UserController::class, 'changePassword']);
    Route::post('user/language', [UserController::class, 'updateLanguage']);
    Route::post('user/fcm-token', [UserController::class, 'updateFcm']);
    Route::delete('user/fcm-token', [UserController::class, 'deleteFcm']);
    Route::get('payment/total-paid', [PaymentCrudController::class, 'getSumPaidAmount']);
    Route::get('payment/excel', [PaymentCrudController::class, 'export']);
    Route::get('payment/pdf/{id}', [PaymentCrudController::class, 'exportPdf']);
    Route::post('payment/excel', [PaymentCrudController::class, 'import']);
    Route::post('payment/resend', [PaymentCrudController::class, 'resendSms']);
    Route::post('payment/bulk_json', [PaymentCrudController::class, 'bulkPaymentJson']);
    Route::post('payment/bulk_check', [PaymentCrudController::class, 'bulkPaymentCheck']);
    Route::post('payment/cancel/{id}', [PaymentCrudController::class, 'cancel']);
    Route::resource('payment', PaymentCrudController::class, [
        'only' => ['index', 'store', 'update', 'show']
    ]);
    Route::get('statistics', [PaymentCrudController::class, 'getStatistics']);
    Route::get('merchant-payments-as-customer', [PaymentCrudController::class, 'getMerchantPaymentsAsCustomer']);
    Route::get('bank', [BankController::class, 'index']);
    Route::get('notification', [NotificationCrudController::class, 'index']);
    Route::get('cities', [CityCrudController::class, 'index']);

    Route::group(['prefix' => 'transfer'], function () {
        Route::post('create-payment', [TransferController::class, 'createPayment']);
        Route::post('execute-payment', [TransferController::class, 'executePayment']);
    });

    Route::post('/logout', [\App\Http\Controllers\Api\User\AuthController::class, 'logout']);
});


Route::middleware(['auth:sanctum', 'lang'])->group(function () {

    // media routes
    Route::post('upload-media-url', [MediaController::class, 'uploadMediaFromUrl']);
    Route::post('upload-media', [MediaController::class, 'uploadMedia']);
    Route::delete('delete-media/{id}', [MediaController::class, 'deleteMedia']);

    // settings routes
    Route::get('settings/get-by-key/{key}', [SettingController::class, 'get_by_key']);
});


// Route::post('ss', function (Request $request) {
//     return ["payment" => \App\Models\Payment::all()];
// });

// Route::get('ss', function (Request $request) {
//     return ["payment" => \App\Models\Payment::all()];
// });
