<?php


use App\Http\Controllers\Admin\AdminAllertController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AnswerController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ConversationController;
use App\Http\Controllers\Admin\InstaArticleController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\PossibleController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\WebAllertController;
use Illuminate\Support\Facades\Route;



//dashboard

Route::get('dashboard', [AdminController::class,'dashboard'])->name('dashboard');
Route::get('option', [OptionController::class,'index'])->name('option.index');
Route::post('option/social', [OptionController::class,'updateSocial'])->name('option.updateSocial');
Route::post('option/view', [OptionController::class,'updateView'])->name('option.updateView');
Route::post('option/info', [OptionController::class,'updateInfo'])->name('option.updateInfo');

Route::get('/flushCache',function (){

    \Illuminate\Support\Facades\Cache::flush();
    toast('کش پاکسازی شد✔️', 'info')->autoClose(5000)->position('bottom-end')->timerProgressBar();

    return back();

})->name('flushCache');
Route::get('/down',function (){
    \Illuminate\Support\Facades\Artisan::call('down');
    return back();
})->name('down');
Route::get('/migrate',function (){
    \Illuminate\Support\Facades\Artisan::call('migrate', ["--force" => true ]);
    return back();
})->name('migrate');
Route::get('/migrate_r',function (){
    \Illuminate\Support\Facades\Artisan::call('migrate:rollback', ["--force" => true ]);
    return back();
})->name('migrate_r');

//options

//Route::get('option' , [OptionController::class,'index'])->name('option.index');
//Route::put('option' , [OptionController::class,'update'])->name('option.update');


//list

Route::resource('list', \App\Http\Controllers\Admin\ListController::class)->scoped([
    'list' => 'id'
])->except('show','create');

Route::prefix('list/{lists:id}')->group(function () {

    //sort
    Route::post('sort', [\App\Http\Controllers\Admin\ListController::class, 'setsort'])->name('list.setsort');
    Route::post('deleteImg', [\App\Http\Controllers\Admin\ListController::class, 'deleteImg'])->name('list.deleteImg');


});


//comments


Route::resource('comment', CommentController::class)->scoped([
    'comment' => 'id'
])->except('show','create','store');

Route::prefix('comment/{comment:id}')->group(function () {
    Route::post('preview', [CommentController::class, 'preview']);
});
//answers


Route::resource('answer', AnswerController::class)->scoped([
    'answer' => 'id'
])->except('show','create','store');

Route::prefix('answer/{answer:id}')->group(function () {
    Route::post('preview', [AnswerController::class, 'preview']);
});


//web_allert


Route::resource('adminAllert', AdminAllertController::class)->scoped([
    'adminAllert' => 'id'
])->except('show','store','update','edit','create');

Route::resource('webAllert', WebAllertController::class)->scoped([
    'webAllert' => 'id'
])->except('show');
Route::post('webAllert/{webAllert:id}/delete', [AdminController::class,'deleteWebAllert'])->name('delete.webAllert');
Route::post('adminAllert/{adminAllert:id}/delete', [AdminController::class,'deleteAdminAllert'])->name('delete.adminAllert');


//instaArticle


Route::resource('instaArticle', InstaArticleController::class)->scoped([
    'instaArticle' => 'id'
])->except('show');



//tag


Route::resource('tag', TagController::class)->scoped([
    'tag' => 'id'
])->except('show');

Route::prefix('tag/{tag:id}')->group(function () {
    Route::post('deleteImg', [\App\Http\Controllers\Admin\TagController::class, 'deleteImg'])->name('tag.deleteImg');
});




Route::resource('conversation', ConversationController::class)->scoped([
    'conversation' => 'id'
])->except('show');

//conversation



//service

Route::resource('service', ServiceController::class)->scoped([
    'service' => 'id'
])->except('show');

//possible

Route::resource('possible', PossibleController::class)->scoped([
    'possible' => 'id'
])->except('show');

Route::post('possible/sort', [PossibleController::class, 'setsort'])->name('possible.setsort');

//project


Route::resource('project', ProjectController::class)->scoped([
    'project' => 'id'
])->except('show');


Route::prefix('project/{project:id}')->group(function () {


    //plan
    Route::resource('plan', PlanController::class)->scoped([
        'plan' => 'id'
    ])->except('show');
    //possible
    Route::get('descript', [ProjectController::class, 'showDesc'])->name( 'project.desc.show');
    Route::post('descript', [ProjectController::class, 'setDesc'])->name( 'project.desc.store');
    //desc
    Route::get('possible', [ProjectController::class, 'showPossible'])->name( 'project.possible.show');
    Route::post('possible', [ProjectController::class, 'setPossible'])->name( 'project.possible.store');







});




Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);






