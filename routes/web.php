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

Route::get('/form/{u_id}', 'IndexController@formm');


Route::post('/formg/{u_id}', 'IndexController@doFormmg');
Route::post('/formq/{u_id}', 'IndexController@doFormmq');

