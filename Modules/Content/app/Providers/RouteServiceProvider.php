<?php

namespace Modules\Content\app\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected string $name = 'Content';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes(): void
    {
//        Route::middleware('web')->group(module_path($this->name, '/routes/web.php'));

        $this->adminRoutes();
        $this->homeRoutes();
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapApiRoutes(): void
    {
//        Route::middleware('api')->prefix('api')->name('api.')->group(module_path($this->name, '/routes/api.php'));
    }


    public function adminRoutes()
    {
        Route::prefix('admin')
            ->middleware(['web','auth','admin'])
            ->namespace($this->namespace)
            ->name('admin.')
            ->group(module_path($this->name, '/routes/admin.php'));
    }
    public function homeRoutes()
    {
        Route::middleware(['web'])
            ->namespace($this->namespace)
            ->group(module_path($this->name, '/routes/home.php'));
    }
}
