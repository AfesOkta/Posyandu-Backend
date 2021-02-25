<?php

use Illuminate\Http\Request;
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

// user controller routes
Route::post("register", [\App\Http\Controllers\UserController::class, "register"]);

Route::post("login", [\App\Http\Controllers\UserController::class, "login"]);

Route::post("logout", [\App\Http\Controllers\UserController::class, "login"]);

Route::post("logoutAll", [\App\Http\Controllers\UserController::class, "login"]);

Route::get("posyandu", [\App\Http\Controllers\JsonController::class, "posyandu"]);

Route::post("absensi", [\App\Http\Controllers\AbsensiController::class, "absensi"]);

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware('auth:api')->group(function() {

//     Route::get("user", [\App\Http\Controllers\UserController::class, "user"]);

//     //Route::resource('tasks', TaskController::class);
//     Route::group(['prefix' => 'absensi'], function () {
//         Route::post("/masuk",[\App\Http\Controllers\AbsensiController::class, "absensi_masuk"]);
//         Route::post("/pulang",[\App\Http\Controllers\AbsensiController::class, "absensi_pulang"]);
//     });
// });


Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function() {

    Route::get("user", [\App\Http\Controllers\UserController::class, "user"]);

    // Route::get("anggota", [\App\Http\Controllers\AnggotaController::class, "anggota_json"]);

    // Route::get("anggota", [\App\Http\Controllers\KaderController::class, "kader_json"]);

    // manggil controller sesuai bawaan laravel 8
    Route::post('logout', [\App\Http\Controllers\UserController::class, 'logout']);
    // manggil controller dengan mengubah namespace di RouteServiceProvider.php biar bisa kayak versi2 sebelumnya
    Route::post('logoutall', [\App\Http\Controllers\UserController::class, 'logoutall']);

    Route::group(['prefix' => 'absensi'], function () {
        Route::post("/masuk",[\App\Http\Controllers\AbsensiController::class, "absensi_masuk"]);
        Route::post("/pulang",[\App\Http\Controllers\AbsensiController::class, "absensi_pulang"]);
    });
});
