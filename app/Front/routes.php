<?php

use App\Zhenggg\Facades\Front;
use Illuminate\Routing\Router;

Front::registerHelpersRoutes();

Route::group([
    'prefix'        => config('front.prefix'),
    'namespace'     => Front::controllerNamespace(),
    'middleware'    => ['web', 'front'],
], function (Router $router) {
    $router->get('/', 'HomeController@index');
    $router->resource('/permissions', 'PermissionController');
    $router->resource('/department', 'DepartController');
    $router->resource('/menber', 'MenberController');
    $router->resource('/customer', 'CustomerController');
    $router->resource('/periodical', 'PeriodicalController');
    $router->resource('/target', 'TargetController');
    $router->resource('/d_target', 'DTargetController');
    $router->resource('/finance/input', 'InputController');
    $router->resource('/performance/checkout', 'CheckoutController');
    $router->resource('/performance/all_dis_per', 'AlldisperController');

    $router->resource('/api/input/u', 'Api\\UController');
});
