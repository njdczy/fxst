<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/3
 * Time: 9:29
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class TargetD extends Model
{
    /**
     * @var \Closure
     */
    protected $queryCallback;

    /**
     * @var string
     */
    protected $parentColumn = 'parent_d_id';

    /**
     * @var string
     */
    protected $orderColumn = 'order';

    protected $fillable = ['d_id','num','order','parent_d_id','user_id'];

    public function target()
    {
        return $this->belongsTo(Target::class, 'target_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'd_id');
    }


    public function toTree($p_id)
    {
        if (empty($nodes)) {
            $nodes = $this->pNodes($p_id);
        }
        return $this->buildNestedArray($nodes);
    }

    protected function buildNestedArray(array $nodes = [], $parentId = 0)
    {
        $branch = [];

        foreach ($nodes as $node) {

            if ($node[$this->parentColumn] == $parentId) {
                $children = $this->buildNestedArray($nodes, $node['d_id']);
                if ($children) {
                    $node['children'] = $children;
                }

                $branch[] = $node;
            }
        }
        return $branch;
    }


    /**
     * Get all elements.
     *
     * @return mixed
     */
    public function pNodes($p_id)
    {
        $orderColumn = \DB::getQueryGrammar()->wrap($this->orderColumn);
        $byOrder = $orderColumn.' = 0,'.$orderColumn;

        $self = new static();

        if ($this->queryCallback instanceof \Closure) {
            $self = call_user_func($this->queryCallback, $self);
        }
        return $self->orderByRaw($byOrder)
            ->where('p_id', $p_id)
            ->where('user_id', \Front::user()->user_id)->get()->toArray();
    }

}