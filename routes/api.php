<?php

use App\Http\Controllers\Api\ArtController;
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

Route::get('/art', [ArtController::class, 'index']);


Route::get('/art/{id}', [ArtController::class, 'show']);

Route::post('/art', [ArtController::class, 'store']);
