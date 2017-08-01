<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/1
 * Time: 11:48
 */

namespace App\Observer;


use App\Models\Department;

class BaosheObserver
{
    public function created($baoshe)
    {
        $department = new Department;
        $department->user_id = $baoshe->user_id;
        $department->name = $baoshe->name;
        $department->save();
    }
}