<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\TimesActivityController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/{}
Route::get('/login', [LoginController::class,"index"]);
Route::post('/login', [LoginController::class,"authenticated"])->name('login');
//Route::resource('/', ActivityController::class)->middleware('auth.custom');
Route::middleware(['auth.custom'])->group(function () {
   Route::get('/', [ActivityController::class,"index"])->name('index');
   Route::post('/', [ActivityController::class,"store"])->name('store');
   Route::get('/{id}', [ActivityController::class,"show"])->name('show');
   Route::put('/{id}', [ActivityController::class,"update"])->name('update');
   Route::delete('/{id}', [ActivityController::class,"destroy"])->name('destroy');
});

Route::middleware(['auth.custom'])->group(function () {
   Route::get('/times', [TimesActivityController::class,"index"])->name('times.index');
   Route::post('/times', [TimesActivityController::class,"store"])->name('times.store');
   Route::get('/times/activity/{id}',[TimesActivityController::class,"timesActivity"])->name('times.activity');
   Route::delete('/times/{id}', [TimesActivityController::class,"destroy"])->name('destroy');
   Route::post('/logout', [LoginController::class,"logout"])->name('logout');
});


