<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use Illuminate\Support\Facades\Auth;
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


Auth::routes();

Route::get('/', [BookController::class, 'index'])->name('home');

Route::resource('/books',BookController::class);

Route::controller(GenreController::class)->group(function(){
    Route::get('genre', 'index')->name('genre.index');
    Route::post('genre', 'store')->name('genre.store');
    Route::get('genre/create', 'create')->name('genre.create');
    Route::get('genre/{product}', 'show')->name('genre.show');
    Route::put('genre/{product}', 'update')->name('genre.update');
    Route::delete('genre/{product}', 'destroy')->name('genre.destroy');
    Route::get('genre/{product}/edit', 'edit')->name('genre.edit');
});

// Route::controller(BookController::class)->group(function(){
//     Route::get('books', 'index')->name('books.index');
//     Route::post('books', 'store')->name('books.store');
//     Route::get('books/create', 'create')->name('books.create');
//     Route::get('books/{product}', 'show')->name('books.show');
//     Route::put('books/{product}', 'update')->name('books.update');
//     Route::delete('books/{product}', 'destroy')->name('books.destroy');
//     Route::get('books/{product}/edit', 'edit')->name('books.edit');
// });