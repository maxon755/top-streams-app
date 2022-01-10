<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StreamController;
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
    Route::get('/', [StreamController::class, 'index'])
        ->name('home');

    Route::get('/streams-count-by-game', [StreamController::class, 'streamsCountByGame'])
        ->name('streams-count-by-game');

    Route::get('/most-viewed-streams-by-game', [StreamController::class, 'mostViewedStreamsByGame'])
        ->name('most-viewed-streams-by-game');

    Route::get('/viewers-median', [StreamController::class, 'medianViewersCount'])
        ->name('viewers-median');

    Route::get('/top-viewed-streams', [StreamController::class, 'topStreamsByViewerCount'])
        ->name('top-viewed-streams');

    Route::get('/streams-by-start-time', [StreamController::class, 'streamsByStartTime'])
        ->name('streams-by-start-time');

    Route::get('/followed-streams', [StreamController::class, 'followedStreamsFromTop'])
        ->name('followed-streams');
});
