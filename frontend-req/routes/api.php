<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::post('logout',[AuthController::class,'logout'])->middleware('auth:api');
Route::get('home',[AuthController::class,'home'])->middleware("auth:api");

// data profile

Route::get('index',[ProfileController::class,'index'])->middleware('auth:api');


Route::post('create',[ProfileController::class,'create'])->middleware('auth:api');
Route::get('show/{id}',[ProfileController::class,'show'])->middleware('auth:api');

// Route::post('update/{id}',[ProfileController::class,'update'])->middleware('auth:api');
Route::post('UP/{id}',[ProfileController::class,'update'])->middleware('auth:api');
Route::post('delete/{id}',[ProfileController::class,'delete'])->middleware('auth:api');
