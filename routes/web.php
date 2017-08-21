<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/form/{u_id}', 'IndexController@form');


Route::post('/formg/{u_id}', 'IndexController@doFormg');
Route::post('/formq/{u_id}', 'IndexController@doFormq');

Route::get('/formm/s', function(){
    return view('/formm/s');
});