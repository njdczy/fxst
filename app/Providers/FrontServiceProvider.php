<?php

namespace App\Providers;

use App\Zhenggg\Facades\Front;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class FrontServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $commands = [
        'App\Zhenggg\Commands\MakeCommand',
        'App\Zhenggg\Commands\MenuCommand',
        'App\Zhenggg\Commands\InstallCommand',
        'App\Zhenggg\Commands\UninstallCommand',
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'front.auth'        => \App\Http\Middleware\Authenticate::class,
        'front.pjax'        => \App\Http\Middleware\PjaxMiddleware::class,
        'front.log'         => \App\Http\Middleware\OperationLog::class,
        'front.permission'  => \App\Http\Middleware\PermissionMiddleware::class,
        'front.bootstrap'   => \App\Http\Middleware\BootstrapMiddleware::class,
        'front.isSetJituanConfig'   => \App\Http\Middleware\IsSetJituanConfigMiddleware::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'front' => [
            'front.auth',
            'front.pjax',
            'front.log',
            'front.bootstrap',
            'front.isSetJituanConfig',
        ],
    ];

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../../views', 'front');
        $this->loadTranslationsFrom(__DIR__.'/../../lang/', 'front');
        $this->publishes([__DIR__.'/../../config/front.php' => config_path('front.php')], 'laravel-front');
        $this->publishes([__DIR__.'/../../assets' => public_path('packages/front')], 'laravel-front');

        Front::registerAuthRoutes();

        if (file_exists($routes = front_path('routes.php'))) {
            require $routes;
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();

            $loader->alias('Front', \App\Zhenggg\Facades\Front::class);

            if (is_null(config('auth.guards.front'))) {
                $this->setupAuth();
            }
        });

        $this->registerRouteMiddleware();

        $this->commands($this->commands);
    }

    /**
     * Setup auth configuration.
     *
     * @return void
     */
    protected function setupAuth()
    {
        config([
            'auth.guards.front.driver'    => 'session',
            'auth.guards.front.provider'  => 'front',
            'auth.providers.front.driver' => 'eloquent',
            'auth.providers.front.model'  => 'App\Zhenggg\Auth\Database\Administrator',
        ]);
    }

    /**
     * Register the route middleware.
     *
     * @return void
     */
    protected function registerRouteMiddleware()
    {
        // register route middleware.
        foreach ($this->routeMiddleware as $key => $middleware) {
            app('router')->aliasMiddleware($key, $middleware);
        }

        // register middleware group.
        foreach ($this->middlewareGroups as $key => $middleware) {
            app('router')->middlewareGroup($key, $middleware);
        }
    }
}
