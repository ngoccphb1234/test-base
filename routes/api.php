<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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

Route::prefix('products')->group(function () {
    Route::get('', [ProductController::class, 'index']);
    Route::post('', [ProductController::class, 'create']);
    Route::get('{id}', [ProductController::class, 'show']);
    Route::put('update/{id}', [ProductController::class, 'update']);
    Route::delete('delete/{id}', [ProductController::class, 'delete']);
});

Route::prefix('roles')->group(function () {
    Route::get('', [RoleController::class, 'index']);
    Route::post('', [RoleController::class, 'create']);
    Route::get('{id}', [RoleController::class, 'show']);
    Route::put('update/{id}', [RoleController::class, 'update']);
    Route::delete('delete/{id}', [RoleController::class, 'delete']);
});

Route::prefix('users')->group(function () {
    Route::get('', [UserController::class, 'index']);
    Route::post('', [UserController::class, 'create']);
    Route::get('{id}', [UserController::class, 'show']);
    Route::put('update/{id}', [UserController::class, 'update']);
    Route::delete('delete/{id}', [UserController::class, 'delete']);
});
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});
