<?php

use App\Http\Middleware\AddMenberTarget;
use Illuminate\Routing\Router;

\Front::registerHelpersRoutes();

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
    $router->resource('/system/customer_type','Base\\XingZhiController');


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
    $router->resource('/target/{target_id}/targetd', 'Target\\TargetDController');

    $router->resource('/target/{target_id}/targetd/{targetd_id}/targetm', 'Target\\TargetMController',['except' => 'create','destroy']);

    //customer
    $router->resource('/customer', 'Customer\\CustomerController');
    Route::group([
        'middleware'    => AddMenberTarget::class,
    ], function (Router $router) {
        //finance/finance
        $router->resource('/finance/input', 'Finance\\InputController');
        $router->get('/selectp/', 'Finance\\InputController@selectp');

        //yeji
        $router->resource('/performance/checkout', 'Yeji\\CheckoutController',['except' => 'create','destroy']);

        $router->resource('/performance/checkout/{u_id}/details', 'Yeji\\CheckDetailsController',['except' => 'create','destroy']);
    });





    $router->resource('/permissions', 'PermissionController');













    $router->resource('/api/input/u', 'Api\\UController');


});
