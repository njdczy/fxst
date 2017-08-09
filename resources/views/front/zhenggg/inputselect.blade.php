<script>
    var selectp = {
        getData: function () {
            var url = '{{\Front::url('selectp')}}';
            var p_id = $('.p_id').val();
            $.ajax({
                method: 'get',
                url: url,
                data: {
                    p_id: p_id,
                },
                success: function (data) {
                    if (typeof data === 'object') {
                        $('.selectp').remove();
                        var html = '<div class="form-group selectp" ><label class="col-sm-2 control-label">单价</label><div class="col-sm-2"><div class="box box-solid box-default no-margin"> <!-- /.box-header --> <div class="box-body"> ' + data.c_price + ' </div><!-- /.box-body --> </div> </div> </div>';
                        $(html).insertAfter($("#tab-form-2 .form-group").first());
                    }
                }
            });
        }
    }
    $('.p_id').change(function () {
        selectp.getData();
    });

    $(function () {
        selectp.getData();
    });


</script>