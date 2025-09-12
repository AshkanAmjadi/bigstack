<?php

namespace App\Providers;

use App\facade\BaseCat\BaseCat;
use App\facade\Module\ModuleFacade;
use Modules\Content\App\Models\Category;
use App\Models\Option;
use Modules\User\App\Models\User;
use App\Models\WebAllert;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //todo view composer
        //todo set Directve for show easy items




    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
//        Blade::component('admin-dashboard' , dashboard::class);

        Blade::if('module', function ($name) {
            return ModuleFacade::available($name);
        });



        $this->app->singleton('custom_options', function () {
            return Cache::rememberForever('options',function (){
                return Option::all();
            }); //todo not all options
        });
        $this->app->singleton('web_allerts', function () {
            return Cache::rememberForever('web_allerts',function (){
                $all = WebAllert::all();
                $allWbal = $all->map(function ($allert){
                    $allert->content = view('component.description.description',['desc'=>editorJsDecode($allert,'content')])->render();

                    return $allert;
                });


                return collect(['all' => $all ,'forview' => $allWbal->pluck('content','hash_id')]);
            }); //todo not all options
        });







//        dd(app('web_allerts')->get('forview')->toArray());

//        View::composer('front.*',function ($view){
//            $view->with('allCat',BaseCat::getAll());
//        });
//        View::composer('admin.*',function ($view){
//            $view->with('allCat',BaseCat::getAll());
//            //todo delete when project complete
//        });

        // If you use this line of code then it'll be available in any view
        // as $site_settings but you may also use app('site_settings') as well
//        View::share('options', app('options'));
    }
}
