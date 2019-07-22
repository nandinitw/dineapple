<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
   <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  
  <title>{{ config('app.name') }} | Admin area</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{{ URL::asset('AdminLTE/bower_components/bootstrap/css/bootstrap.min.css')}}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{{ URL::asset('AdminLTE/bower_components/font-awesome/css/font-awesome.min.css')}}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{{ URL::asset('AdminLTE/bower_components/Ionicons/css/ionicons.min.css')}}}">
  <link rel="stylesheet" href="{{{ URL::asset('plugins/editor/summernote-bs4.css')}}}">
  <link rel="stylesheet" href="{{{ URL::asset('plugins/jQueryUI/jquery-ui.min.css')}}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{{ URL::asset('AdminLTE/dist/css/AdminLTE.min.css')}}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{{ URL::asset('AdminLTE/dist/css/skins/_all-skins.min.css')}}}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <script src="{{{ URL::asset('plugins/jQuery/jquery.min.js')}}}" type="text/javascript"></script>
  <!-- jQuery 3 -->
  <script src="{{{ URL::asset('plugins/jQueryUI/jquery-ui.min.js')}}}" type="text/javascript"></script>
  <script src="{{{ URL::asset('plugins/ajaxform/jquery.form.js')}}}" type="text/javascript"></script>
  
  <script src="{{{ URL::asset('plugins/editor/summernote-bs4.min.js')}}}" type="text/javascript"></script>
  
<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>DINE</b>Apple</a>
        <img width="100" src="{{ url('logo.png') }}">
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg"></p>

    <form method="POST" action="{{ route('login') }}">
     @csrf
     
      <div class="form-group has-feedback">
        <input id="email" placeholder="email" type="Email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
         <input id="password" type="password" placeholder="Password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>        
      </div>
      <div class="row">
        <div class="col-xs-8">
          <?php          
            /*<div class="checkbox icheck">          
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                
                <label class="form-check-label" for="remember">
                    {{ __('Remember Me') }}
                </label>
          </div>
          */ ?>          
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

 

  @if (Route::has('password.request'))
     <a class="btn btn-link" href="{{ route('password.request') }}">
        {{ __('Forgot Your Password?') }}
    </a> 
@endif
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->


<!-- jQuery 3 -->
<script src="{{ asset ("/bower_components/jquery/dist/jquery.min.js") }}"></script>
<!-- jQuery UI 1.11.4 -->

<script src="{{ asset ("/bower_components/jquery-ui/jquery-ui.min.js") }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

<!-- iCheck -->
<script src="{{ asset ("/plugins/iCheck/icheck.min.js") }}"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
