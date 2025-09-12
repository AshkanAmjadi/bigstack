<?php

namespace Modules\User\app\Providers;


use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Modules\User\App\Livewire\Profile\Allerts;
use Modules\User\App\Livewire\Profile\Avatar;
use Modules\User\App\Livewire\Profile\Comments;
use Modules\User\App\Livewire\Profile\Conversations;
use Modules\User\App\Livewire\Profile\DeleteAns;
use Modules\User\App\Livewire\Profile\DeleteCon;
use Modules\User\App\Livewire\Profile\Logins;
use Modules\User\App\Livewire\Profile\Phone;
use Modules\User\App\Livewire\Profile\Profile;
use Modules\User\App\Livewire\Profile\SendInfo;
use Modules\User\App\Livewire\Profile\Tacts;
use Modules\User\App\Livewire\Profile\Username;
use Nwidart\Modules\Traits\PathNamespace;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class UserServiceProvider extends ServiceProvider
{
    use PathNamespace;

    protected string $name = 'User';

    protected string $nameLower = 'user';

    /**
     * Boot the application events.
     */
    public function boot(): void
    {

        //boot livewire component
        $this->registerCommands();
        $this->registerCommandSchedules();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->name, 'database/migrations'));
        //boot livewire component
        $this->livewire();
        //admin-menu merg to main admin-menu
        $this->adminMenu();

    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {


        config([
            'modelmap.ActiveCode' => $this->name,
            'modelmap.Permission' => $this->name,
            'modelmap.Phone' => $this->name,
            'modelmap.User' => $this->name,
            'modelmap.Rule' => $this->name,
            'modelmap.UserAllert' => $this->name,
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
    public function livewire(): void
    {
//        //profile.info
        Livewire::component('user::profile.allerts', Allerts::class);
        Livewire::component('user::profile.avatar', Avatar::class);
        Livewire::component('user::profile.comments', Comments::class);
        Livewire::component('user::profile.conversations', Conversations::class);
        Livewire::component('user::profile.delete-ans', DeleteAns::class);
        Livewire::component('user::profile.logins', Logins::class);
        Livewire::component('user::profile.phone', Phone::class);
        Livewire::component('user::profile.delete-con', DeleteCon::class);
        Livewire::component('user::profile.profile', Profile::class);
        Livewire::component('user::profile.send-info', SendInfo::class);
        Livewire::component('user::profile.tacts', Tacts::class);
        Livewire::component('user::profile.username', Username::class);

    }
    /**
     * merge to admin menu.
     */
    public function adminMenu(): void
    {
        if (config('user.admin-menu')) {
            $userMenu = config('user.admin-menu');
            // اطلاعات موجود admin-menu رو بگیر
            $adminMenu = $this->app['config']['admin-menu'];

            // فقط بخش جدید رو اضافه کن، بدون تغییر اطلاعات قبلی
            $adminMenu['middle'] = array_merge($adminMenu['middle'], [
                'user' => $userMenu
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
