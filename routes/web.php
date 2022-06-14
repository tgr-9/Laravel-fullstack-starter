<?php

use App\Http\Controllers;
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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::controller(Controllers\UserController::class)->prefix('/users')->group(function () {
        Route::get('', 'index')->name('users.home');
        Route::get('/create', 'create')->name('users.create');
        Route::get('/{user}', 'edit')->name('users.edit');
    });
});

require __DIR__.'/auth.php';
