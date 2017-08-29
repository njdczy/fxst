<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/18
 * Time: 14:08
 */

namespace App\Front\Extensions\Action;


class JisuanAction
{
    protected $id;
    protected $t_id;
    protected $j_status;

    public function __construct($id,$t_id,$j_status)
    {
        $this->id = $id;
        $this->t_id = $t_id;
        $this->j_status = $j_status;
    }

    protected function script()
    {
        return <<<SCRIPT
$('.fafang').on('click', function () {
    
    var id =  $(this).data('id');
    
    $(".head-fafang").nextAll().remove();
             $.ajax({
                method: 'get',
                url: $(this).data('url'),
                success: function (data) {
                     
                    if (typeof data === 'object') {
                        $("#not_jie_money"+id).val(data.not_jie_money);
                                                          
                        if ( !$.isEmptyObject(data.jisuans) ) {
                              
                              $(".jisuans-table").show();
                              $.each(data.jisuans, function (n, value) {
                                   var trs = "";
                                   trs += "<tr><td>" + value.key + "</td> <td>" + value.fafang_type + "</td><td>" + value.money + "</td><td>" + value.fa_time + "</td></tr>";
                                   $(trs).insertAfter($('.head-fafang'));
                              }); 
                        } 
                    }
                }
            });
});

SCRIPT;
    }

    protected function render()
    {
        \Front::script($this->script());
        $url = \Front::url('/checkout/p/'.$this->t_id.'/getdetail/' . $this->id);
        $form_url = \Front::url('/checkout/p/'.$this->t_id.'/setdetail/' . $this->id);

        return view('front::zhenggg.action.JisuanAction',
            [
                'id' => $this->id,
                't_id' => $this->t_id,
                'url' => $url,
                'j_status' => $this->j_status,
                'form_url' => $form_url,
            ])->__toString();
    }

    public function __toString()
    {
        return $this->render();
    }
}