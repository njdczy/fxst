<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/16
 * Time: 17:10
 */

namespace App\Front\Controllers\Api;


use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ReController extends Controller
{
    public function city(Request $request)
    {
        $provinceCode = $request->get('q');

        return Region::city()->where('parent_code', $provinceCode)->get([\DB::raw('code as id'), \DB::raw('name as text')]);
    }

    // GET /front/api/region/district?q=1
    public function district(Request $request)
    {
        $cityCode = $request->get('q');

        return Region::district()->where('parent_code', $cityCode)->get([\DB::raw('code as id'), \DB::raw('name as text')]);
    }
}