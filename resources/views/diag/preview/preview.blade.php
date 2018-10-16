@extends('layouts.admin-preview')
@section('title', '诊断报告封面')

@section('content')
    <body>
    <header class="am-topbar dh-header bgfff" style="margin-bottom: 0;">
        <div class="am-g">
            <div class="am-u-sm-3 am-u-md-3 am-u-lg-2 dh-header-left bgkynav">
                <img src="/../images/donghua.png"/>
            </div>
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10 dh-header-right bgfff box-shadow-black">
                <p style="line-height: 50px;"><i class="iconfont color639">&#xe613;</i><span class="am-margin-left-lg">{{ $item->hands->users->name }}
                        诊断报告</span></p>
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
                            <a href="{{ route('guest.diag.preview',[$item->id]) }}">诊断报告</a>
                        </li>
                        <li class="am-padding-left-lg">
                            <a href="{{ route('guest.diag.preview.msg',[$item->id]) }}">诊断结果概述</a>
                        </li>
                        <li class="am-padding-left-lg">
                            <a href="{{ route('guest.diag.preview.data',[$item->id]) }}">诊断结果具体分析</a>
                        </li>
                        <li class="am-padding-left-lg">
                            <a href="{{ route('guest.diag.preview.company',[$item->id]) }}">企业背景描述</a>
                        </li>
                        <li class="am-padding-left-lg">
                            <a href="{{ route('guest.diag.preview.closure',[$item->id]) }}">附录</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10 heightMax am-padding-0" id="rightMain">
                <div class="dh-main-container heightMax kybjfm kybjfm2">
                    <div class="am-text-center FmText">
                        <img style="width: 30%;" src="/../images/donghualogo.png"/>
                        <p class="fs28">{{ $item->hands->users->name }}</p>
                        <p class="fs22">供应链定制化服务风险诊断</p>
                        <p class="fs20 color888 am-margin-top-lg">{{ $item->hands->meches->name }}</p>
                        @if($item->diag_active == 1)
                            <p class="fs20 color888">{{ $item->diag_active_time->year }}年{{ $item->diag_active_time->month }}月{{ $item->diag_active_time->day }}日</p>
                        @else
                            <p class="fs20 color888">暂无</p>
                        @endif
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