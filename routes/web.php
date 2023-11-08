<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleApiController;
use Illuminate\Support\Facades\Auth;

Route::get('/', [ArticleController::class, 'index']);
Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/detail/{id}', [ArticleController::class,'detail']);
Route::get('/articles/add', [ArticleController::class, 'add']);
Route::post('articles/add', [ArticleController::class, 'create']);
Route::get('articles/delete/{id}', [ArticleController::class, 'delete']);
Route::get('/articles/edit/{id}', [ArticleController::class, 'edit']);
Route::put('/articles/update/{id}', [ArticleController::class, 'updateitem'])->name('article.update');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
