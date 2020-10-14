<?php

use App\Http\Controllers\Api\ArtController;
use App\Http\Controllers\Api\UserController;
use App\Http\Resources\UserResource;
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
    return new UserResource($request->user());
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


// user routes
Route::get('/user/{id}/followers', [UserController::class, 'getFollowers'])->middleware('auth:sanctum');
Route::get('/user/{id}/followings', [UserController::class, 'getFollowings'])->middleware('auth:sanctum');



Route::post('/user/follow', [UserController::class, 'follow'])->middleware('auth:sanctum');
Route::post('/user/unfollow', [UserController::class, 'unfollow'])->middleware('auth:sanctum');



// art routes

Route::get('/art/{art}/like', [ArtController::class, 'like'])->middleware('auth:sanctum');
Route::get('/art/{art}/unlike', [ArtController::class, 'unlike'])->middleware('auth:sanctum');


// favourite routes

Route::get('/art/{art}/favourite', [ArtController::class, 'favourite'])->middleware('auth:sanctum');

Route::get('/art/{art}/unfavourite', [ArtController::class, 'unfavourite'])->middleware('auth:sanctum');

Route::post('/art/comment', [ArtController::class, 'comment'])->middleware('auth:sanctum');

Route::get('/art/{art}/comments', [ArtController::class, 'comments'])->middleware('auth:sanctum');

Route::get(
    '/art/favourite/user',
    [ArtController::class, 'favouriteItems']
)->middleware('auth:sanctum');
