<?php
namespace App\Http\Controllers;


use App\Zhenggg\Front;
use App\Zhenggg\Layout\Content;

class IndexController extends Controller
{


    public function index()
    {
        return Front::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

        });
    }
}