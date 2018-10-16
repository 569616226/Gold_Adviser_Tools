@extends('layouts.admin-preview')
@section('title', '诊断报告封面')

@section('content')
<header class="am-topbar dh-header bgfff" style="margin-bottom: 0;">
    <div class="am-g">
        <div class="am-u-sm-3 am-u-md-3 am-u-lg-2 dh-header-left bgkynav">
            <img src="/../images/donghua.png"/>
        </div>
        <div class="am-u-sm-9 am-u-md-9 am-u-lg-10 dh-header-right bgfff box-shadow-black">
            <p style="line-height: 50px;"><i class="iconfont color639">&#xe613;</i><span class="am-margin-left-lg">{{ $item->hands->users->name }} 改善实施计划</span>
            </p>
        </div>
    </div>
</header>

<div class="dh-main bgfff heightMax">
    <div class="am-g bgfff heightMax">
        <div class="am-u-sm-3 am-u-md-3 am-u-lg-2 bgkynav" id="leftNav">
            <nav class="dh-nav dhkh-nav">
                <ul class="am-nav am-g">
                    <div class="lindiv" style="background: #292E47;"></div>
                    <li class="am-active am-padding-left-lg">
                        <a href="{{ route('guest.improve.preview',[$item->id]) }}">改善实施计划</a>
                    </li>
                    <li class="am-padding-left-lg">
                        <a href="{{ route('guest.improve.preview.msg',[$item->id]) }}">实施计划安排</a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="am-u-sm-9 am-u-md-9 am-u-lg-10 heightMax am-padding-0" id="rightMain">
            <div class="dh-main-container heightMax kybjfm kybjfm3">
                <div class="am-text-center FmText">
                    <img style="width: 50%;" src="{{ url('images/kuayitong.png') }}"/>
                    <p class="fs32" style="color: #2354B0;">{{ $item->hands->name }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="am-topbar-fixed-bottom bgfff pa1010">
    <div style="padding-top: 8px;">
        <div class="am-fr">
            <a href="/" class="am-btn am-btn-white br5px">返回上一页</a>
        </div>
    </div>
</footer>
@endsection