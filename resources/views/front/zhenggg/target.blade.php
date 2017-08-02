<div class="box">
    <div class="box-header">
        <h3 class="box-title"><strong>江苏经济报</strong>(目标时间段：2017-08-02--2017-08-03)</h3>
        <div class="pull-right">
            <div class="btn-group pull-right" style="margin-right: 10px">
                <a href="/front/system/baoshe/create" class="btn btn-sm btn-success">
                    <i class="fa fa-save"></i>&nbsp;&nbsp;修改
                </a>
            </div>
        </div>
    </div>
    <!-- /.box-header -->
    <style>
        .one,.second,.three,.fourth,.fifth{
            border:1px solid transparent!important;
            border-top:1px solid transparent!important;
            padding:0!important;
        }

        .one div{
            border-top:1px solid darkgrey!important;
            border: 1px solid darkgrey;
            padding:8px;
        }
        .second div,.three div,.fourth div,.fifth div{
            border-top:1px solid darkgrey!important;
            border: 1px solid darkgrey;
            padding:8px;
            margin-left: 35px;
        }
        .second div{
            margin-top: -1.4px;
        }
        .three div{
            margin-left: 75px;
            margin-top: -1.4px;
        }
        .fourth div{
            margin-left: 115px;
            margin-top: -1.4px;
        }
        .fifth div{
            margin-left: 155px;
            margin-top: -1.4px;
        }
    </style>
    <div class="box-body" style="display: block;">
        <table class="table">
            <thead><tr>
                <th>部门级别</th>
                <th>目标数</th>
                <th>已完成</th>
                <th>目标完成进度</th>
                <th>完成详情</th>
                <th>操作</th>
            </tr></thead>
            <tbody>
            <tr>
                <td class="one"><div>总目标</div></td>
                <td>1000</td>
                <td>500</td>
                <td>
                    <div class="progress progress-sm" style="width: 80%;display: inline-block;">
                        <div class="progress-bar primary" role="progressbar" aria-valuenow="500" aria-valuemin="0" aria-valuemax="1000" style="width: 50%">
                        </div>
                    </div>
                    <span style="float: right;">100%</span>
                </td>
                <td><a href="baidu.com">点击查看</a></td>
                <td>
                    <a href="/front/target/1/edit/" style="padding-right: 1.5rem;"><i class="fa fa-edit"></i></a>
                    <a href="javascript:void(0);" data-url="/front/target/1" data-id="1" class="grid-row-delete"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            <tr>
                <td class="second"><div>江苏经济报社</div></td>
                <td>1000</td>
                <td>500</td>
                <td><div class="progress progress-sm">
                        <div class="progress-bar $style" role="progressbar" aria-valuenow="500" aria-valuemin="0" aria-valuemax="1000" style="width: 50%">
                            <span class="sr-only">500</span>
                        </div>
                    </div></td>
                <td><a href="baidu.com">点击查看</a></td>
                <td>
                    <a href="/front/target/1/edit/" style="padding-right: 1.5rem;"><i class="fa fa-edit"></i></a>
                    <a href="javascript:void(0);" data-url="/front/target/1" data-id="1" class="grid-row-delete"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            <tr>
                <td class="three"><div>人事部（江苏经济报社）</div></td>
                <td>4</td>
                <td>25</td>
                <td><a href="baidu.com">点击查看</a></td>
                <td>
                    <a href="/front/target/1/edit/" style="padding-right: 1.5rem;"><i class="fa fa-edit"></i></a>
                    <a href="javascript:void(0);" data-url="/front/target/1" data-id="1" class="grid-row-delete"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            <tr>
                <td class="fourth"><div>人事（江苏经济报社-人事部）</div></td>
                <td>4</td>
                <td>25</td>
                <td><a href="baidu.com">点击查看</a></td>
                <td>
                    <a href="/front/target/1/edit/" style="padding-right: 1.5rem;"><i class="fa fa-edit"></i></a>
                    <a href="javascript:void(0);" data-url="/front/target/1" data-id="1" class="grid-row-delete"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            <tr>
                <td class="fifth"><div>人事-1（江苏经济报社-人事部-人事）</div></td>
                <td>4</td>
                <td>25</td>
                <td><a href="baidu.com">点击查看</a></td>
                <td>
                    <a href="/front/target/1/edit/" style="padding-right: 1.5rem;"><i class="fa fa-edit"></i></a>
                    <a href="javascript:void(0);" data-url="/front/target/1" data-id="1" class="grid-row-delete"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <!-- /.box-body -->
</div>
<script>
    $('.grid-row-delete').unbind('click').click(function() {
        if(confirm("该目标已完成的的数量将无法关联到之后添加的目标，确定要删除目标吗？")) {
            $.ajax({
                method: 'post',
                url: $(this).data('url'),
                data: {
                    _method:'delete',
                    _token:LA.token,
                },
                success: function (data) {
                    $.pjax.reload('#pjax-container');

                    if (typeof data === 'object') {
                        if (data.status) {
                            toastr.success(data.message);
                        } else {
                            toastr.error(data.message);
                        }
                    }
                }
            });
        }
    });
</script>