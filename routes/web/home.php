<?php





use App\Http\Controllers\Front\ConversationController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProjectController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Log;
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
 Route::get('test',function (){

     $cookieName = \Illuminate\Support\Facades\Auth::getRecallerName(); // معمولاً خروجی: remember_web_{hash}
     $rememberToken = request()->cookie($cookieName);
     $user = \Modules\User\App\Models\User::query()->first();
     Log::info('بازیابی موفق کاربر از Remember Me', [$user->morph_class,$user]);


     return view('test');

 });
 Route::get('auth/1',function (){


     if (!auth()->user()){
         auth()->loginUsingId(1,true);
     }

     return redirect(\route('home'));

 });
//sitemap

Route::get('sitemap.xml',[SitemapController::class,'sitemap']);
Route::get('sitemap-static.xml',[SitemapController::class,'static']);
Route::get('sitemap-article.xml',[SitemapController::class,'articles']);
Route::get('sitemap-category.xml',[SitemapController::class,'category']);
Route::get('sitemap-tag.xml',[SitemapController::class,'tag']);
Route::get('sitemap-article-list.xml',[SitemapController::class,'articleList']);
Route::get('sitemap-project.xml',[SitemapController::class,'project']);
Route::get('sitemap-page.xml',[SitemapController::class,'page']);
Route::get('sitemap-discussion.xml',[SitemapController::class,'discussion']);
//google Auth
//Route::get('/test',[HomeController::class,'test'])->name('test');


//saveComment
//todo 15,10 throttle
Route::middleware('throttle:20,10')->post('saveComment', [HomeController::class, 'seveComment']);
Route::middleware('throttle:20,10')->post('saveAnswer', [ConversationController::class, 'seveAnswer']);
Route::middleware('throttle:20,10')->post('saveConversation', [ConversationController::class, 'saveConversation']);
Route::middleware('throttle:100,10')->post('getAnswerContent/{answer:id}', [ConversationController::class, 'getAnswerContent']);
Route::middleware('throttle:100,10')->post('getConInfo/{conversation:id}', [ConversationController::class, 'getConInfo']);
Route::middleware('throttle:100,10')->get('searchUser', [ConversationController::class, 'searchUser']);

//General
Route::get('/',[HomeController::class,'index'])->name('home');

Route::get('project/{project:slug}',[ProjectController::class , 'project'])->name('project.show');
Route::get('projects',[ProjectController::class , 'projects'])->name('project.search');
//Route::get('blog',[ArticleController::class , 'search'])->name('article.search');//todo برای سرچ کلی مقالات
Route::get('discussion/{conversation:slug}',[ConversationController::class , 'conversation'])->name('conversation.show');
Route::get('craft/discussion',[ConversationController::class , 'craft'])->name('conversation.cratf');
Route::get('edit/discussion/{conversation:slug}',[ConversationController::class , 'craft'])->name('conversation.cratf.edit');
Route::get('discussions',[ConversationController::class , 'conversations'])->name('discuss.search');
Route::get('tag/{tag}',[HomeController::class , 'tag'])->name('tag.show');
