<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//to add new user.just remove this /signup route if you want to register new user by authenticated User.you may add User like in seeder etc
Route::post('users/signup', [\App\Http\Controllers\UserController::class,'store']);
//login route
Route::post('login', [\App\Http\Controllers\AuthController::class,'login']);
Route::middleware('auth:api')->group(function () { 
    //routes accessible for authenticated User
    Route::apiResource('users', \App\Http\Controllers\UserController::class);
});

