<?php

use App\Http\Controllers;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
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

Route::middleware('auth')->group(function () {
    Route::get(RouteServiceProvider::HOME, function (Request $request) {
        return $request->isJson() ? response(404) : view('dashboard');
    })->name('home');

    Route::controller(Controllers\UserController::class)->prefix('users')->group(function () {
        Route::get('', 'index')->name('users.home');
        Route::get('create', 'create')->name('users.create');
        Route::get('{user}', 'edit')->name('users.edit');
    });
});
