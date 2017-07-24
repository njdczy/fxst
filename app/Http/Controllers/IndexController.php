<?php
namespace App\Http\Controllers;


use App\Zhenggg\Front;

class IndexController extends Controller
{


    public function doForm($u_id,FormRequest $request)
    {
        return view('form');
    }
}