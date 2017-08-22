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

    public function __construct($id)
    {
        $this->id = $id;
    }

    protected function script()
    {
        return <<<SCRIPT

$('.jisuan').on('click', function () {
    
    // Your code.
    console.log($(this).data('id'));
    
});

SCRIPT;
    }

    protected function render()
    {
        \Front::script($this->script());
        return <<<EOT

<button class="btn btn-sm btn-primary jisuan" data-id="{$this->id}"  data-toggle="modal" data-target="#grid-modal-jisuan-{$this->id}">
   处理
</button>

<div class="modal fade" id="grid-modal-jisuan-{$this->id}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">结算</h4>
      </div>
      <div class="modal-body">
        <div style="height:400px;">
            
            <div class="form-group" style="max-height: 150px;overflow: auto;">
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>发放记录</th> 
                            <th>发放方式</th>                                                                                          
                            <th>未发金额</th>
                            <th>应发金额</th>                                                
                            <th>发放时间</th>    
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>1</td>
                            <td>1</td>
                            
                             
                            <td>1233232132</td>
                            <td>1233232132</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>1</td>
                           
                            
                            <td>23213</td>
                            <td>1233232132</td>
                            <td>1233232132</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>1</td>
                            <td>wwww</td>
                            
                           
                            <td>1233232132</td>
                            <td>1233232132</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>1</td>
                          
                            
                            <td>23213</td>
                            <td>1233232132</td>
                            <td>1233232132</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>1</td>
                           
                            
                            <td>23213</td>
                            <td>1233232132</td>
                            <td>1233232132</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>1</td>
                           
                            
                            <td>23213</td>
                            <td>1233232132</td>
                            <td>1233232132</td>
                        </tr>
                        <tr>
                            <td>1</td>
                           
                            
                            <td>23213</td>
                            <td>1233232132</td>
                            <td>1233232132</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>wwww</td>
                            
                            <td>23213</td>
                            <td>1233232132</td>
                            <td>1233232132</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>wwww</td>
                            
                            <td>23213</td>
                            <td>1233232132</td>
                            <td>1233232132</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>wwww</td>
                            
                            <td>23213</td>
                            <td>1233232132</td>
                            <td>1233232132</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>wwww</td>
                            
                            <td>23213</td>
                            <td>1233232132</td>
                            <td>1233232132</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>wwww</td>
                            
                            <td>23213</td>
                            <td>1233232132</td>
                            <td>1233232132</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>wwww</td>
                            
                            <td>23213</td>
                            <td>1233232132</td>
                            <td>1233232132</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <!--<div class="form-group 1" style="overflow: hidden;">-->
                <!--<label for="baoshe_id" class="col-sm-2 control-label">开票信息</label>-->
                    <!--<div class="col-sm-5">-->
                        <!--<select class="form-control baoshe_id " style="" name="baoshe_id">-->
                            <!--<option value="1" selected="">南京大成致远网络技术有限公司(123455778788787878)</option>-->
                            <!--<option value="2">南京大成致远网络技术有限公司(123455778788787878)</option>-->
                        <!--</select>-->
                    <!--</div>-->
            <!--</div>-->
             
            <div class="form-group 1" style="overflow: hidden;">
                <label for="" class="col-sm-2 control-label">未付金额</label>   
                <div class="col-sm-4">                                
                    <div class="input-group">                                           
                         <input type="text" id="money_paid" name="money_paid" value="100￥" class="form-control money_paid" disabled >
                    </div>                               
                </div>
           </div>
           <div class="form-group 1" style="overflow: hidden;">
                <label for="" class="col-sm-2 control-label">发放方式</label>   
                <div class="col-sm-4">                                
                    <div class="input-group">                                           
                         <input type="text" id="money_paid" name="money_paid" value="" class="form-control money_paid" >
                    </div>                               
                </div>
           </div>
           <div class="form-group 1" style="overflow: hidden;">
                <label for="" class="col-sm-2 control-label">实付金额</label>   
                <div class="col-sm-4">                                
                    <div class="input-group">                                           
                         <input type="text" id="money_paid" name="money_paid" value="" class="form-control money_paid" placeholder="输入 已付款金额">
                    </div>                               
                </div>
           </div>
                    
           <div class="box-footer" style="display: block;">

                 <input type="hidden" name="_token" value="p3xhIU1trJ2rcb4JsE8KNEoxjE10UePYs7WVI4Kp">
                 <div class="col-sm-2">

                 </div>
                <div class="col-sm-8">

                     <div class="btn-group pull-right">
                     <button type="submit" class="btn btn-info pull-right" data-loading-text="<i class='fa fa-spinner fa-spin '></i> 提交">提交</button>
                </div>

               

            </div>

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