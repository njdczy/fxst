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

    public function __construct($id,$pay_status)
    {

        $this->id = $id;
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
      console.log(111111);  
             $.ajax({
                method: 'get',
                url: $(this).data('url'),
                success: function (data) {
                   console.log(111111);     
                    if (typeof data === 'object') {
                        $("#not_pay_money"+id).val(data.not_pay_money + '￥');

                                                          
                        if ( !$.isEmptyObject(data.liushuis) ) {
                              
                              $(".liushuis-table").show();
                              $.each(data.liushuis, function (n, value) {
                                   var trs = "";
                                   trs += "<tr><td>" + value.key + "</td> <td>" + value.pay_type + "</td><td>" + value.should_pay_money + "</td><td>" + value.money + "</td><td>" + value.kou + "</td><td>" + value.liushuihao + "</td><td>" + value.created_at + "</td></tr>";
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
        $csrf_field = csrf_field();
        return <<<EOT

<button class="btn btn-sm btn-primary pay" data-paytype="0" data-id="{$this->id}"  
      data-url="$url"  data-toggle="modal" data-target="#grid-modal-pay-{$this->id}">
   现金收款
</button>

<button class="btn btn-sm btn-primary pay" data-paytype="1" data-id="{$this->id}"  
      data-url="$url"  data-toggle="modal" data-target="#grid-modal-pay-{$this->id}">
   转账收款
</button>

<div class="modal fade" id="grid-modal-pay-{$this->id}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">收款</h4>
      </div>
       <div class="modal-body">
        <div style="height:480px;">
            
            <div class="form-group" style="max-height: 150px;overflow: auto;">
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover liushuis-table" style="display: none;">
                        <tr class="head-pay">
                            <th>收款记录</th>  
                            <th>收款方式</th>                                                             
                            <th>应付金额</th>
                            <th>实付金额</th>
                            <th>坐扣</th>                          
                            <th>流水号</th>                          
                            <th>收款时间</th>    
                        </tr>
                    </table>
                </div>
            </div>

            <div class="form-group 1" style="overflow: hidden;">
                <label for="" class="col-sm-2 control-label">未付金额</label>   
                <div class="col-sm-4">                                
                    <div class="input-group">                                           
                         <input type="text" id="not_pay_money{$this->id}"  class="form-control money_paid" disabled >
                    </div>                               
                </div>
           </div>
        <form method="post" action="$form_url">
            <input type="hidden" id="paytype{$this->id}" name="paytype{$this->id}">
            {$csrf_field}    
           <div class="form-group 1" style="overflow: hidden;">
                <label for="" class="col-sm-2 control-label">付款金额</label>   
                <div class="col-sm-4">                                
                    <div class="input-group">                                           
                         <input type="text" name="shi_pay_money{$this->id}" onkeyup="value=value.replace(/[^\d.]/g,'')" class="form-control" placeholder="输入 付款金额">
                    </div>                               
                </div>
           </div>
           <div class="form-group 1" style="overflow: hidden;">
                <label for="" class="col-sm-2 control-label">坐扣</label>   
                <div class="col-sm-4">                                
                    <div class="input-group">                                           
                         <input type="text" name="kou{$this->id}"  onkeyup="value=value.replace(/[^\d.]/g,'')" class="form-control" placeholder="输入 坐扣金额">
                    </div>                               
                </div>
           </div>
           <div class="form-group liushuihao" style="overflow: hidden;">
                <label for="" class="col-sm-2 control-label">流水号</label>   
                <div class="col-sm-4">                                
                    <div class="input-group">                                           
                         <input type="text"  name="liushuihao{$this->id}" value="" class="form-control" placeholder="输入 流水号">
                    </div>                               
                </div>
           </div>
           <div class="box-footer" style="display: block;">
                 <div class="col-sm-2">
                 </div>
                <div class="col-sm-8">
                     <div class="btn-group pull-right">
                     <button type="submit" class="btn btn-info pull-right" data-loading-text="<i class='fa fa-spinner fa-spin '></i> 提交">提交</button>
                </div>
            </div>
        </form>
        </div>
        </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

EOT;
    }

    public function __toString()
    {
        return $this->render();
    }
}