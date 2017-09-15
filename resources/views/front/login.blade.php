<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{config('front.title')}} | {{ trans('front::lang.login') }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="{{ asset("/packages/front/AdminLTE/bootstrap/css/bootstrap.min.css") }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset("/packages/front/font-awesome/css/font-awesome.min.css") }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset("/packages/front/AdminLTE/dist/css/AdminLTE.min.css") }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset("/packages/front/AdminLTE/plugins/iCheck/square/blue.css") }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style>
      .login-bg{
        background: url("/img/background-img.png") 0 0 no-repeat;
        background-size:cover;
      }
      .login-box{
        margin-top: 15%;
      }
      .login-logo{
        border-bottom: 1px solid #dcdcdc;
        padding-bottom: 15px;
      }
      .login-logo a{
        color: #fff;
      }
      .login-logo a b{
        font-weight:normal;
        font-size: 24px;
      }
      .login-box-body{
        background: none;
        padding: 0;
      }
      .login-box-body input{
        background: none;
        -webkit-border-radius:;
        -moz-border-radius:;
        border-radius:5px;
        height:45px;
      }
  </style>
</head>
<body class="hold-transition login-page login-bg">
<div class="login-box">
  <div class="login-logo">
    <a href="{{ Front::url('/') }}"><b>{{config('front.name')}}</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg" style="display: none">{{ trans('front::lang.login') }}</p>

    <form action="{{ Front::url('auth/login') }}" method="post">
      <div class="form-group has-feedback {!! !$errors->has('admin_account') ?: 'has-error' !!}">

        @if($errors->has('admin_account'))
          @foreach($errors->get('admin_account') as $message)
            <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>{{$message}}</label></br>
          @endforeach
        @endif

        <input type="input" class="form-control" placeholder="{{ trans('front::lang.admin_account') }}" name="admin_account" value="{{ old('admin_account') }}">
        {{--<span class="glyphicon glyphicon-envelope form-control-feedback"></span>--}}
      </div>
      <div class="form-group has-feedback {!! !$errors->has('password') ?: 'has-error' !!}">

        @if($errors->has('password'))
          @foreach($errors->get('password') as $message)
            <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>{{$message}}</label></br>
          @endforeach
        @endif

        <input type="password" class="form-control" placeholder="{{ trans('front::lang.password') }}" name="password" value="{{ old('admin_account') }}">
        {{--<span class="glyphicon glyphicon-lock form-control-feedback"></span>--}}
      </div>


      <div class="form-group has-feedback {!! !$errors->has('captcha') ?: 'has-error' !!} col-md-8 col-xs-8" style="margin-left: -14px">

        @if($errors->has('captcha'))
          @foreach($errors->get('captcha') as $message)
            <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>{{$message}}</label></br>
          @endforeach
        @endif
        <input type="input" class="form-control" name="captcha" placeholder="{{ trans('front::lang.captcha') }}">

      </div>
      <p class="col-md-4 col-xs-4" style="padding-top: 4px">{!! captcha_img() !!}</p>
      <div class="row" >

        <!-- /.col -->
        <div class="col-xs-12 col-md-12" style="padding-top: 12px;">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="submit" class="btn btn-danger btn-block btn-flat" style="font-size: 16px;height: 45px;border-radius: 5px;">{{ trans('front::lang.login') }}</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.1.4 -->
<script src="{{ asset("/packages/front/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js")}} "></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{ asset("/packages/front/AdminLTE/bootstrap/js/bootstrap.min.js")}}"></script>
<!-- iCheck -->
<script src="{{ asset("/packages/front/AdminLTE/plugins/iCheck/icheck.min.js")}}"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
