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
    //$router->resource('/system/zhifu','Base\\ZhifuController');
    $router->resource('/system/customer_type','Base\\XingZhiController');
    $router->resource('/system/hangye','Base\\HangyeController');


    //baoshe
    $router->resource('/system/baoshe', 'Baoshe\\BaosheController');

    //periodical
    $router->resource('/periodical', 'Periodical\\PeriodicalController');

    //department
    $router->resource('/department', 'Department\\DepartmentController');

    //menber
    $router->resource('/menber', 'Menber\\MenberController');
    $router->post('/editper', 'Menber\\MenberController@editper');

    //target
    $router->resource('/target', 'Target\\TargetController');
    $router->resource('/target/{target_id}/targetd', 'Target\\TargetDController');

    $router->resource('/target/{target_id}/targetd/{targetd_id}/targetm', 'Target\\TargetMController',['except' => 'create','destroy']);

    //customer
    $router->resource('/customer', 'Customer\\CustomerController');
    $router->get('/api/region/city', 'Api\\ReController@city');
    $router->get('/api/region/district', 'Api\\ReController@district');

    Route::group([
        'middleware'    => AddMenberTarget::class,
    ], function (Router $router) {
        //input
        $router->resource('/finance/input', 'Finance\\InputController');

        //fapiao
        $router->get('/finance/fapiao', 'Finance\\FapiaoController@index');
        $router->get('/finance/fapiao/getdetail/{input_id}', 'Finance\\FapiaoController@getDetail');
        $router->post('/finance/fapiao/setdetail/{input_id}', 'Finance\\FapiaoController@setDetail');

        //pay
        $router->get('/finance/pay', 'Finance\\PayController@index');
        $router->get('/finance/pay/getdetail/{input_id}', 'Finance\\PayController@getDetail');
        $router->post('/finance/pay/setdetail/{input_id}', 'Finance\\PayController@setDetail');

        //yeji
        $router->get('/checkout', 'Yeji\\CheckoutController@index');
        $router->get('/checkout/p/{t_id}', 'Yeji\\CheckoutController@checkoutIndex');
        $router->get('/checkout/p/{t_id}/getdetail/{u_id}', 'Yeji\\CheckoutController@getDetail');
        $router->post('/checkout/p/{t_id}/setdetail/{u_id}', 'Yeji\\CheckoutController@setDetail');

        $router->get('/selectp/', 'Finance\\InputController@selectp');

    });

    $router->resource('/permissions', 'PermissionController');

    //Chart
    $router->get('/user_chart', 'Chart\\UserChartController@index');


    $router->resource('/api/input/u', 'Api\\UController');


});
