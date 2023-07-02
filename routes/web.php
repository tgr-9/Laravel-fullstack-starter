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

Route::middleware('auth')->group(function () {
    Route::get(RouteServiceProvider::HOME, function (Request $request) {
        if ($request->expectsJson()) {
            return response(404);
        }

        return Inertia::render('dashboard');
    })->name('home');

    Route::controller(Controllers\Account\ProfileController::class)->group(function () {
        Route::get('account', 'index')->name('account.home');
        Route::post('account', 'store');
    });

    Route::controller(Controllers\Account\SettingController::class)->group(function () {
        Route::get('account/settings', 'index')->name('account.settings');
        Route::post('account/settings', 'store');
    });

    Route::get('supports', Controllers\SupportController::class)->name('supports.home');

    Route::resource('users', Controllers\UserController::class)
        ->only('index', 'create', 'edit')
        ->names(['index' => 'users.home']);
});
