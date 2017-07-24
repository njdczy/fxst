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


Route::get('/form/{u_id}', function ($u_id) {
    return view('form',['u_id' => $u_id]);
});

Route::post('/form/{u_id}', 'IndexController@doForm');

