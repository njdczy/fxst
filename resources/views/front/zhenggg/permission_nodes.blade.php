<style>

    .checkbox .boxx h3 {
        text-align: right;
        width: 14%;
        padding-right: 2%;
        font-size: 12px;
        line-height: 24px;
    }

    .checkbox .boxx {
        border-top: none;
    }

    .checklist {
        line-height: 20px;
        display: block;
        min-height: 20px;
        padding: 0px 0 0px 0;
        border-bottom: dotted 1px #CCC;
    }

    .checklist .set {
        width: 18%;
        font-size: 10px;
        font-weight: normal;
        color: #777;
        text-align: left;
        vertical-align: top;
        display: inline-block;
        margin-right: 0%;
    }

    .checklist .set input {
        min-height: 22px !important;
    }

    .checklist ul {
        font-size: 0;
        vertical-align: top;
        display: inline-block;
        width: 81%;
        padding-left: 1%;
        border-left: dotted 1px #CCC;
    }

    .checklist ul li {
        width: 100px;
        height: 20px;
        display: inline-block;
        font-size: 11px;
        line-height: 24px;
        color: #999;
        vertical-align: top;
        letter-spacing: normal;
        word-spacing: normal;
        margin-bottom: 5px;
    }
    .checklist ul li label{
        position: relative;
        margin-top: 5px;

    }
    .checklist ul li input {
        position: relative;
        margin-top: 1px;
        min-height: 22px !important;
    }
</style>
<div class="checkbox checks form-group 1">

    <label for="" class="col-sm-2 control-label" style="font-weight: 700;">权限分配</label>

    <div class="col-sm-8 boxx " >
        <section class="checklist">
            <div class="set">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" onclick="checkAll('.checklist ul li input','.left');"> 全选&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </label>
                </div>
            </div>

        </section>
        @foreach($nodes as $key => $node)
            <section class="checklist">
                <div class="set">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" class="left"
                                   onclick="checkAll('.{{$key}} li input',' ')"> {{$node['name']}}
                        </label>
                    </div>
                </div>
                <ul class="cont {{$key}}">
                    @if(isset($node['child']) && is_array($node['child']))
                        @foreach ($node['child'] as $node_child)
                            <li>
                                <label>
                                    <input type="checkbox" name="permissions[]"
                                           value="{{$node_child['id']}}">
                                    {{$node_child['name']}}
                                </label>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </section>
        @endforeach
    </div>
</div>

<script>
    var chkall = true;
    function checkAll(eles1, eles2) {
        $(eles1).prop("checked", chkall);
        $(eles2).prop("checked", chkall);
        chkall = !chkall;
    }
</script>