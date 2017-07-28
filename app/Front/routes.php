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

    //base
    $router->get('/system/jconfig','Base\\JConfigController@index')->name('jconfig');
    $router->post('/system/jconfig','Base\\JConfigController@storeAndUpdate')->name('store_and_update_jconfig');


    //baoshe
    $router->resource('/system/baoshe', 'Baoshe\\BaosheController');

    //periodical
    $router->resource('/periodical', 'Periodical\\PeriodicalController');

    //department
    $router->resource('/department', 'DepartmentController');

    $router->resource('/permissions', 'PermissionController');

    $router->resource('/menber', 'MenberController');
    $router->resource('/customer', 'CustomerController');

    $router->resource('/target', 'TargetController');
    $router->resource('/d_target', 'DTargetController');
    $router->resource('/finance/input', 'InputController');
    $router->resource('/performance/checkout', 'CheckoutController',['except' => 'create','destroy']);


    $router->resource('/performance/checkout/{u_id}/details', 'CheckDetailsController',['except' => 'create','destroy']);




    $router->resource('/performance/all_dis_per', 'AlldisperController',['except' => 'create','destroy']);
    $router->resource('/performance/d_dis_per', 'DdisperController',['except' => 'create','destroy']);

    $router->resource('/api/input/u', 'Api\\UController');


});
