@extends('layouts.admin-login')

@section('content')
    <!--客户端-->
    <header class="login-header2 am-text-center" style="padding-top: 80px;">
        <p class="colorw fs28">东华国际项目管理系统</p>
        <p class="colorw">GOLD MEDAL CONSULTANT PROJECT MANAGEMENT SYSTEM</p>
    </header>

    <p class="am-text-center marginT30px fs18">企业客户登录</p>
    <div class="am-g login-box">
        <div class="am-u-md-3 am-u-sm-centered">
            <form class="am-form" id="loginform" method="post" action=" {{ route('login') }}">
                {{ csrf_field() }}
                <div class="am-form-group am-form-icon">
                    <i class="iconfont">&#xe64f;</i>
                    <input name="username" type="text" class="iconinput padd14px br5px" placeholder="用户名" datatype="*" nullmsg="请输入用户名">
                </div>
                <div class=" am-form-icon">
                    <i class="iconfont">&#xe60f;</i>
                    <input type="password" name="password" class="iconinput padd14px br5px" placeholder="密码" datatype="*5-20" nullmsg="请输入密码" errormsg="请输入6到20位密码">
                </div>
                <div class="am-form-group am-form-group-sm am-g">
                    <div class="am-u-sm-10">
                        <div class="am-checkbox am-g">
                            <label>
                                <input type="checkbox"> <span style="position: relative; top: 2px;">记住账号和密码</span>
                            </label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="am-btn am-btn-primary am-btn-block padd14px br5px">登录</button>
            </form>
        </div>
    </div>
    <footer class="am-topbar-fixed-bottom link-footer">
        <div class="am-text-center am-padding-top-sm am-padding-bottom-sm">
            <a target="_blank" href="http://119.23.141.231:6999/index.php?s=/8&page_id=20">企业客户-操作说明文档</a>
        </div>
    </footer>
@endsection

@section('javascript')
    @parent

@endsection