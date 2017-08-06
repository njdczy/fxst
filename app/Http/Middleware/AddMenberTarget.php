<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/1
 * Time: 14:29
 */

namespace App\Http\Middleware;


use App\Models\Customer;
use App\Models\Menber;
use App\Models\Target;
use App\Zhenggg\Facades\Front;

use Closure;
use Illuminate\Support\MessageBag;
class AddMenberTarget
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
        if (Front::user()) {
            //检查是否设置menber
            if (
                !Menber::where('user_id',Front::user()->user_id)->first()
            )
            {
                $error = new MessageBag([
                    'title'   => '请先添加发行人',
                    'message' => '',
                ]);
                return redirect()->to(Front::url('menber/create'))->with(compact('error'));
            }
            //检查是否设置客户
            if (
                Menber::where('user_id',Front::user()->user_id)->first()
                &&
                !Customer::where('user_id',Front::user()->user_id)->first()
            )
            {
                $error = new MessageBag([
                    'title'   => '请先添加客户',
                    'message' => '',
                ]);
                return redirect()->to(Front::url('customer/create'))->with(compact('error'));
            }
            //检查是否添设置目标
            if (
                Menber::where('user_id',Front::user()->user_id)->first()
                &&
                Customer::where('user_id',Front::user()->user_id)->first()
                &&
                !Target::where('user_id',Front::user()->user_id)->first()
            )
            {
                $error = new MessageBag([
                    'title'   => '请设置刊物目标',
                    'message' => '',
                ]);
                return redirect()->to(Front::url('target/create'))->with(compact('error'));
            }
        }
        return $next($request);
    }
}