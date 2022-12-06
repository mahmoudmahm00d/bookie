<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UsersController;
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
Route::resource('/books', BookController::class);
Route::resource('/genres', GenreController::class);
Route::resource('/users', UsersController::class);

Route::get('notifications/mine', [NotificationController::class, 'mine'])->name('notification.mine');
Route::resource('/notifications', NotificationController::class);

// Route::controller(GenreController::class)->group(function(){
//     Route::get('genre', 'index')->name('genre.index');
//     Route::post('genre', 'store')->name('genre.store');
//     Route::get('genre/create', 'create')->name('genre.create');
//     Route::get('genre/{product}', 'show')->name('genre.show');
//     Route::put('genre/{product}', 'update')->name('genre.update');
//     Route::delete('genre/{product}', 'destroy')->name('genre.destroy');
//     Route::get('genre/{product}/edit', 'edit')->name('genre.edit');
// });

Route::controller(BorrowController::class)->group(function () {
    Route::get('borrows', 'index')->name('borrows.index');
    Route::get('borrows/create', 'create')->name('borrows.create');
    Route::post('borrows', 'store')->name('borrows.store');
    Route::get('borrows/{id}/edit', 'edit')->name('borrows.edit');
    Route::put('borrows/{id}', 'update')->name('borrows.update');
    Route::get('borrows/mine', 'mine')->name('borrows.mine');
    Route::get('borrows/{id}/books', 'books')->name('borrows.books');
});
