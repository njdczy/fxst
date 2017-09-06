<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/26
 * Time: 13:34
 */

namespace App\Http\Middleware;

use App\Models\Baoshe;
use App\Models\JituanConfig;
use App\Models\Periodical;
use App\Models\Region;
use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\MessageBag;

class IsSetBaseMiddleware
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
        if (\Front::user()) {
            //set
            $jituan_name = JituanConfig::where('user_id',\Front::user()->user_id)->value('jituan_name');
            config(['front.name'=>$jituan_name]);
            config(['front.logo'=>'<b>'.$jituan_name.'</b> ']);
            //检查是否设置集团名称
//            if (
//                !$jituan_name
//                &&
//                !$this->passThrough($request,
//                    [
//                        'get' =>  \Front::url('base/jconfig/'),
//                        'post' =>\Front::url('base/jconfig'),
//                    ]
//                )
//            )
//            {
//                $error = new MessageBag([
//                    'title'   => '请先填写基本信息',
//                    'message' => '',
//                ]);
//                return redirect()->route('jconfig')->with(compact('error'));
//            }
            //检查是否添加报社
            if (
//                JituanConfig::where('user_id',\Front::user()->user_id)->first()
//                &&
                !Baoshe::where('user_id',\Front::user()->user_id)->first()
                &&
                !$this->passThrough($request,
                    [

                        'get' =>  \Front::url('base/baoshe/create'),
                        'post' =>\Front::url('base/baoshe'),
                    ]
                )
            )
            {
                $error = new MessageBag([
                    'title'   => '请先添加一个报社',
                    'message' => '',
                ]);
                return redirect()->to(\Front::url('base/baoshe/create'))->with(compact('error'));
            }
            //检查是否添加刊物
            if (
                Baoshe::where('user_id',\Front::user()->user_id)->first()
                &&
                !Periodical::where('user_id',\Front::user()->user_id)->first()
                &&
                !$this->passThrough($request,
                    [
                        'get' =>  \Front::url('base/periodical/create'),
                        'post' =>\Front::url('base/periodical'),
                    ]
                )
            )
            {
                $error = new MessageBag([
                    'title'   => '请先添加一个刊物',
                    'message' => '',
                ]);
                return redirect()->to(\Front::url('base/periodical/create'))->with(compact('error'));
            }
//            //检查是否设置部门

            Cache::remember('regions', '60', function () {
                return Region::all()->pluck('name','code')->toArray();
            });
        }

        return $next($request);
    }

    /**
     * Determine if the request has a URI that should pass through verification.
     *
     * @param \Illuminate\Http\Request $request
     * @param array $excepts
     *
     * @return bool
     */
    protected function passThrough($request , array $excepts)
    {
        foreach ($excepts as $method => $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }
            if ( $request->isMethod($method) && $request->is($except)) {
                return true;
            }
        }

        return false;
    }
}