<?php

namespace App\Http\Middleware;

use App\Zhenggg\Facades\Front;
use Illuminate\Http\Request;

class OperationLog
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        if (config('front.operation_log') && Front::user()) {
            $log = [
                'user_id' => Front::user()->id,
                'path'    => $request->path(),
                'method'  => $request->method(),
                'ip'      => $request->getClientIp(),
                'input'   => json_encode($request->input()),
            ];

            \App\Zhenggg\Auth\Database\OperationLog::create($log);
        }

        return $next($request);
    }
}
