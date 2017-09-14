<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/14
 * Time: 15:19
 */

namespace App\Providers;


use App\Menber\Facades\Menber;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class MenberServiceProvider extends ServiceProvider
{
    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'menber.auth'        => \App\Menber\Middleware\Authenticate::class,
        'menber.pjax'        => \App\Menber\Middleware\PjaxMiddleware::class,
        'menber.bootstrap'   => \App\Menber\Middleware\BootstrapMiddleware::class,
    ];


    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'menber' => [
            'menber.auth',
            'menber.pjax',
            'menber.bootstrap',
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
        $this->publishes([__DIR__.'/../../config/menber.php' => config_path('menber.php')], 'laravel-menber');
        $this->publishes([__DIR__.'/../../assets' => public_path('packages/front')], 'laravel-front');

        Menber::registerAuthRoutes();

        if (file_exists($routes = menber_path('routes.php'))) {
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

            $loader->alias('Menber', \App\Menber\Facades\Menber::class);

            if (is_null(config('auth.guards.menber'))) {
                $this->setupAuth();
            }
        });

        $this->registerRouteMiddleware();

    }

    /**
     * Setup auth configuration.
     *
     * @return void
     */
    protected function setupAuth()
    {
        config([
            'auth.guards.menber.driver'    => 'session',
            'auth.guards.menber.provider'  => 'menber',
            'auth.providers.menber.driver' => 'eloquent',
            'auth.providers.menber.model'  => 'App\Models\Menber',
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