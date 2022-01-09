<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

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

Route::get('/login', [AuthController::class, 'login'])
    ->name('login');
Route::get('/redirect-to-twitch-auth', [AuthController::class, 'redirectToTwitchAuth'])
    ->name('twitch.redirect');
Route::get('/login-with-twitch', [AuthController::class, 'loginWithTwitch']);

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])
        ->name('home');

    Route::get('/streams-by-game', [HomeController::class, 'streamsByGame'])
        ->name('streams-by-game');

    Route::get('/viewers-median', [HomeController::class, 'medianViewersCount'])
        ->name('viewers-median');

    Route::get('/top-viewed-streams', [HomeController::class, 'topStreamsByViewerCount'])
        ->name('top-viewed-streams');

    Route::get('/streams-by-start-time', [HomeController::class, 'getStreamsByStartTime'])
        ->name('streams-by-start-time');
});
