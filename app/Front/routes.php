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


/*base*/
    //信息设置
    Route::group([
        'middleware'    => 'front.permission:check,base_jconfig',
    ], function (Router $router) {
        $router->get('/base/jconfig','Base\\JConfigController@index')->name('jconfig');
        $router->post('/base/jconfig','Base\\JConfigController@storeAndUpdate')->name('store_and_update_jconfig');
    });
    //$router->resource('/system/zhifu','Base\\ZhifuController');

    //客户性质设置
    Route::group([
        'middleware'    => 'front.permission:check,base_customer_type',
    ], function (Router $router) {
        $router->get('/base/customer_type','Base\\XingZhiController@index');
        $router->get('/base/customer_type/create','Base\\XingZhiController@create');
        $router->post('/base/customer_type','Base\\XingZhiController@store');
        $router->get('/base/customer_type/{id}','Base\\XingZhiController@show');
        $router->get('/base/customer_type/{id}/edit','Base\\XingZhiController@edit');
        $router->put('/base/customer_type/{id}','Base\\XingZhiController@update');
        $router->delete('/base/customer_type/{id}','Base\\XingZhiController@destroy');
    });
    //行业设置
    Route::group([
        'middleware'    => 'front.permission:check,base_hangye',
    ], function (Router $router) {
        $router->get('/base/hangye','Base\\HangyeController@index');
        $router->get('/base/hangye/create','Base\\HangyeController@create');
        $router->post('/base/hangye','Base\\HangyeController@store');
        $router->get('/base/hangye/{id}','Base\\HangyeController@show');
        $router->get('/base/hangye/{id}/edit','Base\\HangyeController@edit');
        $router->put('/base/hangye/{id}','Base\\HangyeController@update');
        $router->delete('/base/hangye/{id}','Base\\HangyeController@destroy');
    });
    //报社管理
    Route::group([
        'middleware'    => 'front.permission:check,base_baoshe',
    ], function (Router $router) {
        $router->get('/base/baoshe','Base\\BaosheController@index');
        $router->get('/base/baoshe/create','Base\\BaosheController@create');
        $router->post('/base/baoshe','Base\\BaosheController@store');
        $router->get('/base/baoshe/{id}','Base\\BaosheController@show');
        $router->get('/base/baoshe/{id}/edit','Base\\BaosheController@edit');
        $router->put('/base/baoshe/{id}','Base\\BaosheController@update');
        $router->delete('/base/baoshe/{id}','Base\\BaosheController@destroy');
    });
    //刊物管理
    Route::group([
        'middleware'    => 'front.permission:check,base_periodical',
    ], function (Router $router) {
        $router->get('/base/periodical','Base\\PeriodicalController@index');
        $router->get('/base/periodical/create','Base\\PeriodicalController@create');
        $router->post('/base/periodical','Base\\PeriodicalController@store');
        $router->get('/base/periodical/{id}','Base\\PeriodicalController@show');
        $router->get('/base/periodical/{id}/edit','Base\\PeriodicalController@edit');
        $router->put('/base/periodical/{id}','Base\\PeriodicalController@update');
        $router->delete('/base/periodical/{id}','Base\\PeriodicalController@destroy');
    });
/*department*/
    //部门管理
    Route::group([
    ], function (Router $router) {
        $router->get('/department','Department\\DepartmentController@index')->middleware('front.permission:check,department_list');
        $router->get('/department/create','Department\\DepartmentController@create')->middleware('front.permission:check,department_edit');;//编辑
        $router->post('/department','Department\\DepartmentController@store')->middleware('front.permission:check,department_edit');;//编辑
        $router->get('/department/{id}','Department\\DepartmentController@show')->middleware('front.permission:check,department_list');;//列表
        $router->get('/department/{id}/edit','Department\\DepartmentController@edit')->middleware('front.permission:check,department_edit');;//编辑
        $router->put('/department/{id}','Department\\DepartmentController@update')->middleware('front.permission:check,department_edit');;//编辑
        $router->delete('/department/{id}','Department\\DepartmentController@destroy')->middleware('front.permission:check,department_edit');;//编辑
    });
/*menber*/
    //人员管理
    Route::group([
    ], function (Router $router) {
        $router->get('/menber','Menber\\MenberController@index')->middleware('front.permission:check,menber_list');//列表
        $router->get('/menber/create','Menber\\MenberController@create')->middleware('front.permission:check,menber_edit');//编辑
        $router->post('/menber','Menber\\MenberController@store')->middleware('front.permission:check,menber_edit');//编辑
        $router->get('/menber/{id}','Menber\\MenberController@show')->middleware('front.permission:check,menber_list');//列表
        $router->get('/menber/{id}/edit','Menber\\MenberController@edit')->middleware('front.permission:check,menber_edit');//编辑
        $router->put('/menber/{id}','Menber\\MenberController@update')->middleware('front.permission:check,menber_edit');//编辑
        $router->delete('/menber/{id}','Menber\\MenberController@destroy')->middleware('front.permission:check,menber_edit');//编辑

        $router->post('/editper', 'Menber\\MenberController@editper')->middleware('front.permission:check,menber_edit');
    });
/*target*/
    //目标管理
    Route::group([
    ], function (Router $router) {
        $router->get('/target','Target\\TargetController@index')->middleware('front.permission:check,target_list');//列表
        $router->get('/target/create','Target\\TargetController@create')->middleware('front.permission:check,target_edit');//编辑
        $router->post('/target','Target\\TargetController@store')->middleware('front.permission:check,target_edit');//编辑
        $router->get('/target/{id}','Target\\TargetController@show')->middleware('front.permission:check,target_list');//列表
        $router->get('/target/{id}/edit','Target\\TargetController@edit')->middleware('front.permission:check,target_edit');//编辑
        $router->put('/target/{id}','Target\\TargetController@update')->middleware('front.permission:check,target_edit');//编辑
        $router->delete('/target/{id}','Target\\TargetController@destroy')->middleware('front.permission:check,target_edit');//编辑

        $router->get('/target/{target_id}/targetd','Target\\TargetDController@index')->middleware('front.permission:check,target_list');//列表
        $router->get('/target/{target_id}/targetd/create','Target\\TargetDController@create')->middleware('front.permission:check,target_edit');//编辑
        $router->post('/target/{target_id}/targetd','Target\\TargetDController@store')->middleware('front.permission:check,target_edit');//编辑
        $router->get('/target/{target_id}/targetd/{id}','Target\\TargetDController@show')->middleware('front.permission:check,target_list');//列表
        $router->get('/target/{target_id}/targetd/{id}/edit','Target\\TargetDController@edit')->middleware('front.permission:check,target_edit');//编辑
        $router->put('/target/{target_id}/targetd/{id}','Target\\TargetDController@update')->middleware('front.permission:check,target_edit');//编辑
        $router->delete('/target/{target_id}/targetd/{id}','Target\\TargetDController@destroy')->middleware('front.permission:check,target_edit');//编辑

        $router->get('/target/{target_id}/targetd/{targetd_id}/targetm','Target\\TargetMController@index')->middleware('front.permission:check,target_list');//列表
        $router->post('/target/{target_id}/targetd/{targetd_id}/targetm','Target\\TargetMController@store');//编辑
        $router->get('/target/{target_id}/targetd/{targetd_id}/targetm/{id}','Target\\TargetMController@show')->middleware('front.permission:check,target_list');//列表
        $router->get('/target/{target_id}/targetd/{targetd_id}/targetm/{id}/edit','Target\\TargetMController@edit')->middleware('front.permission:check,target_edit');//编辑
        $router->put('/target/{target_id}/targetd/{targetd_id}/targetm/{id}','Target\\TargetMController@update')->middleware('front.permission:check,target_edit');//编辑

    });
/*customer*/
    //客户管理
    Route::group([
    ], function (Router $router) {
        $router->get('/customer','Customer\\CustomerController@index')->middleware('front.permission:check,customer_list');//列表
        $router->get('/customer/create','Customer\\CustomerController@create')->middleware('front.permission:check,customer_edit');//编辑
        $router->post('/customer','Customer\\CustomerController@store')->middleware('front.permission:check,customer_edit');//编辑
        $router->get('/customer/{id}','Customer\\CustomerController@show')->middleware('front.permission:check,customer_list');//列表
        $router->get('/customer/{id}/edit','Customer\\CustomerController@edit')->middleware('front.permission:check,customer_edit');//编辑
        $router->put('/customer/{id}','Customer\\CustomerController@update')->middleware('front.permission:check,customer_edit');//编辑
        $router->delete('/customer/{id}','Customer\\CustomerController@destroy')->middleware('front.permission:check,customer_edit');//编辑

        $router->get('/api/region/city', 'Api\\ReController@city');
        $router->get('/api/region/district', 'Api\\ReController@district');
    });

/*finance*/
    Route::group([
        'middleware'    => AddMenberTarget::class,
    ], function (Router $router) {
        //input
        $router->get('/finance/input','Finance\\InputController@index')->middleware('front.permission:check,finance_input_list');//列表
        $router->get('/finance/input/create','Finance\\InputController@create')->middleware('front.permission:check,finance_input_edit');//编辑
        $router->post('/finance/input','Finance\\InputController@store')->middleware('front.permission:check,finance_input_edit');//编辑
        $router->get('/finance/input/{id}','Finance\\InputController@show')->middleware('front.permission:check,finance_input_list');//列表
        $router->get('/finance/input/{id}/edit','Finance\\InputController@edit')->middleware('front.permission:check,finance_input_edit');//编辑
        $router->put('/finance/input/{id}','Finance\\InputController@update')->middleware('front.permission:check,finance_input_edit');//编辑
        $router->delete('/finance/input/{id}','Finance\\InputController@destroy')->middleware('front.permission:check,finance_input_edit');//编辑

        //fapiao
        $router->get('/finance/fapiao', 'Finance\\FapiaoController@index')->middleware('front.permission:check,finance_fapiao');
        $router->get('/finance/fapiao/getdetail/{input_id}', 'Finance\\FapiaoController@getDetail')->middleware('front.permission:check,finance_fapiao');
        $router->post('/finance/fapiao/setdetail/{input_id}', 'Finance\\FapiaoController@setDetail')->middleware('front.permission:check,finance_fapiao');

        $router->put('/finance/fapiao/update/{input_id}', 'Finance\\FapiaoController@update')->middleware('front.permission:check,finance_fapiao');


        //pay
        $router->get('/finance/pay', 'Finance\\PayController@index')->middleware('front.permission:check,finance_pay');
        $router->get('/finance/pay/getdetail/{input_id}', 'Finance\\PayController@getDetail')->middleware('front.permission:check,finance_pay');
        $router->post('/finance/pay/setdetail/{input_id}', 'Finance\\PayController@setDetail')->middleware('front.permission:check,finance_pay');

        $router->put('/finance/pay/update/{input_id}', 'Finance\\PayController@update')->middleware('front.permission:check,finance_pay');

        //yeji
        $router->get('/checkout', 'Yeji\\CheckoutController@index')->middleware('front.permission:check,checkout');
        $router->get('/checkout/p/{t_id}', 'Yeji\\CheckoutController@checkoutIndex')->middleware('front.permission:check,checkout');
        $router->get('/checkout/p/{t_id}/getdetail/{u_id}', 'Yeji\\CheckoutController@getDetail')->middleware('front.permission:check,checkout');
        $router->post('/checkout/p/{t_id}/setdetail/{u_id}', 'Yeji\\CheckoutController@setDetail')->middleware('front.permission:check,checkout');

        $router->put('/checkout/p/{t_id}/update/{u_id}', 'Yeji\\CheckoutController@update')->middleware('front.permission:check,checkout');


        $router->get('/selectp/', 'Finance\\InputController@selectp');

    });

/*chart*/
    $router->get('/user_chart', 'Chart\\UserChartController@index')->middleware('front.permission:check,user_chart');




    //$router->resource('/permissions', 'PermissionController');
    $router->resource('/api/input/u', 'Api\\UController');


});
