<?php

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

Route::get('/home', [HomeController::class, 'index'])->name('home');

//Dashboard
Route::prefix('')->middleware('auth')->group(function (){
    // Profile
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('update-profile', [ProfileController::class, 'update'])->name('profile.update');
});
