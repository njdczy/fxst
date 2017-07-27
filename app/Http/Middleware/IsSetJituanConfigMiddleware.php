<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/26
 * Time: 13:34
 */

namespace App\Http\Middleware;

use App\Models\JituanConfig;
use App\Zhenggg\Facades\Front;
use Closure;
use Illuminate\Support\MessageBag;

class IsSetJituanConfigMiddleware
{
    /**
     * 检查是否设置
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //检查是否设置集团名称
        if (Front::user()
            &&
            !JituanConfig::where('user_id',Front::user()->user_id)->first()
            &&
            !$this->shouldPassThrough($request)
            )
        {
            $error = new MessageBag([
                'title'   => '请先填写基本信息',
                'message' => '',
            ]);

            return redirect()->route('jconfig')->with(compact('error'));
        }
        //检查是否添加报社
        //检查是否添加刊物
        //检查是否设置部门
        return $next($request);
    }

    /**
     * Determine if the request has a URI that should pass through verification.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    protected function shouldPassThrough($request)
    {
        $excepts = [
            Front::url('system/jconfig'),
        ];

        foreach ($excepts as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->is($except)) {
                return true;
            }
        }

        return false;
    }
}