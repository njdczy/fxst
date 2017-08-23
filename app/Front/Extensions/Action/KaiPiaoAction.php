<?php


namespace App\Front\Extensions\Action;


class KaiPiaoAction
{
    protected $id;
    protected $button_name = '';

    public function __construct($id,$piao_status)
    {
        if ($piao_status == 0){
            $this->button_name = '开票';
        } elseif ($piao_status == 1) {
            $this->button_name = '查看';
        } elseif ($piao_status == 2) {

        } elseif ($piao_status == 3) {
            $this->button_name = '继续开票';
        }
        $this->id = $id;
    }

    protected function script()
    {
        return <<<SCRIPT

$('.kaipiao').on('click', function () {
            var id =  $(this).data('id');
            $(".head-piao").nextAll().remove();
             $.ajax({
                method: 'get',
                url: $(this).data('url'),
                success: function (data) {
                    
                    if (typeof data === 'object') {
                        $("#not_kai_money"+id).val(data.not_kai_money + '￥');
                       
                        $("#piao_name"+id).text(data.customer_piao.name);
                        $("#piao_hao"+id).text(data.customer_piao.hao);
                        $("#piao_addr"+id).text(data.customer_piao.addr);
                        $("#piao_phone"+id).text(data.customer_piao.phone);
                        $("#piao_bank"+id).text(data.customer_piao.bank);
                        $("#piao_bank_account"+id).text(data.customer_piao.bank_account);
                                                                
                        if ( !$.isEmptyObject(data.fapiaos) ) {
                              
                              $(".kaipiaolog-table").show();
                              $.each(data.fapiaos, function (n, value) {
                                   var trs = "";
                                   trs += "<tr><td>" + value.key + "</td> <td>" + value.should_kai_money + "</td><td>" + value.kai_money + "</td><td>" + value.haoma + "</td><td>" + value.created_at + "</td></tr>";
                                   $(trs).insertAfter($('.head-piao'));
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
        $url = \Front::url('/finance/fapiao/getdetail/'.$this->id);
        $form_url = \Front::url('/finance/fapiao/setdetail/'.$this->id);
        $csrf_field = csrf_field();
        return <<<EOT

<button class="btn btn-sm btn-primary kaipiao" data-id="{$this->id}"  
    data-toggle="modal" data-url="$url" data-target="#grid-modal-kaipiao-{$this->id}">
   {$this->button_name}
</button>

<div  class="modal fade" id="grid-modal-kaipiao-{$this->id}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width: 1000px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">{$this->button_name}</h4>
      </div>
      <div class="modal-body">
        <div style="height:480px;">
            <div class="form-group">
                <h3 style="text-align:center;">开票信息</h3>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">                        
                            <tr>
                                <th>名称</th>
                                <th>纳税人识别号</th>
                                <th>地址</th>
                                <th>电话</th>
                                <th>开户行</th>
                                <th>账号</th>
                            </tr>
                            <tr>
                                <td id="piao_name{$this->id}"></td>
                                <td id="piao_hao{$this->id}"></td>
                                <td id="piao_addr{$this->id}"></td>
                                <td id="piao_phone{$this->id}"></td>
                                <td id="piao_bank{$this->id}"></td>
                                <td id="piao_bank_account{$this->id}"></td>
                            </tr> 
                    </table>
                </div>
            </div>
            <div class="form-group" style="max-height: 150px;overflow: auto;">
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover kaipiaolog-table" style="display: none;">
                        <tr class="head-piao">
                            <th>开票记录</th>                                                        
                            <th>应开金额</th>
                            <th>实开金额</th>
                            <th>发票号码</th>                          
                            <th>开票时间</th>    
                        </tr>                     
                    </table>
                </div>
            </div>
            <div class="form-group" style="overflow: hidden;">
                <label for="" class="col-sm-2 control-label">未开金额</label>   
                <div class="col-sm-4">                                
                    <div class="input-group">                                           
                         <input type="text" id="not_kai_money{$this->id}"  value="" class="form-control " disabled >
                    </div>                               
                </div>
           </div>
        <form method="post" action="$form_url">
            {$csrf_field} 
           <div class="form-group" style="overflow: hidden;">
                <label for="" class="col-sm-2 control-label">实开金额</label>   
                <div class="col-sm-4">                                
                    <div class="input-group">                                           
                         <input type="text" onkeyup="value=value.replace(/[^\d.]/g,'')" name="shi_kai_money{$this->id}" class="form-control" placeholder="输入 已付款金额">
                    </div>                               
                </div>
           </div>
           <div class="form-group" style="overflow: hidden;">
                <label for="" class="col-sm-2 control-label">发票号</label>   
                <div class="col-sm-4">                                
                    <div class="input-group">                                           
                         <input type="text"  name="fapiaohao{$this->id}" class="form-control" placeholder="输入 发票号">
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