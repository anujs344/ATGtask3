<?php

use App\Http\Controllers\RandLController;
use App\Http\Controllers\TaskController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/todo/add',[TaskController::class,'addTask']);

Route::post('/todo/status',[TaskController::class,'updateTask']);

Route::get('/todo/showtable',[TaskController::class,'showtable']);

Route::get('/todo/showregister',[TaskController::class,'showregister']);