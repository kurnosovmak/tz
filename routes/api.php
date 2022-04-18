<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;

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

// Auth only
Route::middleware('auth:sanctum')->group(function () {

    Route::post('logout', [Api\AuthController::class, 'logout'])->name('logout');

    Route::apiResource('equipment', Api\EquipmentController::class);

    Route::get('equipment-type', [Api\EquipmentTypeController::class, 'index'])->name('equipment-type');
});


// All
Route::post('login', [Api\AuthController::class, 'login'])->name('login');
Route::post('register', [Api\AuthController::class, 'register'])->name('register');
