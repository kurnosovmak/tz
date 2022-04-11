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

//only auth
//Route::middleware('auth')->group(function (){
Route::group([],function (){
    Route::apiResource('equipment',Api\EquipmentController::class);

    Route::get('equipment-type',[Api\EquipmentTypeController::class,'index'])->name('equipment-type');

});

