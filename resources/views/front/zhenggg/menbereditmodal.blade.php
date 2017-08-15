<div class="modal fade" id="menberedit-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">修改比例</h4>
            </div>
            <form action="{{\Front::url('editper')}}" method="post" pjax-container>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="per" class="col-sm-2 control-label per-label"></label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <div class="input-group">

                                    <input style="width: 100px; text-align: center;" type="number" id="per" name="per"
                                           value="" class="form-control num initialized"
                                           placeholder="输入 比例">
                                    <input type="hidden" name="menber_id"/>
                                    <input type="hidden" name="p_id"/>
                                    <input type="hidden" name="type"/>
                                    {{ csrf_field() }}
                                </div>
                                <span class="help-block">
                                        <i class="fa fa-info-circle"></i>&nbsp;输入比例
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary submit">{{ trans('front::lang.submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function setdata(p_name,time_type,menber_id,p_id,per,type) {
        var text = p_name + '(' + time_type + ')';
        $('.per-label').text(text);
        $("input[name=type]").val(type);
        $("input[name=menber_id]").val(menber_id);
        $("input[name=p_id]").val(p_id);
        $("input[name=per]").val(per);
    }
</script>