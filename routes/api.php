<?php

use App\Http\Controllers\Api\ArtController;
use App\Http\Controllers\Api\UserController;
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

// Auth Routes
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
Route::get('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/art', [ArtController::class, 'index'])->middleware('auth:sanctum');

// art of logged in user

Route::get('/user/art', [UserController::class, 'art'])->middleware('auth:sanctum');


Route::get('/art/{id}', [ArtController::class, 'show'])->middleware('auth:sanctum');

Route::post('/art', [ArtController::class, 'store'])->middleware('auth:sanctum');
