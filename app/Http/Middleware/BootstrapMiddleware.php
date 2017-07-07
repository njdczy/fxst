<?php

namespace App\Http\Middleware;

use App\Zhenggg\Form;
use App\Zhenggg\Grid;
use Illuminate\Http\Request;

class BootstrapMiddleware
{
    public function handle(Request $request, \Closure $next)
    {
        Form::registerBuiltinFields();

        if (file_exists($bootstrap = front_path('bootstrap.php'))) {
            require $bootstrap;
        }

        Form::collectFieldAssets();

        Grid::registerColumnDisplayer();

        return $next($request);
    }
}
