<?php
use Illuminate\Http\Request;

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

Route::post('/login', 'Auth\LoginController@login')->name('login');

Route::post('/portal/voucher', 'PortalController@receiveVoucher');
Route::get('/portal/auto-connect', 'PortalController@checkAutoConnectDevice');
Route::get('/portal/device-access', 'PortalController@checkDeviceAccess');

Route::middleware('auth')->group(function () {
    Route::get('/me', function (Request $request) {
        return $request->user();
    });

    Route::apiResources([
        '/users' => 'UserController',
        '/vouchers' => 'VoucherController',
        '/plans' => 'PlanController',
    ]);

    Route::get('/voucher-groups', 'VoucherController@groups');
    Route::post('/voucher-groups/archive', 'VoucherController@archive');

    Route::put('/users/{user}/toggle-status', 'UserController@toggleStatus');

});

Route::get('/{any}', function () {
    return response('Page not found!', 404);
})->where('any', '.*');
