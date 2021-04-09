<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get('profile', [UserController::class, 'profile'])->name('profile');

Route::view('forgot_password', 'auth.reset_password')->name('password.reset');

Route::view('privacy-policy', 'privacy');
Route::view('terms', 'terms');


Route::get('mylogs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
