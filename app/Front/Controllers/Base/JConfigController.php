<?php
namespace App\Front\Controllers\Base;


use App\Zhenggg\Layout\Content;
use App\Zhenggg\Layout\Column;

use App\Zhenggg\Widgets\Box;
use App\Zhenggg\Widgets\Form;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Rule;
use Validator;
use Illuminate\Routing\Controller;
use App\Models\JituanConfig;

class JConfigController extends Controller
{
    use ValidatesRequests;

    public function index()
    {
        return \Front::content(function (Content $content) {
            $content->header('基本信息');
            $content->description('填写');

            $content->row(function ($row) {
                $row->column(2, '');
                $row->column(6, function (Column $column) {

                    $jituan_config = JituanConfig::where('user_id', \Front::user()->user_id)->first();

                    $form = new Form();
                    $form->action(route('store_and_update_jconfig'));

                    $form->text('jituan_name', '单位名称')
                        ->default($jituan_config ? $jituan_config->jituan_name : '')
                        ->placeholder('请先设置本单位名称')
                        ->help('如：新华报业集团');

                    $column->append(new Box('基本信息', $form));

                });
            });
        });
    }

    public function storeAndUpdate(Request $request)
    {
        $this->validate($request,
            [
                'jituan_name' => [
                    'bail',
                    'required',
                    Rule::unique('jituan_configs')->ignore(\Front::user()->user_id, 'user_id')
                ],
            ]
        );
        $jituan_name = $request->input('jituan_name');

        $jituan_config = JituanConfig::firstOrNew(['user_id' => \Front::user()->user_id]);
        $jituan_config->jituan_name = $jituan_name;
        $jituan_config->save();

        $success = new MessageBag([
            'title'   => '基本信息',
            'message' => '编辑成功',
        ]);

        return back()->with(compact('success'));
    }

}