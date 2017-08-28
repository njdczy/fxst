<?php

namespace App\Front\Controllers\Menber;

use App\Front\Controllers\ModelForm;
use App\Front\Extensions\MenberDel;
use App\Front\Extensions\MenberEdit;
use App\Models\Department;
use App\Models\Menber;
use App\Models\MenberPer;
use App\Models\Periodical;
use App\Zhenggg\Form;
use App\Zhenggg\Grid;
use App\Zhenggg\Layout\Content;
use function foo\func;
use Illuminate\Routing\Controller;

use Illuminate\Support\MessageBag;
use QrCode;

class MenberController extends Controller
{
    use ModelForm;

    public function index()
    {
        return \Front::content(function (Content $content) {
            $content->header('发行人');
            $content->description(trans('front::lang.list'));
            $content->body($this->grid()->render());
        });
    }

    public function edit($id)
    {
        return \Front::content(function (Content $content) use ($id) {
            $content->header('发行人');
            $content->description(trans('front::lang.edit'));
            $content->body($this->form()->edit($id));
        });
    }

    public function create()
    {
        return \Front::content(function (Content $content) {
            $content->header('发行人');
            $content->description(trans('front::lang.create'));
            $content->body($this->form());
        });
    }

    protected function grid()
    {
        return \Front::grid(Menber::class, function (Grid $grid) {
            $grid->model()
                ->where('user_id', '=', \Front::user()->user_id);

            $grid->name('姓名');

            $grid->department()->name('部门')->display(function () {
                if ($this->department['parent_id'] > 0) {
                    $parent_name = Department::where('id', $this->department['parent_id'])->value('name');

                    return $this->department['name'] . '(' . $parent_name . ')';
                }

                return $this->department['name'];
            })->label();
            $grid->column('qrcode', '二维码')->display(function () {
                return '<img src="data:image/png;base64,'
                    . base64_encode(
                        QrCode::format("png")
                            //->merge(asset('images/logo/logo'.\Front::user()->id.'.png'), .28,true)
                            ->errorCorrection('H')
                            ->size(140)
                            ->generate(url("/form/" . $this->id))
                    )
                    . '"/>';
            });


            $grid->money('余额')->display(function(){
                $sql = "SELECT moneyed FROM u_checkouts this 
                    WHERE created_at = ( SELECT MAX( created_at ) FROM u_checkouts
                                          WHERE 
                                            this.t_id = u_checkouts.t_id 
                                          AND 
                                             u_id = " . $this->id . " 
                                        )";
                $res = \DB::select($sql);
                $re = 0;
                foreach ($res as $r) {
                    $re = $re +$r->moneyed;
                }
               return $re;
            });
            $ps = Periodical::all();
            $grid->column('m_per', '月分成比例')->display(function () use ($ps) {

                $m_pers = MenberPer::where('user_id', '=', \Front::user()->user_id)
                    ->where('menber_id', $this->id)->where('type', 'm')->pluck('per', 'p_id')->toArray();
                $html = '';
                foreach ($ps as $p_key => $p) {
                    if (array_key_exists($p->id,$m_pers)) {
                        $p_per = $m_pers[$p->id];
                        $html .= "<p>" . $p->name . ":<a  onclick=\"setdata('$p->name','月','$this->id','$p->id','$p_per','m')\" data-toggle=\"modal\" data-target=\"#menberedit-modal\" >" . $p_per . "%</a></p>";

                    } else {
                        $html .= "<p>" . $p->name . ":<a  onclick=\"setdata('$p->name','月','$this->id','$p->id','$p->per','m')\" data-toggle=\"modal\" data-target=\"#menberedit-modal\" >" . $p->per . "%</a></p>";
                    }
                }
                return $html;
            });
            $grid->column('j_per', '季分成比例')->display(function () use ($ps) {

                $j_pers = MenberPer::where('user_id', '=', \Front::user()->user_id)
                    ->where('menber_id', $this->id)->where('type', 'j')->pluck('per', 'p_id')->toArray();
                $html = '';
                foreach ($ps as $p_key => $p) {
                    if (array_key_exists($p->id,$j_pers)) {
                        $p_per = $j_pers[$p->id];
                        $html .= "<p>" . $p->name . ":<a  onclick=\"setdata('$p->name','季','$this->id','$p->id','$p_per','j')\" data-toggle=\"modal\" data-target=\"#menberedit-modal\" >" . $p_per . "%</a></p>";

                    } else {
                        $html .= "<p>" . $p->name . ":<a  onclick=\"setdata('$p->name','季','$this->id','$p->id','$p->per','j')\" data-toggle=\"modal\" data-target=\"#menberedit-modal\" >" . $p->per . "%</a></p>";
                    }
                }
                return $html;
            });
            $grid->column('b_per', '半年分成比例')->display(function () use ($ps) {

                $b_pers = MenberPer::where('user_id', '=', \Front::user()->user_id)
                    ->where('menber_id', $this->id)->where('type', 'b')->pluck('per', 'p_id')->toArray();
                $html = '';
                foreach ($ps as $p_key => $p) {
                    if (array_key_exists($p->id,$b_pers)) {
                        $p_per = $b_pers[$p->id];
                        $html .= "<p>" . $p->name . ":<a  onclick=\"setdata('$p->name','半年','$this->id','$p->id','$p_per','b')\" data-toggle=\"modal\" data-target=\"#menberedit-modal\" >" . $p_per . "%</a></p>";

                    } else {
                        $html .= "<p>" . $p->name . ":<a  onclick=\"setdata('$p->name','半年','$this->id','$p->id','$p->per','b')\" data-toggle=\"modal\" data-target=\"#menberedit-modal\" >" . $p->per . "%</a></p>";
                    }
                }
                return $html;
            });
            $grid->column('y_per', '年分成比例')->display(function () use ($ps) {

                $y_pers = MenberPer::where('user_id', '=', \Front::user()->user_id)
                    ->where('menber_id', $this->id)->where('type', 'y')->pluck('per', 'p_id')->toArray();
                $html = '';
                foreach ($ps as $p_key => $p) {
                    if (array_key_exists($p->id,$y_pers)) {
                        $p_per = $y_pers[$p->id];
                        $html .= "<p>" . $p->name . ":<a  onclick=\"setdata('$p->name','年','$this->id','$p->id','$p_per','y')\" data-toggle=\"modal\" data-target=\"#menberedit-modal\" >" . $p_per . "%</a></p>";

                    } else {
                        $html .= "<p>" . $p->name . ":<a  onclick=\"setdata('$p->name','年','$this->id','$p->id','$p->per','y')\" data-toggle=\"modal\" data-target=\"#menberedit-modal\" >" . $p->per . "%</a></p>";
                    }
                }
                return $html;
            });
            $grid->filter(function ($filter) {

                $filter->disableIdFilter();

                $filter->like('name', '姓名');

                $filter->is('d_id', '所属部门')->select(Department::selectOptionsForNoroot());

            });

            $grid->actions(function ($actions) {
                $actions->disableDelete();
                //自定义删除
                $actions->append(new MenberDel($actions->getKey()));
            });
            $grid->disableExport();
            $grid->tools(function ($tools) {
                $tools->append(new MenberEdit());
            });
        });
    }

    public function form()
    {
        return \Front::form(Menber::class, function (Form $form) {

            $form->text('name', '姓名')->rules('required');
            $select = Department::selectOptionsForNoroot();
            $form->select('d_id', '部门')->options($select);

            $form->display('created_at', trans('front::lang.created_at'));
            $form->display('updated_at', trans('front::lang.updated_at'));
            $form->hidden('user_id')->default(\Front::user()->user_id);
            $form->saving(function (Form $form){
                if ( Menber::where('name',$form->name)->exists()) {
                    $error = new MessageBag([
                        'title'   => '人名不能重复',
                        'message' => $form->name .'已存在',
                    ]);
                    return back()->with(compact('error'));
                }

            });
        });
    }

    public function editper()
    {
        $p_id = request('p_id');
        $menber_id = request('menber_id');
        $per = request('per');
        $type = request('type');
        $menber_per = MenberPer::firstOrNew([
            'user_id' => \Front::user()->user_id,
            'menber_id' => $menber_id,
            'p_id' => $p_id,
            'type' => $type
        ]);
        $menber_per->per = $per;
        $menber_per->save();
        $succeed = new MessageBag([
            'title'   => '修改成功',
            'message' => '',
        ]);
        return redirect()->back()->with(compact('succeed'));
    }
}
