<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\AuthServiceProvider::class,
    // App\Providers\BroadcastServiceProvider::class,
    App\Providers\EventServiceProvider::class,
    App\Providers\RouteServiceProvider::class,
    App\Providers\BladeServiceProvider::class,
    App\Providers\HelperServiceProvider::class,
    App\Providers\ConfigServiceProvider::class,
    Hekmatinasser\Verta\Laravel\VertaServiceProvider::class,
    Rap2hpoutre\LaravelLogViewer\LaravelLogViewerServiceProvider::class,
    Bepsvpt\SecureHeaders\SecureHeadersServiceProvider::class,
    Artesaos\SEOTools\Providers\SEOToolsServiceProvider::class,
    App\Providers\LoginSecurityServiceProvider::class,
];
