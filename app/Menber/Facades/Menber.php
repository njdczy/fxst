<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/14
 * Time: 16:08
 */

namespace App\Menber\Facades;


use Illuminate\Support\Facades\Facade;

class Menber extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Menber\Menber::class;
    }
}