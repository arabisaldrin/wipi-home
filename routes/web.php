<?php

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

Route::get('/vouchers/print', 'VoucherController@print');
Route::get('/login', 'SpaController@index')->name('login')->middleware('guest');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/portal/auto-connect', 'PortalController@checkAutoConnectDevice');
Route::get('/portal/device-access', 'PortalController@checkDeviceAccess');

Route::middleware('auth')->group(function () {
    Route::get('/{any}', 'SpaController@index')->where('any', '.*');
});
