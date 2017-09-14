<?php

namespace App\Menber\Controllers;

use App\Models\Department;
use App\Models\Input;
use App\Models\Periodical;
use App\Menber\Layout\Column;
use App\Menber\Layout\Content;
use App\Menber\Layout\Row;
use App\Menber\Widgets\Box;

use App\Menber\Widgets\Chart\Line;

use App\Menber\Widgets\InfoBox;

use Carbon\Carbon;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{

    public function index()
    {

        return \Menber::content(function (Content $content) {
            $content->header('发行管理系统');
            $content->description(config('menber.logo', config('menber.name')));
        });
    }
}