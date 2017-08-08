<style>
    .deviation0,.deviation1,.deviation2,.deviation3,.deviation4{
        border:1px solid transparent!important;
        border-top:1px solid transparent!important;
        padding:0!important;
    }

    .deviation0 div{
        border-top:1px solid darkgrey!important;
        border: 1px solid darkgrey;
        padding:8px;
    }
    .deviation1 div,.deviation2 div,.deviation3 div,.deviation4 div{
        border-top:1px solid darkgrey!important;
        border: 1px solid darkgrey;
        padding:8px;
        margin-left: 35px;
    }
    .deviation1 div{
        margin-top: -1.4px;
    }
    .deviation2 div{
        margin-left: 75px;
        margin-top: -1.4px;
    }
    .deviation3 div{
        margin-left: 115px;
        margin-top: -1.4px;
    }
    .deviation4 div{
        margin-left: 155px;
        margin-top: -1.4px;
    }
</style>
@foreach($p_targets as $p_target)
<div class="box">
    <div class="box-header" style="text-align: center;">
        <h3 class="box-title"><strong>{{$p_target->first()->periodical->name}}</strong>
        </h3>
    </div>
    @foreach($p_target as $target)
    <div class="box-header">
        <div class="pull-left">
            <p> 目标时间段：{{ \Carbon::parse($target->s_time)->format('Y-m-d')  }} -- {{ \Carbon::parse($target->e_time)->format('Y-m-d')  }}</p>
        </div>
        <div class="btn-group pull-right" style="margin-right: 10px">
            <a href="{{url(\Front::url('target').'/'.$target->id.'/targetd/create')}}" class="btn btn-sm btn-success">
                <i class="fa fa-save"></i>&nbsp;&nbsp;新增子目标
            </a>
        </div>
        {{--<div class="btn-group pull-right" style="margin-right: 10px">--}}
            {{--<a href="/front/target/{{$target->id}}/edit"  class="btn btn-sm btn-twitter">--}}
                {{--<i class="fa fa-edit"></i>&nbsp;&nbsp;修改主目标--}}
            {{--</a>--}}
        {{--</div>--}}
    </div>

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
                <td class="deviation0"><div>总目标</div></td>
                <td>{{$target->num}}</td>
                <td>{{$target->numed}}</td>
                <td>
                    <div class="progress progress-sm" style="width: 80%;display: inline-block;">
                        <div class="progress-bar primary" role="progressbar" aria-valuenow="{{$target->numed}}"
                             aria-valuemin="0" aria-valuemax="{{$target->num}}" style="width:{{$target->numed/$target->num*100}}%">
                        </div>
                    </div>
                    <span style="float: right;">{{$target->numed/$target->num*100}}%</span>
                </td>
                <td><a href="{{url(\Front::url('finance/input').'/?pay_status=1')}}">点击查看</a></td>
                <td>
                    <a href="{{url(\Front::url('target').'/'.$target->id.'/edit')}}">
                        <i class="fa fa-edit"></i>
                    </a>
                    <a href="javascript:void(0);" data-url="{{url(\Front::url('target').'/'.$target->id)}}" class="grid-row-delete" >
                        <i class="fa fa-trash"></i>
                    </a>
                </td>
            </tr>
        @foreach($trees[$loop->index] as $tree)
            <tr>
                <td class="deviation{{$tree['depth']}}"><div>{{$tree['d_name']}}</div></td>
                <td>{{$tree['num']}}</td>
                <td>{{$tree['numed']}}</td>
                <td>
                    <div class="progress progress-sm" style="width: 80%;display: inline-block;">
                        <div class="progress-bar primary" role="progressbar" aria-valuenow="{{$tree['numed']}}"
                             aria-valuemin="0" aria-valuemax="{{$tree['num']}}" style="width: {{$tree['numed']/$tree['num']*100}}%">
                        </div>
                    </div>
                    <span style="float: right;">{{$tree['numed']/$tree['num']*100}}%</span>
                </td>
                <td><a href="{{url(\Front::url('target').'/'.$target->id.'/targetd/'.$tree["id"].'/targetm')}}">点击查看</a></td>
                <td>
                    <a href="{{url(\Front::url('target').'/'.$target->id.'/targetd/'.$tree["id"].'/edit/')}}">
                        <i class="fa fa-edit"></i>
                    </a>
                    <a href="javascript:void(0);" data-url="{{url(\Front::url('target').'/'.$target->id.'/targetd/'.$tree["id"].'/')}}" class="grid-row-delete" >
                        <i class="fa fa-trash"></i>
                    </a>
                </td>
            </tr>
        @endforeach
            </tbody>
        </table>
    </div>
        <hr />
    @endforeach
</div>
@endforeach
<script>
    $('.grid-row-delete').unbind('click').click(function() {
        if(confirm("该目标已完成的数量将无法关联到之后添加的目标，且如果该目标的有子目标，子目标也会被删除，确定要删除目标吗？")) {
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