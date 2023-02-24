<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;
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

Route::get('/', [BooksController::class,'index'])->name('books.index');

Route::group(['prefix' => 'books'], function () {
    Route::get('index',[BooksController::class,'index'])->name('books.index');
    Route::get('create',[BooksController::class,'create'])->name('books.create');
    Route::get('edit/{id}',[BooksController::class,'edit'])->name('books.edit');
});
