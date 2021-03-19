<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Response;
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
Route::post('logged_in', [\App\Http\Controllers\LoginController::class, 'authenticate'])->name('logged_in');

Route::group(['middleware' => 'auth'], function(){
    Route::get('/', [\App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');
    // Route::view('/', 'welcome')->name('welcome');
});

Route::middleware('auth', 'verified')->group(function () {
	// Route::view('dashboard', 'dashboard')->name('dashboard');
	Route::view('profile', 'profile')->name('profile');
    Route::view('testing', 'testing')->name('testing');

});

Route::group([

    'prefix' => 'posyandu',

    'middleware' => 'auth'

    ], function () {

    Route::get('/', [App\Http\Controllers\MstPosyanduController::class, 'index'])->name('posyandu');
    Route::get('/json', [App\Http\Controllers\MstPosyanduController::class, 'json_list'])->name('posyandu.json');

    Route::post('/store', [App\Http\Controllers\MstPosyanduController::class, 'store'])->name('posyandu.store');
    Route::post('/update', [App\Http\Controllers\MstPosyanduController::class, 'update'])->name('posyandu.update');
    Route::post('/delete', [App\Http\Controllers\MstPosyanduController::class, 'destroy'])->name('posyandu.delete');

    Route::get('/get/{id}', [App\Http\Controllers\MstPosyanduController::class, 'getPosyandu'])->name('posyandu.get');

    Route::get('/download', [App\Http\Controllers\MstPosyanduController::class, 'download'])->name('posyandu.download');
    Route::post('/import', [App\Http\Controllers\MstPosyanduController::class, 'import'])->name('posyandu.import');
});

Route::group([

    'prefix' => 'kader',

    'middleware' => 'auth'

    ], function () {

    Route::get('/', [App\Http\Controllers\KaderPosyanduController::class, 'index'])->name('kader');
    Route::get('/json', [App\Http\Controllers\KaderPosyanduController::class, 'json_list'])->name('kader.json');
    Route::post('/store', [App\Http\Controllers\KaderPosyanduController::class, 'store'])->name('kader.store');
    Route::post('/update', [App\Http\Controllers\KaderPosyanduController::class, 'update'])->name('kader.update');
    Route::post('/delete', [App\Http\Controllers\KaderPosyanduController::class, 'destroy'])->name('kader.delete');

    Route::get('/get/{id}', [App\Http\Controllers\KaderPosyanduController::class, 'show'])->name('kader.get');

    Route::get('/generate/qr-code/{id}',[App\Http\Controllers\KaderPosyanduController::class, 'qr_code'])->name('kader.generate.qrcode');
    Route::get('download/qr-code/{filename}', [App\Http\Controllers\KaderPosyanduController::class, 'download_qrcode'])->name('kader.download.qrcode');

    Route::get('/download', [App\Http\Controllers\KaderPosyanduController::class, 'download'])->name('kader.download');
    Route::post('/import', [App\Http\Controllers\KaderPosyanduController::class, 'import'])->name('kader.import');
});

Route::group([

    'prefix' => 'anggota',

    'middleware' => 'auth'

    ], function () {

    Route::get('/', [App\Http\Controllers\LansiaPosyanduController::class, 'index'])->name('anggota');
    Route::get('/json', [App\Http\Controllers\LansiaPosyanduController::class, 'json_list'])->name('anggota.json');
    Route::post('/store', [App\Http\Controllers\LansiaPosyanduController::class, 'store'])->name('anggota.store');
    Route::post('/update', [App\Http\Controllers\LansiaPosyanduController::class, 'update'])->name('anggota.update');
    Route::post('/delete', [App\Http\Controllers\LansiaPosyanduController::class, 'destroy'])->name('anggota.delete');

    Route::get('/get/{id}', [App\Http\Controllers\LansiaPosyanduController::class, 'show'])->name('anggota.get');

    Route::get('/generate/qr-code/{id}',[App\Http\Controllers\LansiaPosyanduController::class, 'qr_code'])->name('anggota.generate.qrcode');
    Route::get('download/qr-code/{filename}', [App\Http\Controllers\LansiaPosyanduController::class, 'download_qrcode'])->name('anggota.download.qrcode');

    Route::get('/download', [App\Http\Controllers\LansiaPosyanduController::class, 'download'])->name('anggota.download');
    Route::post('/import', [App\Http\Controllers\LansiaPosyanduController::class, 'import'])->name('anggota.import');
});

Route::group([

    'prefix' => 'absensi',

    'middleware' => 'auth'

    ], function () {

    Route::get('/', [App\Http\Controllers\AbsensiController::class, 'index'])->name('absensi');
    Route::get('/json', [App\Http\Controllers\JsonController::class, 'json_absensi'])->name('absensi.json');

    Route::get('/get/{id}', [App\Http\Controllers\AbsensiController::class, 'show'])->name('absensi.get');
    Route::get('/cetak/{url}', [App\Http\Controllers\AbsensiController::class, 'cetak'])->name('absensi.cetak');
});

Route::group([

    'prefix' => 'users',

    'middleware' => 'auth'

    ], function () {

    Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('users');
    Route::get('/json', [App\Http\Controllers\JsonController::class, 'json_users'])->name('users.json');

    // Route::get('/get/{id}', [App\Http\Controllers\AbsensiController::class, 'show'])->name('absensi.get');
});

Route::group([

    'prefix' => 'ajax',

    'middleware' => 'auth'

    ], function () {

    Route::get('/json-posyandu', [App\Http\Controllers\MstPosyanduController::class, 'json_select'])->name('list.posyandu.select');
});

// Clear application cache:
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return 'Application cache cleared';
});

Route::get('/config-clear', function() {
    $exitCode = Artisan::call('config:clear');
    return 'Application config cleared';
});

// Clear view cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return 'View cache cleared';
});

Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return  'Configuration clear successfully!';
});
