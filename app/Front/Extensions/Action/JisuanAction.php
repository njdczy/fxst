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
        $update_url = \Front::url('/checkout/p/'.$this->t_id.'/update/' . $this->id);
        return <<<SCRIPT
$('#fafang$this->id').on('click', function () {
    $("#tijiao$this->id").removeAttr("disabled");
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
                                   trs += "<tr><td>" + value.key + 
                                   "</td> <td><a href='#' class='grid-editable-fafang editable editable-click' data-type='text' data-pk='" + value.id + "' " +
                                   " data-url='$update_url' data-name='money' data-value='" +value.money + 
                                   "' +data-original-title='' title=''>" + value.money + 
                                   "</a></td><td><a href='#' class='grid-editable-fafang editable editable-click' data-type='text' data-pk='" + value.id + "' " +
                                   " data-url='$update_url' data-name='fafang_type' data-value='" +value.fafang_type + 
                                   "' +data-original-title='' title=''>" + value.fafang_type + 
                                   "</a></td><td><a href='#' class='grid-editable-fafang editable editable-click' data-type='text' data-pk='" + value.id + "' " +
                                   " data-url='$update_url' data-name='fa_time' data-value='" +value.fa_time + 
                                   "' +data-original-title='' title=''>" + value.fa_time + 
                                   "</a></td></tr>";
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