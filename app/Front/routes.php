<?php

use App\Http\Middleware\AddMenberTarget;
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
    $router->resource('/system/zhifu','Base\\ZhifuController');


    //baoshe
    $router->resource('/system/baoshe', 'Baoshe\\BaosheController');

    //periodical
    $router->resource('/periodical', 'Periodical\\PeriodicalController');

    //department
    $router->resource('/department', 'Department\\DepartmentController');

    //menber
    $router->resource('/menber', 'Menber\\MenberController');

    //target
    $router->resource('/target', 'Target\\TargetController');

    //customer
    $router->resource('/customer', 'Customer\\CustomerController');
    Route::group([
        'middleware'    => AddMenberTarget::class,
    ], function (Router $router) {
        //finance/finance
        $router->resource('/finance/input', 'Finance\\InputController');

        //yeji
        $router->resource('/performance/checkout', 'Yeji\\CheckoutController',['except' => 'create','destroy']);

        $router->resource('/performance/checkout/{u_id}/details', 'Yeji\\CheckDetailsController',['except' => 'create','destroy']);
    });





    $router->resource('/permissions', 'PermissionController');













    $router->resource('/api/input/u', 'Api\\UController');


});
