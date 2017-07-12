<?php

namespace App\Observer;

use App\Zhenggg\Auth\Database\Role;
use App\Zhenggg\Facades\Front;

class MenberObserver
{
    public function created($menber)
    {
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
        $menber->roles->each(function ($item, $key) {
            if ($item) {
                Role::where('user_id', '=', Front::user()->id)
                    ->where('id', $item->id)
                    ->decrement('menber_count');
            }
        });
    }
}