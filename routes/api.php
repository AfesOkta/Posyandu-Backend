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

Route::get("posyandu", [\App\Http\Controllers\JsonController::class, "posyandu"]);

Route::post("absensi", [\App\Http\Controllers\AbsensiController::class, "absensi"]);

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:api')->group(function() {

    Route::get("user", [\App\Http\Controllers\UserController::class, "user"]);

    //Route::resource('tasks', TaskController::class);
    Route::group(['prefix' => 'absensi'], function () {
        Route::post("/anggota-masuk",[\App\Http\Controllers\AbsensiController::class, "absensi_anggota_masuk"]);
        Route::post("/anggota-pulang",[\App\Http\Controllers\AbsensiController::class, "absensi_anggota_pulang"]);
        Route::post("/kader-masuk",[\App\Http\Controllers\AbsensiController::class, "absensi_kader_masuk"]);
        Route::post("/kader-pulang",[\App\Http\Controllers\AbsensiController::class, "absensi_kader_masuk"]);
    });
});
