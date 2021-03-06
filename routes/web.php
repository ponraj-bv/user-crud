<?php

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

Route::get('/', [\App\Http\Controllers\UserController::class, 'index'])->name('home');
Route::post('/', [\App\Http\Controllers\UserController::class, 'store'])->name('users.create');
Route::delete('delete/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.delete');
