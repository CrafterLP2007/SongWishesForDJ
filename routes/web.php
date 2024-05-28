<?php

use App\Livewire\Home;
use App\Services\Spotify\SpotifyService;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'language'], function () {
    Route::get('/', Home::class)->name("home");

    Route::get("/callback", [SpotifyService::class, 'handleSpotifyCallback'])->name('callback');
});
