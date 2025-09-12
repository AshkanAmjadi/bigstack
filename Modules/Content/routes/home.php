<?php

use Illuminate\Support\Facades\Route;
use Modules\Content\App\Http\Controllers\Front\ArticleController;
use Modules\Content\App\Http\Controllers\Front\CategoryArticleController;

Route::get('article/{article:slug}',[ArticleController::class , 'article'])->name('article.show');
Route::get('page/{page}',[ArticleController::class , 'page'])->name('page.show');
Route::get('blog/category/{category}',[CategoryArticleController::class , 'category'])->name('category.show');
Route::get('article_list/{articleList}',[CategoryArticleController::class , 'articleList'])->name('articleList.show');

