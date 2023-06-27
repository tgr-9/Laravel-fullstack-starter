<?php

use App\Http\Controllers;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get(RouteServiceProvider::HOME, function (Request $request) {
    if ($request->isJson()) {
        return response(404);
    }

    return Inertia::render('dashboard');
})->name('home');
Route::middleware('auth')->group(function () {

    Route::controller(Controllers\UserController::class)->prefix('users')->group(function () {
        Route::get('', 'index')->name('users.home');
        Route::get('create', 'create')->name('users.create');
        Route::get('{user}', 'edit')->name('users.edit');
    });
});
