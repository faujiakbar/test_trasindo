<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\{AuthController};
use App\Http\Controllers\Car\{
        CarController,
        RentController
    };

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'auth'], function(){
    Route::post('in',[AuthController::class, 'AuthIn']);
    Route::post('reg',[AuthController::class, 'AuthRegister']);

    Route::group(['middleware' => 'auth'], function(){
        Route::post('out',[AuthController::class, 'AuthOut']);
    });
});

Route::group(['prefix' => 'car'], function(){
    Route::get('ready', [CarController::class, 'GetCarReady']);

    Route::post('manage', [CarController::class, 'AddCar']);
    Route::post('manage/edit', [CarController::class, 'EditCar']);
    Route::post('manage/get', [CarController::class, 'GetById']);
    Route::get('manage/all', [CarController::class, 'GetAllCar']);
    Route::post('manage/del', [CarController::class, 'DelCar']);

    Route::group(['prefix' => 'rent'], function(){
        Route::post("/", [RentController::class, 'AddRent']);
        Route::get('all', [RentController::class, 'GetAllRent']);
    });
});
