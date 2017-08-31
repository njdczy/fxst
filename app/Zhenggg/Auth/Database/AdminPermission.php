<?php

namespace App\Zhenggg\Auth\Database;

trait AdminPermission
{

    /**
     * Get avatar attribute.
     *
     * @param string $avatar
     *
     * @return string
     */
    public function getAvatarAttribute($avatar)
    {
        if ($avatar) {
            return rtrim(config('front.upload.host'), '/').'/'.trim($avatar, '/');
        }

        return asset('/packages/front/AdminLTE/dist/img/user2-160x160.jpg');
    }

    /**
     * A user has and belongs to many roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function roles()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * A User has and belongs to many permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        $pivotTable = config('front.database.user_permissions_table');

        $relatedModel = config('front.database.permissions_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'user_id', 'permission_id');
    }

    /**
     * A User belongs to many menus.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function menus()
    {
        $pivotTable = config('front.database.user_menu_table');

        $relatedModel = config('front.database.menu_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'user_id', 'menu_id');
    }

    /**
     * Check if user has permission.
     *
     * @param $permission
     *
     * @return bool
     */
    public function can($permission)
    {
        if ($this->isMainAccount()) {
            return true;
        }

        if (method_exists($this, 'permissions')) {

            if ($this->permissions()->where('slug', $permission)->exists()) {
                return true;
            }

            $permission = Permission::where('parent_id',0)->where('slug',$permission)->first();
            if ($permission &&
                $this->permissions()->where('parent_id', $permission->id)->exists()) {
                return true;
            }
        }

//        foreach ($this->roles as $role) {
//            if ($role->can($permission)) {
//                return true;
//            }
//        }

        return false;
    }

    /**
     * Check if user has no permission.
     *
     * @param $permission
     *
     * @return bool
     */
    public function cannot($permission)
    {
        return !$this->can($permission);
    }

    /**
     * Check if user is administrator.
     *
     * @return mixed
     */
    public function isMainAccount()
    {
        return $this->isRole('main_account');
    }

    /**
     * Check if user is $role.
     *
     * @param string $role
     *
     * @return mixed
     */
    public function isRole($role)
    {
        return $this->roles()->where('slug', $role)->exists();
    }

    /**
     * Check if user in $roles.
     *
     * @param array $roles
     *
     * @return mixed
     */
    public function inRoles($roles = [])
    {
        return $this->roles()->whereIn('slug', (array) $roles)->exists();
    }

    /**
     * If visible for roles.
     *
     * @param $roles
     *
     * @return bool
     */
    public function visible($roles)
    {
        if (empty($roles)) {
            return true;
        }
        $roles = array_column($roles, 'slug');
        if ($this->inRoles($roles) || $this->isMainAccount()) {
            return true;
        }

        return false;
    }

    /**
     * If visible for adminusers.
     *
     * @param administrators
     *
     * @return bool
     */
    public function userVisible($administrators)
    {
        if ($this->isMainAccount()) {
            return true;
        }

        if ($administrators) {
            foreach ($administrators as $user) {
                $users[] = $user['pivot']['user_id'];
            }

            if (in_array($this->id, $users) ) {
                return true;
            }
        }

        return false;
    }
}
