<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsernameController;
use Illuminate\Support\Facades\Auth;
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
    return view('index');
});

//username
Route::prefix('username')->group(function(){
    Route::get('forgot', [UsernameController::class, 'index'])->name('forgot.username');
    Route::post('request-change', [UsernameController::class, 'requestChange'])->name('request.username.change');
});

Auth::routes();

//Dashboard
Route::prefix('/')->middleware('auth')->group(function (){
    Route::get('home', [HomeController::class, 'index'])->name('home');

    // Profile
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('update-profile', [ProfileController::class, 'update'])->name('profile.update');

    // Board Tree
    Route::get('board-tree/{board_id}', [BoardController::class, 'index'])->name('board.index');

    // Gifts
    Route::get('update-gift-status/{id}/{status}', [GiftController::class, 'update'])->name('update-gift-status');
});
