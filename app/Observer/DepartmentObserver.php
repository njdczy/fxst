<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/1
 * Time: 9:36
 */

namespace App\Observer;


class DepartmentObserver
{
    public function saved($department)
    {
        $now_menber_count = $department->menber_count;
        $original_menber_count = $department->getOriginal('menber_count');

        $parent_department = $department->parent;
        if ($parent_department != null) {
            $parent_department->menber_count = (int)($parent_department->menber_count+(int)($now_menber_count - $original_menber_count));
            $parent_department->save();
        }

    }
}