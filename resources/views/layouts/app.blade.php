<!doctype html>
<html class="no-js">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')-东华国际项目管理系统</title>
    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">
    <!-- No Baidu Siteapp-->
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <!-- <link rel="icon" type="image/png" href="assets/i/favicon.png"> -->

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="" />
    @section('css')
        <link rel="stylesheet" href="{{ url('css/amazeui.min.css') }} ">
        <link rel="stylesheet" href="{{ url('js/icheck/skins/icheck-all.css') }}"/>
        <link rel="stylesheet" href="{{ url('css/main.css') }}">
        <style type="text/css">
            .dhkh-nav>ul>li.am-active:before {
                content: "";
                height: .6rem;
                width: .6rem;
                border-radius:100% ;
                background: #03A9F4;
                position: absolute;
                left: 2rem;
                top: 2.2rem;
                z-index: 100;
            }
        </style>
    @show
</head>

<body>
<header class="am-topbar Customeer-header">
    <div class="am-g">
        <div class="am-fl">
            <a href="/"><img class="logo am-margin-left-lg" src="{{ url('/images/donghua.png') }}"/></a>
            <span class="title am-margin-left-lg colorw">{{ Auth::user()->users->name }}</span>
        </div>
        <div class="am-fr am-padding-right-lg">
            <i class="iconfont colorw">&#xe64f;</i>
            <div class="am-dropdown" data-am-dropdown>
                <a class="am-dropdown-toggle" href="" data-am-dropdown-toggle><span
                            class="dropusername">{{ Auth::user()->username }}</span><span
                            class="am-icon-caret-down"></span></a>
                <ul class="am-dropdown-content">
                    <li><a href="javascript:void(0);" data-am-modal="{target: '#editpassword-modal'}">修改密码</a></li>
                    <li>
                        <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">退出登录</a>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</header>
{{-- 修改密码模态框 --}}
<div class="am-modal am-modal-no-btn"  id="editpassword-modal">
    <div class="am-modal-dialog">
        <div class="am-modal-hd">修改密码
            <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
        </div>
        <div class="lindiv"></div>
        <div class="am-modal-bd">
            <form  class="am-form am-form-horizontal am-margin-top" id="editpassword">
            {{ csrf_field() }}
            <!--一排一列-->
                <div class="am-form-group card-box">
                    <label class="am-u-sm-3 am-u-sm-offset-1 am-form-label"><span class="colorred">* </span>旧密码</label>
                    <div class="am-u-sm-6">
                        <input name="password_old" class="br5px" type="password" placeholder="请输入旧密码" datatype="*" nullmsg="请输入旧密码" autocomplete="off" />
                    </div>
                </div>
                <div class="am-form-group card-box">
                    <label class="am-u-sm-3 am-u-sm-offset-1 am-form-label"><span class="colorred">* </span>新密码</label>
                    <div class="am-u-sm-6">
                        <input name="password" class="br5px" type="password" placeholder="请输入新密码" datatype="*6-20" errormsg="请输入6到20新位密码" nullmsg="请输入新密码" autocomplete="off" />
                    </div>
                </div>
                <div class="am-form-group card-box">
                    <label class="am-u-sm-3 am-u-sm-offset-1 am-form-label"><span class="colorred">* </span>确认密码</label>
                    <div class="am-u-sm-6">
                        <input name="password_confirmation" class="br5px" type="password" placeholder="请再次输入密码" datatype="*6-20" errormsg="请输入6到20位新密码" nullmsg="请再次输入密码" autocomplete="off" />
                    </div>
                </div>
                <p><input type="submit" class="am-btn am-btn-primary" value="提交"></p>
            </form>
        </div>
    </div>
</div>
@yield('content')

@section('javascript')
<!--[if (gte IE 9)|!(IE)]><!-->

<script src="{{ url('js/jquery.min.js') }}"></script>
<!--<![endif]-->
<!--[if lte IE 8 ]>
<script src="http://libs.baidu.com/jquery/1.11.3/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="{{ url('assets/js/amazeui.ie8polyfill.min.js') }} "></script>
<![endif]-->
<script src="{{ url('js/amazeui.min.js') }}"></script>
<script src="{{ url('/js/layer/layer.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ url('js/validform/js/Validform_v5.3.2_min.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ url('/js/validform/js/Validform_Datatype.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ url('js/nicescroll/nicescroll.js') }} " type="text/javascript" charset="utf-8"></script>
<script src="{{ url('/js/icheck/icheck.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ url('js/main.js') }}" type="text/javascript" charset="utf-8"></script>
{!! Toastr::render() !!}
@show
</body>
<script>
    $("#editpassword").Validform({
        tiptype: function (msgs, o, cssctl) {
            if (o.type != 2) {     //只有不正确的时候才出发提示，输入正确不提示
                layer.msg(msgs);
            }
        },
        ajaxPost: true,//true用ajax提交，false用form方式提交
        tipSweep: true,//true只在提交表单的时候开始验证，false每输入完一个输入框之后就开始验证
        //验证前的动作
        beforeCheck: function (curform) {
        },
        //表单提交之前的动作
        beforeSubmit: function (curforms) {
            var postdata = GetWebControls('#editpassword'); //表单数据
            var url = '/user/resetpassword';
            AjaxJson(url,{postdata:postdata},function (data) {
                if(data.status == 1) {
                    layer.msg(data.msg);
                    $('#logout-form').submit();
                }else {
                    layer.msg(data.msg);
                }
            });
            return false;
        }
    });
</script>
</html>