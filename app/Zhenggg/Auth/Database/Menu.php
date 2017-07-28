<?php

namespace App\Zhenggg\Auth\Database;

use App\Zhenggg\Traits\AdminBuilder;
use App\Zhenggg\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Menu.
 *
 * @property int $id
 *
 * @method where($parent_id, $id)
 */
class Menu extends Model
{
    use ModelTree, AdminBuilder;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['parent_id', 'order', 'title', 'icon', 'uri'];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $connection = config('front.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('front.database.menu_table'));

        parent::__construct($attributes);
    }

    /**
     * A Menu belongs to many roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        $pivotTable = config('front.database.role_menu_table');

        $relatedModel = config('front.database.roles_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'menu_id', 'role_id');
    }

    /**
     * A Menu belongs to many roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function administrators()
    {
        $pivotTable = config('front.database.user_menu_table');

        $relatedModel = config('front.database.users_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'menu_id', 'user_id');
    }

    /**
     * @return array
     */
    public function allNodes()
    {
        $orderColumn = DB::getQueryGrammar()->wrap($this->orderColumn);
        $byOrder = $orderColumn.' = 0,'.$orderColumn;

        return static::with('administrators')->orderByRaw($byOrder)->get()->toArray();
    }
}
