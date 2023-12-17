<?php

use Illuminate\Support\Facades\Route;

// load controllers
use App\Http\Controllers\Auth\{AuthController};
use App\Http\Controllers\{HomeController};
use App\Http\Controllers\Car\{CarController};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// login and register
Route::group(["prefix" =>"auth"], function(){
    Route::get("/", [AuthController::class, "index"]);
    Route::get("reg", [AuthController::class, "register"]);
});

// dashboard
Route::group(['prefix' => 'home'], function(){
    Route::get("/", [HomeController::class,"index"]);
});

// car
Route::group(['prefix' => 'car'], function(){
    Route::get("manage", [CarController::class, 'CarManage']);
    Route::get("rent", [CarController::class, 'CarRent']);
    Route::get("withdraw", [CarController::class, 'CarWithdraw']);
});
