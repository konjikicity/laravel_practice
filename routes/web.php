<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/messages', [MessageController::class, 'index'])->name('messages');
Route::post('/messages', [MessageController::class, 'store'])->name('message.store');

Route::prefix('admin/books')
    ->name('book.')
    ->controller(BookController::class)
    ->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('{book}', 'show')->whereNumber('book')->name('show');
        Route::get('create', 'create')->whereNumber('id')->name('create');
        Route::post('', 'store')->name('store');
    });
