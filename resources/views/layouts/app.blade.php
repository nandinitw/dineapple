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
  <link rel="stylesheet" href="{{{ URL::asset('css/select2.css')}}}">

    
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
    var APP_URL = {!! json_encode(url('/')) !!}    
</script>
    <script src="{{ url ('js/jquery.form.js') }}"></script>
        
<!--tokenise js-->
<link rel="stylesheet" href="{{ url ('/css/bootstrap-tokenfield.min.css') }}">
<link rel="stylesheet" href="{{ url ('/css/tokenfield-typeahead.min.css') }}">
<script src="{{ url ('/js/bootstrap-tokenfield.min.js') }}"></script>
<!--tokenise js-->

<link rel="stylesheet" href="{{ url ('/css/style.css') }}">
</head>
<body class="skin-blue">
<div class="wrapper">

    <!-- Header -->
    @include('common.header')
    
    <!-- =============================================== -->
    
    <!-- Left side column. contains the sidebar -->
    @include('common.sidebar') 
    
     <div class="content-wrapper" style="height: 100%; min-height: 600px;">
        <section class="content-header">
          <h1>
            @yield('header')
          </h1>
            <div class="row">
                <div class="col-md-12 mt-2">
                    @include('common.flash-message')    
                </div>                
            </div>
                
        </section>
        <section class="content">
            @yield('content')   
        </section>
     </div>
         
    <!-- =============================================== -->

    <!-- Footer -->
    @include('common.footer')

</div><!-- ./wrapper -->

<!-- Bootstrap 3.3.7 -->
<script src="{{{ URL::asset('AdminLTE/bower_components/bootstrap/js/bootstrap.min.js')}}}"></script>
<!-- SlimScroll -->
<script src="{{{ URL::asset('AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}}"></script>
<!-- FastClick -->
<script src="{{{ URL::asset('AdminLTE/bower_components/fastclick/lib/fastclick.js')}}}"></script>
<!-- AdminLTE App -->
<script src="{{{ URL::asset('AdminLTE/dist/js/adminlte.min.js')}}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{{ URL::asset('plugins/choosen/chosen.jquery.min.js')}}}" type="text/javascript"></script>
<!-- AdminLTE App -->

<script src="{{ URL::asset('AdminLTE/custom.js')}}"></script>

<!-- AdminLTE for demo purposes -->
<!--<script src="{{{ URL::asset('js/demo.js')}}}"></script>-->
<script src="{{{ URL::asset('AdminLTE/app.min.js')}}}"></script>
<script src="{{{ URL::asset('js/select2.js')}}}"></script>

<script src="{{ url ('/js/script.js') }}"></script>
<style>
    .action-btns{
        height:35px;
        margin:10px 0;
    }
</style>
 
    
</body>
</html>