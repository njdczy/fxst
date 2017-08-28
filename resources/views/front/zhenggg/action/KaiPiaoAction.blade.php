<button class="btn btn-sm btn-primary kaipiao" data-id="{{$id}}"
        data-toggle="modal" data-url="{{$url}}" data-target="#grid-modal-kaipiao-{{$id}}">
    {{$button_name}}
</button>

<div  class="modal fade" id="grid-modal-kaipiao-{{$id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"> {{$button_name}}</h4>
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
                                    <td id="piao_name{{$id}}"></td>
                                    <td id="piao_hao{{$id}}"></td>
                                    <td id="piao_addr{{$id}}"></td>
                                    <td id="piao_phone{{$id}}"></td>
                                    <td id="piao_bank{{$id}}"></td>
                                    <td id="piao_bank_account{{$id}}"></td>
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
                    @if($piao_status !=2)
                    <div class="form-group" style="overflow: hidden;">
                        <label for="" class="col-sm-2 control-label">未开金额</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <input type="text" id="not_kai_money{{$id}}"  value="" class="form-control " disabled >
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($piao_status !=1 && $piao_status !=2)
                    <form id="kaipiao_form{{$id}}" method="post" action="{{$form_url}}" onsubmit="return kaipiao({{$id}})">
                        {{csrf_field()}}
                        <div class="form-group" style="overflow: hidden;">
                            <label for="" class="col-sm-2 control-label">实开金额</label>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text" onkeyup="value=value.replace(/[^\d.]/g,'')"
                                           id="shi_kai_money{{$id}}" name="shi_kai_money{{$id}}"  class="form-control" placeholder="输入 已付款金额">
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="overflow: hidden;">
                            <label for="" class="col-sm-2 control-label">发票号</label>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text"  name="fapiaohao{{$id}}" class="form-control" placeholder="输入 发票号">
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
                            function kaipiao(u_id){
                                var fapiaohao = $("#fapiaohao"+u_id).val();
                                if (!fapiaohao) {
                                    alert('发票号必填');
                                    return false;
                                }
                                var not_kai_money = $("#not_kai_money"+u_id).val();
                                var shi_kai_money = $("#shi_kai_money"+u_id).val()?$("#shi_kai_money"+u_id).val():0;

                                if(parseFloat(shi_kai_money) > parseFloat(not_kai_money) || parseFloat(shi_kai_money) == 0) {
                                    alert('金额不能为0或大于最大金额');
                                    $("#shi_kai_money"+u_id).val('');
                                    return false;
                                } else {
                                    $("#kaipiao_form"+u_id).submit();
                                }
                            }
                        </script>
                    @endif
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>