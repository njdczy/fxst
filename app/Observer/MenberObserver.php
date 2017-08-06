<?php

namespace App\Observer;



use App\Models\Department;

class MenberObserver
{
    public function created($menber)
    {
        //当新增人员后，部门人数+1
        $department = $menber->department;
        $department->menber_count = (int)($department->menber_count+1);
        $department->save();
    }

    public function updated($menber)
    {
        //当修改用户部门，重写部门人数
        if ($menber->getOriginal('d_id') != $menber->d_id) {

            $department = Department::find($menber->d_id);
            $department->menber_count = (int)($department->menber_count+1);
            $department->save();

            $department = Department::find($menber->getOriginal('d_id'));
            $department->menber_count = (int)($department->menber_count-1);
            $department->save();
        }
    }


    public function deleted($menber)
    {
        //当删除人员后，部门人数-1
        $department = $menber->department;
        $department->menber_count = (int)($department->menber_count-1);
        $department->save();

        //当删除人员后，
    }

}