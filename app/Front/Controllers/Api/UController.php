<?php
namespace App\Front\Controllers\Api;

use App\Zhenggg\Auth\Database\Role;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/17
 * Time: 21:34
 */
class UController extends Controller
{
    public function index(Request $request)
    {
        $role_id = $request->get('q');

        $users = Role::find($role_id)->administrators->toArray();

        $return_users = collect();

        foreach ($users as $user) {
            $return_users->put($user['id'],$user['username']);
        }

        return $return_users;
    }
}