<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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
Route::prefix('admin')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->middleware('auth')->name('users');
    Route::get('/user/create', [UserController::class, 'create'])->middleware('auth')->name('create-user');
    Route::post('/user/save', [UserController::class, 'save'])->middleware('auth')->name('save-user');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->middleware('auth');
    Route::post('/user/update', [UserController::class, 'update'])->middleware('auth')->name('update-user');
    Route::get('/user/delete/{id}', [UserController::class, 'delete'])->middleware('auth')->name('user-delete');
});



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');
