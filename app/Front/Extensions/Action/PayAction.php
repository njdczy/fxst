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
        return <<<SCRIPT

$('.pay').on('click', function () {
    
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
                                   trs += "<tr><td>" + value.key + "</td> <td>" + value.pay_type + "</td><td>" + value.should_pay_money + "</td><td>" + value.money + "</td><td>" + value.kou + "</td><td>" + value.liushuihao + "</td><td>" + value.shou_time + "</td></tr>";
                                   $(trs).insertAfter($('.head-pay'));
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