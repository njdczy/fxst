<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/14
 * Time: 15:39
 */

namespace App\Menber\Auth\Database;

use App\Menber\Traits\AdminBuilder;
use App\Menber\Traits\ModelTree;
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
        $connection = config('menber.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('menber.database.menu_table'));

        parent::__construct($attributes);
    }


//    /**
//     * @return array
//     */
//    public function allNodes()
//    {
//        $orderColumn = DB::getQueryGrammar()->wrap($this->orderColumn);
//        $byOrder = $orderColumn.' = 0,'.$orderColumn;
//
//        return static::with('administrators')->orderByRaw($byOrder)->get()->toArray();
//    }
}