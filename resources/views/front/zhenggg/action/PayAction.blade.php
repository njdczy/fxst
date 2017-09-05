<button class="btn btn-sm btn-primary " id="pay{{$id}}" data-paytype="0" data-id="{{$id}}"
        data-url="{{$url}}"  data-toggle="modal" data-target="#grid-modal-pay-{{$id}}">
    现金收款
</button>

<button class="btn btn-sm btn-primary" id="pay{{$id}}" data-paytype="1" data-id="{{$id}}"
        data-url="{{$url}}"  data-toggle="modal" data-target="#grid-modal-pay-{{$id}}">
    转账收款
</button>

<div class="modal fade" id="grid-modal-pay-{{$id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                <input type="text" id="not_pay_money{{$id}}"  class="form-control money_paid" disabled >
                            </div>
                        </div>
                    </div>
                    @if($pay_status !=1)
                    <form id="payform{{$id}}" method="post" action="{{$form_url}}" onsubmit="return pay({{$id}})">
                        <input type="hidden" id="paytype{{$id}}" name="paytype{{$id}}">
                        {{csrf_field()}}
                        <div class="form-group 1" style="overflow: hidden;">
                            <label for="" class="col-sm-2 control-label">付款金额</label>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text" name="shi_pay_money{{$id}}" id="shi_pay_money{{$id}}"
                                           onkeyup="value=value.replace(/[^\d.]/g,'')" class="form-control" placeholder="输入 付款金额">
                                </div>
                            </div>
                        </div>
                        <div class="form-group 1" style="overflow: hidden;">
                            <label for="" class="col-sm-2 control-label">坐扣</label>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text" name="kou{{$id}}"  id="kou{{$id}}"
                                           onkeyup="value=value.replace(/[^\d.]/g,'')" class="form-control" placeholder="输入 坐扣金额">
                                </div>
                            </div>
                        </div>
                        <div class="form-group liushuihao" style="overflow: hidden;">
                            <label for="" class="col-sm-2 control-label">流水号</label>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text"  name="liushuihao{{$id}}" value="" class="form-control" placeholder="输入 流水号">
                                </div>
                            </div>
                        </div>
                        <div class="form-group 1">
                            <label for="shou_time" class="col-sm-2 control-label">收款时间</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input style="width: 110px;float: left;" type="text" class="shou_time" id="shou_time{{$id}}" name="shou_time{{$id}}" value="" class="form-control shou_time" placeholder="输入 收款时间">
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
                        </div>
                    </form>
                        <script>
                            $(".liushuis-table").on('click','.grid-editable-liushuis',function () {
                                $('.grid-editable-liushuis').editable({
                                    emptytext: '',
                                    error: function(response, data) {
                                        if(response.status == '422') return response.responseJSON.value[0]; //msg will be shown in editable form
                                    }
                                });
                            });
                            function pay(u_id){
                                var not_pay_money = $("#not_pay_money"+u_id).val();
                                var shi_pay_money = $("#shi_pay_money"+u_id).val()?$("#shi_pay_money"+u_id).val():0;
                                var kou = $("#kou"+u_id).val()?$("#kou"+u_id).val():0;

                                if (!$("#shou_time"+u_id).val()) {
                                    alert('输入收款时间');
                                    return false;
                                }
                                if((parseFloat(shi_pay_money) + parseFloat(kou)) > not_pay_money || parseFloat(shi_pay_money) == 0) {
                                    alert('金额不能为0或大于最大金额');
                                    $("#shi_pay_money"+u_id).val('');
                                    $("#kou"+u_id).val('');
                                    return false;
                                } else {
                                    $("#payform"+u_id).submit();
                                }
                            }
                        </script>
                        <script data-exec-on-popstate>
                            $(function () {
                                $('.shou_time').datetimepicker({'format':'YYYY-MM-DD','locale':'zh-CN'});
                            });
                        </script>
                    @endif
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>