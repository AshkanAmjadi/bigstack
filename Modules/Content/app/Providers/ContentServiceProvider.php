<?php

namespace Modules\Content\app\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Modules\Content\App\Livewire\Category\CategoryPage;
use Modules\Content\App\Livewire\Category\Item;
use Nwidart\Modules\Traits\PathNamespace;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class ContentServiceProvider extends ServiceProvider
{
    use PathNamespace;

    protected string $name = 'Content';

    protected string $nameLower = 'content';

    /**
     * Boot the application events.
     */
    public function boot(): void
    {



        //boot livewire component
        $this->livewire();
        $this->registerCommands();
        $this->registerCommandSchedules();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        //load migration for database
        $this->loadMigrationsFrom(module_path($this->name, 'database/migrations'));
        //admin-menu merg to main admin-menu
        $this->adminMenu();
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        config([
            'modelmap.Article' => 'Content',
            'modelmap.Category' => 'Content',
            'modelmap.Tag' => 'Content',
            'modelmap.Page' => 'Content',
            'modelmap.Slider' => 'Content',
        ]);

        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register commands in the format of Command::class
     */
    protected function registerCommands(): void
    {
        // $this->commands([]);
    }

    /**
     * Register command Schedules.
     */
    protected function registerCommandSchedules(): void
    {
        // $this->app->booted(function () {
        //     $schedule = $this->app->make(Schedule::class);
        //     $schedule->command('inspire')->hourly();
        // });
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/'.$this->nameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->nameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->name, 'lang'), $this->nameLower);
            $this->loadJsonTranslationsFrom(module_path($this->name, 'lang'));
        }
    }

    /**
     * Register config.
     */
    protected function registerConfig(): void
    {
        $configPath = module_path($this->name, config('modules.paths.generator.config.path'));

        if (is_dir($configPath)) {
            $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($configPath));

            foreach ($iterator as $file) {
                if ($file->isFile() && $file->getExtension() === 'php') {
                    $config = str_replace($configPath.DIRECTORY_SEPARATOR, '', $file->getPathname());
                    $config_key = str_replace([DIRECTORY_SEPARATOR, '.php'], ['.', ''], $config);
                    $segments = explode('.', $this->nameLower.'.'.$config_key);

                    // Remove duplicated adjacent segments
                    $normalized = [];
                    foreach ($segments as $segment) {
                        if (end($normalized) !== $segment) {
                            $normalized[] = $segment;
                        }
                    }

                    $key = ($config === 'config.php') ? $this->nameLower : implode('.', $normalized);

                    $this->publishes([$file->getPathname() => config_path($config)], 'config');
                    $this->merge_config_from($file->getPathname(), $key);
                }
            }
        }
    }

    /**
     * Merge config from the given path recursively.
     */
    protected function merge_config_from(string $path, string $key): void
    {
        $existing = config($key, []);
        $module_config = require $path;

        config([$key => array_replace_recursive($existing, $module_config)]);
    }

    /**
     * Register views.
     */
    public function registerViews(): void
    {
        $viewPath = resource_path('views/modules/'.$this->nameLower);
        $sourcePath = module_path($this->name, 'resources/views');

        $this->publishes([$sourcePath => $viewPath], ['views', $this->nameLower.'-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->nameLower);

        Blade::componentNamespace(config('modules.namespace').'\\' . $this->name . '\\View\\Components', $this->nameLower);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }
    /**
     * make live wire components.
     */
    public function livewire(): void
    {
        //admin.category
        Livewire::component('content::admin.category.category-item', \Modules\Content\App\Livewire\Admin\Category\CategoryItem::class);
        Livewire::component('content::admin.category.cat-list', \Modules\Content\App\Livewire\Admin\Category\CatList::class);
        Livewire::component('content::admin.category.create', \Modules\Content\App\Livewire\Admin\Category\Create::class);
        //category
        Livewire::component('content::category.category-page', CategoryPage::class);
        Livewire::component('content::category.item', Item::class);
        Livewire::component('content::category.items', \Modules\Content\App\Livewire\Category\Items::class);
        //article-list
        Livewire::component('content::article-list.items', \Modules\Content\App\Livewire\ArticleList\Items::class);
    }
    /**
     * merge to admin menu.
     */
    public function adminMenu(): void
    {
        if (config('content.admin-menu')) {
            $contentMenu = config('content.admin-menu');
            // اطلاعات موجود admin-menu رو بگیر
            $adminMenu = $this->app['config']['admin-menu'];

            // فقط بخش جدید رو اضافه کن، بدون تغییر اطلاعات قبلی
            $adminMenu['middle'] = array_merge($adminMenu['middle'], [
                'content' => $contentMenu
            ]);

            $this->app['config']['admin-menu'] = $adminMenu;
        }
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (config('view.paths') as $path) {
            if (is_dir($path.'/modules/'.$this->nameLower)) {
                $paths[] = $path.'/modules/'.$this->nameLower;
            }
        }

        return $paths;
    }
}
