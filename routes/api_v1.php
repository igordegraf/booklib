<?php

use App\Http\Controllers\Api\V1\AuthorController;
use App\Http\Controllers\Api\V1\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('book')->group(function() {
    Route::get("/", [BookController::class, 'paginate'])->name('get_all_books_paginate');
    Route::get("/raw", [BookController::class, 'all'])->name('get_all_books');
    Route::get("/{book_id}", [BookController::class, 'get'])->name('get_one_book')->where(['book_id' => '[0-9]+']);
    Route::post("/", [BookController::class, 'create'])->name('create_book');
//    Route::put("/{book_id}", [\App\Http\Controllers\Api\V1\BookController::class, 'update'])->name('update_book')->where(['book_id' => '[0-9]+']);
    Route::delete("/{book_id}", [BookController::class, 'delete'])->name('delete_one_book')->where(['book_id' => '[0-9]+']);
    Route::post("/{book_id}/author", [BookController::class, 'addAuthor'])->name('add_author')->where(['book_id' => '[0-9]+']);
    Route::get("/{book_id}/authors", [BookController::class, 'authors'])->name('get_book_authors')->where(['book_id' => '[0-9]+']);
    Route::delete("/{book_id}/author/{author_id}", [BookController::class, 'deleteAuthor'])->name('delete_author')->where(['book_id' => '[0-9]+', 'author_id' => '[0-9]+']);

    Route::get("/by_author/{author_id}", [BookController::class, 'getByAuthor'])->name('find_books_by_author')->where(['author_id' => '[0-9]+']);
});

Route::prefix('author')->group(function() {
    Route::get("/", [AuthorController::class, 'paginate'])->name('get_all_authors_paginate');
    Route::get("/raw", [AuthorController::class, 'all'])->name('get_all_authors');
    Route::get("/{author_id}", [AuthorController::class, 'get'])->name('get_one_author');
    Route::post("/", [AuthorController::class, 'create'])->name('create_author');
    Route::delete("/{author_id}", [AuthorController::class, 'delete'])->name('delete_one_author');
    //Route::put("/{author_id}", [AuthorController::class, 'update'])->name('update_author');
    Route::get("/{author_id}/books", [AuthorController::class, 'books'])->name('authors_books');
});

Route::fallback(function () { return response('Bad Request', 400);});
