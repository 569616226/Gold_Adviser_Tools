<!doctype html>
<html class="no-js">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>项目交接单-金牌顾问培训及项目管理系统</title>
    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">
    <!-- No Baidu Siteapp-->
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <!-- <link rel="icon" type="image/png" href="assets/i/favicon.png"> -->

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content=""/>
    <link rel="stylesheet" href="{{ url('/css/amazeui.min.css') }}">
    <link rel="stylesheet" href="{{ url('/css/main.css') }}">
</head>

<body class="">


@yield('content')

@section('javascript')
    <!--[if (gte IE 9)|!(IE)]><!-->
    <script src="{{ url('/js/jquery.min.js') }}"></script>
    <!--<![endif]-->
    <!--[if lte IE 8 ]>
    <script src="http://libs.baidu.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
    <script src="{{ url('assets/js/amazeui.ie8polyfill.min.js') }}"></script>
    <![endif]-->
    <script src="{{ url('/js/amazeui.min.js') }}"></script>
    <script src="{{ url('/js/nicescroll/nicescroll.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ url('/js/validform/js/Validform_v5.3.2_min.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ url('/js/validform/js/Validform_Datatype.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ url('/js/main.js') }}" type="text/javascript" charset="utf-8"></script>
    <script>
    </script>
    {!! Toastr::render() !!}
@show
</body>

</html>