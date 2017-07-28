<?php

namespace App\Zhenggg\Auth\Database;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name', 'slug', 'parent_id'];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $connection = config('front.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('front.database.permissions_table'));

        parent::__construct($attributes);
    }

    /**
     * Permission belongs to many roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        $pivotTable = config('front.database.role_permissions_table');

        $relatedModel = config('front.database.roles_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'permission_id', 'role_id');
    }
}
