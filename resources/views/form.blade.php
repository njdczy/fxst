<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/css/reset.css"/>
    <link rel="stylesheet" type="text/css" href="/css/style.css"/>
    <link rel="stylesheet" type="text/css" href="/css/scs.min.css"/>
    <title></title>
</head>
<body>
<div class="container">
    <div class="col-xs-4 logo"></div>
    <section class="main-body">
        <div class="tab-btn">
            <div class="btn-left active">个人订购</div>
            <div class="btn-right">企业订购</div>
        </div>
        <!--个人订购-->
        <div class="main-form person" style="display: block;">
            <!--个人订购-基本信息-->
            <div class="one " style="display: block;">
                <div class="step-one"></div>
                <form method="post" action="/formg/{{ $u_id  }}" name="person" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name" class="col-sm-2 col-xs-4 control-label">姓名<span>*</span></label>
                        <div class="col-sm-7 col-xs-7">
                            <input type="text" name="name" class="form-control" id="name" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tel" class="col-sm-2 col-xs-4 control-label">电话<span>*</span></label>
                        <div class="col-sm-7 col-xs-7">
                            <input type="tel" onkeyup="value=value.replace(/[^\d.]/g,'')" name="mobile" class="form-control" id="tel" placeholder="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-2 col-xs-4 control-label">选择报纸<span>*</span></label>
                        <div class="col-sm-7 col-xs-7">
                            <select class="form-control select-box" name="baozi">
                                @foreach ($p as $pp)
                                    <option value="{{ $pp->id }}">{{ $pp->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nums" class="col-sm-2 col-xs-4 control-label">填写份数<span>*</span></label>
                        <div class="col-sm-7 col-xs-7">
                            <input type="number" name="num" class="form-control" id="nums" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nums" class="col-sm-2 col-xs-4 control-label">选择订阅时长<span>*</span></label>
                        <div class="col-sm-7 col-xs-7">
                            <select class="form-control select-box" name="input_type">

                                <option value="m">月</option>
                                <option value="j">季</option>
                                <option value="b">半年</option>
                                <option value="y" selected >一年</option>

                            </select>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="nums" class="col-sm-2 col-xs-4 control-label">是否开票<span>*</span></label>
                        <div class="col-sm-7 col-xs-7">
                            <select class="form-control select-box" name="piao_status">
                                <option value="2" selected>否</option>
                                <option value="0">是</option>

                            </select>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="city-picker2" class="col-sm-2 col-xs-4 control-label">省/市/区<span>*</span></label>
                        <div class="col-sm-7 col-xs-7">

                            <input type="text" class="form-control" readonly placeholder="选择城市" id="myAddrs" name="region" data-key="" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="details" class="col-sm-2 col-xs-4 control-label">详细地址<span>*</span></label>
                        <div class="col-sm-7 col-xs-7">
                            <input type="text" name="address" class="form-control" id="address" placeholder="">
                        </div>
                    </div>



                    <input type="submit" name="" id="" value="提交" class="next"/>
                </form>
                <!--<a href="javascript:0;" class="next col-xs-2">下一步</a>-->
            </div>
        </div>
        <!--企业订购-->
        <div class="main-form company" style="display: none;">
            <div class="company-one" style="display: block;">
                <div class="step-one"></div>
                <form method="post" action="/formq/{{ $u_id }}" name="danwei" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="company-name" class="col-sm-2 col-xs-4 control-label">单位名称<span>*</span></label>
                        <div class="col-sm-7 col-xs-7">
                            <input type="text" name="name"  class="form-control" id="company-name" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="contacts" class="col-sm-2 col-xs-4 control-label">联系人<span>*</span></label>
                        <div class="col-sm-7 col-xs-7">
                            <input type="text" name="contacts" class="form-control" id="contacts" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tel" class="col-sm-2 col-xs-4 control-label">电话<span>*</span></label>
                        <div class="col-sm-7 col-xs-7">
                            <input type="tel" onkeyup="value=value.replace(/[^\d.]/g,'')" name="mobile" class="form-control" id="tel" placeholder="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tel" class="col-sm-2 col-xs-4 control-label">选择报纸<span>*</span></label>
                        <div class="col-sm-7 col-xs-7">
                            <select class="form-control select-box" name="baozi">
                                @foreach ($p as $pp)
                                    <option value="{{ $pp->id }}">{{ $pp->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nums" class="col-sm-2 col-xs-4 control-label">填写份数<span>*</span></label>
                        <div class="col-sm-7 col-xs-7">
                            <input type="number"  name="num" class="form-control" id="nums" placeholder="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nums" class="col-sm-2 col-xs-4 control-label">选择订阅时长<span>*</span></label>
                        <div class="col-sm-7 col-xs-7">
                            <select class="form-control select-box" name="input_type">

                                <option value="m">月</option>
                                <option value="j">季</option>
                                <option value="b">半年</option>
                                <option value="y" selected >一年</option>

                            </select>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="nums" class="col-sm-2 col-xs-4 control-label">是否开票<span>*</span></label>
                        <div class="col-sm-7 col-xs-7">
                            <select class="form-control select-box" name="piao_status">
                                <option value="2" selected>否</option>
                                <option value="0">是</option>

                            </select>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="city-picker2" class="col-sm-2 col-xs-4 control-label">省/市/区<span>*</span></label>
                        <div class="col-sm-7 col-xs-7">
                            <input type="text" class="form-control" readonly placeholder="选择城市" id="myAddrss" name="region" data-key="" value="" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address" class="col-sm-2 col-xs-4 control-label">详细地址<span>*</span></label>
                        <div class="col-sm-7 col-xs-7">
                            <input type="text" name="address" class="form-control" id="address" placeholder="">
                        </div>
                    </div>

                    <input type="submit" name="" id="" value="提交" class="next"/>
                </form>

            </div>
        </div>
    </section>

</div>
</body>
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<script src="/js/CNAddrArr.min.js"></script>
<script src="/js/jquery.scs.min.js"></script>
<script src="/js/city.js"></script>
<script type="text/javascript">
    //地址选择

    //个人订购-下一步
    $('.prev').on('click',function(){
        $('.one').css('display','block');
        $('.two').css('display','none');
    });
//    //个人订购-上一步
//    $('.next').on('click',function(){
//        $('.one').css('display','none');
//        $('.two').css('display','block');
//
//    });
    //个人订购-切换
    $('.btn-left').on('click',function(){
        $('.person').css('display','block');
        $('.company').css('display','none');
        $('.btn-left').addClass('active');
        $('.btn-right').removeClass('company-active');
    });
    //企业订购-切换
    $('.btn-right').on('click',function(){
        $('.company').css('display','block');
        $('.person').css('display','none');
        $('.btn-left').removeClass('active');
        $('.btn-right').addClass('company-active');
    });
</script>
</html>
