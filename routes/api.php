<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\CustomerController;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

//customerrr
Route::post('/order', [CustomerController::class, 'order']);
Route::get('/food', [CustomerController::class, 'getfood']);

//adminn
Route::get('/order', [CustomerController::class, 'semuaorder']);
Route::get('/order/{id}', [CustomerController::class, 'satuorder']);

//food
Route::get('/food', [CustomerController::class, 'getfood']);
Route::get('/foodid/{id}', [FoodController::class, 'getfoodid']);
Route::post('/addfood', [FoodController::class, 'addfood']);
Route::patch('/updatefood/{id}', [FoodController::class, 'updatefood']);
Route::delete('/deletefood/{id}', [FoodController::class, 'deletefood']);
