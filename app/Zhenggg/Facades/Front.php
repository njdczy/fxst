<?php

namespace App\Zhenggg\Facades;

use Illuminate\Support\Facades\Facade;

class Front extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Zhenggg\Front::class;
    }
}
