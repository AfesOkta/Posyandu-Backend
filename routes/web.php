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
Route::group(['middleware' => 'auth'], function(){
    Route::get('/', [\App\Http\Controllers\HomeController::class, 'doLogin'])->name('doLogin');
    // Route::view('/', 'welcome')->name('welcome');
});

Route::middleware('auth', 'verified')->group(function () {
	Route::view('dashboard', 'dashboard')->name('dashboard');
	Route::view('profile', 'profile')->name('profile');
    Route::view('testing', 'testing')->name('testing');

});

Route::group([

    'prefix' => 'posyandu',

    'middleware' => 'auth'

    ], function () {

    Route::get('/', [App\Http\Controllers\MstPosyanduController::class, 'index'])->name('posyandu');
    Route::get('/json', [App\Http\Controllers\MstPosyanduController::class, 'json_list'])->name('posyandu.json');
});

Route::group([

    'prefix' => 'kader',

    'middleware' => 'auth'

    ], function () {

    Route::get('/', [App\Http\Controllers\KaderPosyanduController::class, 'index'])->name('kader');

});

Route::group([

    'prefix' => 'anggota',

    'middleware' => 'auth'

    ], function () {

    Route::get('/', [App\Http\Controllers\LansiaPosyanduController::class, 'index'])->name('anggota');

});
