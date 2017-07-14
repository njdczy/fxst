<?php

namespace App\Observer;

use App\Zhenggg\Auth\Database\Role;
use App\Zhenggg\Facades\Front;

class MenberObserver
{
    public function created($menber)
    {
        //当新增人员后，部门人数+1
        $menber->roles->each(function ($item, $key) {
            if ($item) {
                Role::where('user_id', '=', Front::user()->id)
                    ->where('id', $item->id)
                    ->increment('menber_count');
            }
        });
    }


    public function deleted($menber)
    {
        //当删除人员后，部门人数-1
        $menber->roles->each(function ($item, $key) {
            if ($item) {
                Role::where('user_id', '=', Front::user()->id)
                    ->where('id', $item->id)
                    ->decrement('menber_count');
            }
        });
    }
}