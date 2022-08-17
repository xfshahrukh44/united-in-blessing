<?php

use App\Http\Controllers\UsernameController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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
    return view('auth.register');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

//username
Route::prefix('username')->group(function(){
    Route::get('forgot', [UsernameController::class, 'index'])->name('forgot.username');
    Route::post('request-change', [UsernameController::class, 'requestChange'])->name('request.username.change');
});
