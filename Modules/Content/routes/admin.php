<?php
use Illuminate\Support\Facades\Route;
use Modules\Content\App\Http\Controllers\Admin\ArticleController;
use Modules\Content\App\Http\Controllers\Admin\ArticleListController;
use Modules\Content\App\Http\Controllers\Admin\CategoryController;
use Modules\Content\App\Http\Controllers\Admin\PageController;
use Modules\Content\App\Http\Controllers\Admin\SliderController;


Route::get('category' , [CategoryController::class,'index'])->name('category.index');
//article


Route::resource('article', ArticleController::class)->scoped([
    'article' => 'id'
])->except('show');


Route::prefix('article/{article:id}')->group(function () {

    //banner

    //desc
    Route::get('descript', [ArticleController::class, 'showDesc'])->name( 'article.desc.show');
    Route::post('descript', [ArticleController::class, 'setDesc'])->name( 'article.desc.store');

});


//ArticleList


Route::resource('articleList', ArticleListController::class)->scoped([
    'articleList' => 'id'
])->except('show');

Route::prefix('articleList/{articleList:id}')->group(function () {
    Route::post('deleteImg', [ArticleListController::class, 'deleteImg'])->name('articleList.deleteImg');
});



//slider

Route::resource('slider', SliderController::class)->scoped([
    'slider' => 'id'
])->except('show');

Route::post('slider/sort', [SliderController::class, 'setsort'])->name('slider.setsort');




Route::post('articleList/search', [ArticleListController::class, 'search'])->name('articleListSearch');

//page

Route::resource('page', PageController::class)->scoped([
    'page' => 'id'
])->except('show');
