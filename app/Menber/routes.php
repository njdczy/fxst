<?php

use App\Menber\Facades\Menber;
use Illuminate\Routing\Router;

Menber::registerHelpersRoutes();

Route::group([
    'prefix'        => config('menber.prefix'),
    'namespace'     => Menber::controllerNamespace(),
    'middleware'    => ['web', 'menber'],
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->get('/myorders', 'MyOrdersController@index');
    $router->put('/myorders/{id}', 'MyOrdersController@update');
    
    $router->get('/mycustomers', 'MyCustomersController@index');
});
