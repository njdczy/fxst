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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        $pivotTable = config('front.database.role_users_table');

        $relatedModel = config('front.database.roles_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'user_id', 'role_id');
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
        }

        foreach ($this->roles as $role) {
            if ($role->can($permission)) {
                return true;
            }
        }

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
}