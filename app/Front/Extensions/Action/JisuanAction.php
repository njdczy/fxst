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

    public function __construct($id,$t_id)
    {
        $this->id = $id;
        $this->t_id = $t_id;
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
                                   trs += "<tr><td>" + value.key + "</td> <td>" + value.fafang_type + "</td><td>" + value.money + "</td><td>" + value.created_at + "</td></tr>";
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
                'form_url' => $form_url,
            ])->__toString();
    }

    public function __toString()
    {
        return $this->render();
    }
}