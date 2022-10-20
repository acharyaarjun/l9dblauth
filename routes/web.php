<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::view('login', 'admin.login')->name('login');
        Route::post('login', [AdminController::class, 'login'])->name('auth');
    });
    Route::group(['middleware' => 'admin.auth'], function () {
        Route::view('dashboard', 'admin.home')->name('home');
        Route::post('logout', [AdminController::class, 'logout'])->name('logout');
    });
});
