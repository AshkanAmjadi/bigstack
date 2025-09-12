<?php

namespace App\Providers;

use App\facade\BaseAllert\BaseAllertService;
use App\facade\BaseCat\BaseCatService;
use App\facade\BaseImage\BaseImageService;
use App\facade\BaseMethod\BaseMethodService;
use App\facade\BaseQuery\BaseQueryService;
use App\facade\BaseRequest\BaseRequestService;
use App\facade\BaseSort\BaseSortService;
use App\facade\BaseValidation\BaseValidationService;
use App\facade\Description\DescriptionService;
use App\facade\Module\ModuleService;
use App\facade\Notification\NotificationService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {



        $this->app->bind('path.public', function () {
            return base_path(env('PUBLIC_PATH'));
        });

//        dd(env('PUBLIC_PATH'));
//
//        $this->app->bind('path.public', function () {
//            return base_path('/../public_html');
//        });
//

        $this->app->singleton('BaseMethodService',function (){
            return new BaseMethodService();
        });
        $this->app->singleton('BaseSortService',function (){
            return new BaseSortService();
        });
        $this->app->singleton('BaseCatService',function (){
            return new BaseCatService();
        });
        $this->app->singleton('BaseImageService',function (){
            return new BaseImageService();
        });
        $this->app->singleton('BaseValidationService',function (){
            return new BaseValidationService();
        });
        $this->app->singleton('BaseRequestService',function (){
            return new BaseRequestService();
        });

        $this->app->singleton('BaseQueryService',function (){
            return new BaseQueryService();
        });
        $this->app->singleton('BaseAllertService',function (){
            return new BaseAllertService();
        });

        $this->app->singleton('DescriptionService',function (){
            return new DescriptionService();
        });
        $this->app->singleton('NotificationService',function (){
            return new NotificationService();
        });
        $this->app->singleton('ModuleService',function (){
            return new ModuleService();
        });


    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {


        Relation::morphMap([
            'conver' => 'App\Models\Conversation',
            'art' => 'Modules\Content\App\Models\Article',
            'comm' => 'App\Models\Comment',
            'cat' => 'Modules\Content\App\Models\Category',
            'artL' => 'Modules\Content\App\Models\ArticleList',
            'user' => 'Modules\User\App\Models\User',
            'list' => 'App\Models\Lists',
            'page' => 'Modules\Content\App\Models\Page',
            'instArt' => 'App\Models\InstaArticle',
            'WbAlrt' => 'App\Models\WebAllert',
            'UsAlrt' => 'Modules\User\App\Models\UserAllert',
            'AdmAlrt' => 'App\Models\AdminAllert',
            'ans' => 'App\Models\Answer',
            'like' => 'App\Models\Like',
            'mark' => 'App\Models\Bookmark',
            'tact' => 'App\Models\Tact',
            'tag' => 'App\Models\Tag',
            'srvc' => 'App\Models\Service',
            'prj' => 'App\Models\Project',
            'plan' => 'App\Models\Plan',
            'psble' => 'App\Models\Possible',
            'track' => 'App\Models\LoginTracking',
        ]);
    }
}
