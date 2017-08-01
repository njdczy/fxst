<?php

namespace App\Observer;



class MenberObserver
{
    public function created($menber)
    {
        //当新增人员后，部门人数+1
        $department = $menber->department;
        $department->menber_count = (int)($department->menber_count+1);
        $department->save();
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