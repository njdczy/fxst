<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/18
 * Time: 13:28
 */

namespace App\Front\Extensions\Action;


class PayAction
{
    protected $id;
    protected $pay_status;

    public function __construct($id,$pay_status)
    {

        $this->id = $id;
        $this->pay_status = $pay_status;
    }

    protected function script()
    {
        $update_url = \Front::url('/finance/pay/update/' . $this->id);
        return <<<SCRIPT

$('#pay$this->id').on('click', function () {
    
    var id =  $(this).data('id');
    var paytype = $(this).data('paytype');
    if(0 == paytype) {
        $(".liushuihao").hide();
    } else {
        $(".liushuihao").show();
    }
    $("#paytype"+id).val(paytype);
    $(".head-pay").nextAll().remove();
             $.ajax({
                method: 'get',
                url: $(this).data('url'),
                success: function (data) {
                    if (typeof data === 'object') {
                        $("#not_pay_money"+id).val(data.not_pay_money);

                                                          
                        if ( !$.isEmptyObject(data.liushuis) ) {
                              
                              $(".liushuis-table").show();
                              $.each(data.liushuis, function (n, value) {
                                   var trs = "";
                                   trs += "<tr><td>" + value.key + 
                                   "</td> <td>" + value.pay_type + 
                                   "</td><td>" + value.should_pay_money + 
                                   "</td><td>" + value.money + 
                                   "</td><td>" + value.kou + "<td><a href='#' class='grid-editable-liushuis editable editable-click' data-type='text' data-pk='" + value.id + "' " +
" data-url='$update_url' data-name='liushuihao' data-value='"+value.liushuihao+ 
"' +data-original-title='' title=''>" + value.liushuihao + "</a></td>"+
                                   "</td><td><a href='#' class='grid-editable-liushuis editable editable-click' data-type='text' data-pk='" + value.id + "' " +
                                   " data-url='$update_url' data-name='shou_time' data-value='" +value.shou_time + 
                                   "' +data-original-title='' title=''>" + value.shou_time + 
                                   "</a>"
                                   "</td></tr>";
                                   $(trs).insertAfter($('.head-pay'));
                              }); 
                        } 
                    }
                }
            });
});

                            $.fn.editable.defaults.params = function (params) {
                                params._token = LA.token;
                                params._editable = 1;
                                params._method = 'PUT';
                                return params;
                            };
SCRIPT;
    }

    protected function render()
    {
        \Front::script($this->script());
        $url = \Front::url('/finance/pay/getdetail/'.$this->id);
        $form_url = \Front::url('/finance/pay/setdetail/'.$this->id);

        return view('front::zhenggg.action.PayAction',
            [
                'id' => $this->id,
                'pay_status' => $this->pay_status,
                'url' => $url,
                'form_url' => $form_url,
            ])->__toString();
    }

    public function __toString()
    {
        return $this->render();
    }
}