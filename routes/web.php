<?php

use App\Http\Controllers\BigCommerce\BigCommerceController;
use App\Http\Controllers\BigCommerce\IntegrationsController;
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

Route::get('/error', function () {
    return view('bigCommerce.error');
});

Route::get('/testUrl/{code?}', function ($code) {
    return 'test url code = ' . $code;
});

Route::group(['namespace' => 'BigCommerce', 'prefix' => 'bigcommerce', 'as' => 'bigCommerce.'], function () {
    /* BigCommerce App Init */
    Route::get('/auth', [BigCommerceController::class, 'auth'])->name('auth');
    Route::get('/load', [BigCommerceController::class, 'load'])->name('load');
    Route::get('/uninstall', [BigCommerceController::class, 'uninstall'])->name('uninstall');

    Route::group(['prefix' => 'integrations', 'as' => 'integrations.'], function () {
        Route::match(['get', 'post'], '/index', [IntegrationsController::class, 'index'])->name('index');
    });

});

