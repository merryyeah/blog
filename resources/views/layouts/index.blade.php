<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <title>Cna.com</title>
    <link href="{{URL::asset('css/bootstrap.min.css?')}}{{Config::get('tsConst.cssGlobal')}}" rel="stylesheet">
    <link href="{{URL::asset('css/jquery.datetimepicker.css?')}}{{Config::get('tsConst.cssGlobal')}}" rel="stylesheet">
{{--    <link href="{{URL::asset('css/app.css?')}}{{Config::get('tsConst.cssGlobal')}}" rel="stylesheet">--}}
    <link href="{{URL::asset('css/zc.pagination.css?')}}{{Config::get('tsConst.cssGlobal')}}" rel="stylesheet">
    <link href="{{URL::asset('css/style.css?')}}{{Config::get('tsConst.cssStyle')}}" rel="stylesheet">
</head>
<body>
<div class="scrollbar">
    @section('content')
    @show
</div>

<script src="{{URL::asset('js/jquery-1.11.0.min.js?')}}{{Config::get('tsConst.jsGlobal')}}"></script>
<script src="{{URL::asset('js/bootstrap.3.3.4.min.js?')}}{{Config::get('tsConst.jsGlobal')}}"></script>
<script src="{{URL::asset('js/jquery-ui-1.10.4.custom.js?')}}{{Config::get('tsConst.jsGlobal')}}"></script>
<script src="{{URL::asset('js/moment.min.js?')}}{{Config::get('tsConst.jsGlobal')}}"></script>
<script src="{{URL::asset('js/zh-cn.js?')}}{{Config::get('tsConst.jsGlobal')}}"></script>
<script src="{{URL::asset('js/jquery.datetimepicker.full.js?')}}{{Config::get('tsConst.jsGlobal')}}"></script>
<script src="{{URL::asset('js/zc.pagination.js?')}}{{Config::get('tsConst.jsGlobal')}}"></script>
<script src="{{URL::asset('js/index.js?')}}{{Config::get('tsConst.jsIndex')}}"></script>
</body>
</html>
