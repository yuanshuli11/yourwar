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
    <link rel="stylesheet" type="text/css" href="{{asset('/css/home.css')}}">
    <script type="text/javascript" src="{{asset('/js/jquery.js')}}"></script>

    <script type="text/javascript" src="{{asset('/bootstrap/js/bootstrap.js')}}"></script>
    <script type="text/javascript" src="{{asset('/bootstrap/js/bootstrap.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/vue.js')}}"></script>
    <!-- Styles -->
   
</head>
<body>
    <div>
      

        @yield('content')


    </div>
</body>
</html>
