<?php

use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ManufactureController;
use App\Http\Controllers\XmlController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ParsingController;
use App\Http\Controllers\SearchController;
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


Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/parser', [ParsingController::class, 'create']);
Route::get('/manufactures', [ManufactureController::class, 'index'])->name('manufactures');
Route::get('/manufacture/create', [ManufactureController::class, 'create'])->name('create-manufacture');
Route::post('/manufacture/save', [ManufactureController::class, 'save'])->name('save-manufacture');

/* upload files */
Route::get('upload/upload-file', [FileUploadController::class, 'createForm']);
Route::post('upload/upload-file', [FileUploadController::class, 'fileUpload'])->name('fileUpload');

Route::get('upload/xml', [XmlController::class, 'create']);
Auth::routes();
