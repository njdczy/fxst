<?php

namespace App\Menber\Controllers;

use App\Menber\Layout\Content;

use App\Menber\Widgets\InfoBox;

use App\Models\Target;
use App\Models\TargetM;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{

    public function index()
    {

        return \Menber::content(function (Content $content) {
            $content->header('发行管理系统');
            $content->description(config('menber.logo', config('menber.name')));


            $menber_targets = TargetM::where('user_id', \Menber::user()->user_id)
                ->where('u_id',\Menber::user()->user_id)
                ->get();

            $content->row(function ($row) use ($menber_targets) {

                $menber_targets->each(function ($menber_target,$key) use ($row){
                    $target = Target::find($menber_target->t_id);
                    $row->column(3, new InfoBox('已完成/目标：'.$menber_target->numed .'/'.$menber_target->num ,
                        'shopping-cart', 'yellow',
                        \Menber::url('/myorders?p_id='
                            .$target->periodical->id .
                            '&created_at[start]='
                            .$target->s_time.
                            '&created_at[end]='
                            .$target->e_time.
                            '&pay_status='),
                        $target->periodical->name));
                });
            });
        });
    }
}
