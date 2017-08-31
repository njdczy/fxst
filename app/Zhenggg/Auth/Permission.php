<?php

namespace App\Zhenggg\Auth;

use App\Zhenggg\Facades\Front;
use App\Http\Middleware\PjaxMiddleware;
use Illuminate\Support\Facades\Auth;

class Permission
{
    /**
     * Check permission.
     *
     * @param $permission
     *
     * @return true
     */
    public static function check($permission)
    {
        if (static::isMainAccount()) {
            return true;
        }
        if (is_array($permission)) {
            collect($permission)->each(function ($permission) {
                call_user_func([Permission::class, 'check'], $permission);
            });

            return;
        }

        if (Auth::guard('front')->user()->cannot($permission)) {
            static::error();
        }
    }

    /**
     * Roles allowed to access.
     *
     * @param $roles
     *
     * @return true
     */
    public static function allow($roles)
    {
        if (static::isMainAccount()) {
            return true;
        }

        if (!Auth::guard('front')->user()->inRoles($roles)) {
            static::error();
        }
    }

    /**
     * Roles denied to access.
     *
     * @param $roles
     *
     * @return true
     */
    public static function deny($roles)
    {
        if (static::isMainAccount()) {
            return true;
        }

        if (Auth::guard('front')->user()->inRoles($roles)) {
            static::error();
        }
    }

    /**
     * Send error response page.
     */
    protected static function error()
    {
        $response = response(Front::content()->withError(trans('front::lang.deny')));
        PjaxMiddleware::respond($response);
    }

    /**
     * If current user is MainAccount.
     *
     * @return mixed
     */
    public static function isMainAccount()
    {
        return Auth::guard('front')->user()->isRole('main_account');
    }
}
