<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>   
    <link rel="stylesheet" type="text/css" href="{{asset('/bootstrap/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/syshome.css')}}">
    <script type="text/javascript" src="{{asset('/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('/bootstrap/js/bootstrap.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/vue.js')}}"></script>
    <!-- Styles -->   
</head>
<body>
    <div class="header">
        <div class="title">二战风云-后台管理系统</div>
    </div>
    <div class="main-body">
       <div class="side-bar">
            <div class="show-tab"> <a href="{{ asset('/sysadmin') }}">首页</a></div>
            <div class="show-tab"> <a href="{{ asset('/sysadmin/object/list') }}">对象列表</a></div>
            <div class="show-tab"> <a href="{{ asset('/sysadmin/object/add') }}">添加对象</a></div>
       </div>
        <div class="body-content">
            @yield('content')
        </div>
    </div>
  
</body>
</html>