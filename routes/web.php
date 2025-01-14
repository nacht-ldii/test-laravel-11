<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExampleController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\AjaxUploadController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/books', [BookController::class, 'index']);
    Route::post('/books', [BookController::class, 'store']);
    Route::get('/books/fetch', [BookController::class, 'fetchBooks']);
    Route::put('/books/{id}', [BookController::class, 'update']);
    Route::delete('/books/{id}', [BookController::class, 'destroy']);

    Route::get('/categories', [CategoriesController::class, 'index']);
    Route::post('/categories', [CategoriesController::class, 'store']);
    Route::get('/categories/fetch', [CategoriesController::class, 'fetchCategories']);
    Route::put('/categories/{id}', [CategoriesController::class, 'update']);
    Route::delete('/categories/{id}', [CategoriesController::class, 'destroy']);
    
    Route::get('/table-example', [App\Http\Controllers\ExampleController::class, 'table'])->name('table.example');
});