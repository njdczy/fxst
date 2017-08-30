<?php

namespace App\Zhenggg\Auth\Database;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $incrementing  = false;


    protected $fillable = ['id','name', 'slug', 'parent_id','order','user_id'];

    /**
     * @var string
     */
    protected $parentColumn = 'parent_id';

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

    public function scopeFirstNode()
    {
        return $this->where('user_id', \Front::user()->user_id)
            ->where('parent_id',0)
            ->orderBy('order','asc');
    }

    public function scopeUserNode()
    {
        return $this->where('user_id', \Front::user()->user_id)
            ->orderBy('order','asc');
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


    /**
     * Get children of current node.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(static::class, $this->parentColumn);
    }

    /**
     * Get parent of current node.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(static::class, $this->parentColumn);
    }
}
