@extends('layouts.admin-preview')
@section('title', '诊断报告封面')

@section('content')
    <body>
    <header class="am-topbar dh-header bgfff" style="margin-bottom: 0;">
        <div class="am-g">
            <div class="am-u-sm-3 am-u-md-3 am-u-lg-2 dh-header-left bgkynav">
                <img src=" {{ url('images/donghua.png') }}"/>
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
                            <a href="{{ route('diag.preview',[$item->id]) }}">诊断报告</a>
                        </li>
                        <li class="am-padding-left-lg">
                            <a href="{{ route('diag.preview.msg',[$item->id]) }}">诊断结果概述</a>
                        </li>
                        <li class="am-padding-left-lg">
                            <a href="{{ route('diag.preview.data',[$item->id]) }}">诊断结果具体分析</a>
                        </li>
                        <li class="am-padding-left-lg">
                            <a href="{{ route('diag.preview.company',[$item->id]) }}">企业背景描述</a>
                        </li>
                        <li class="am-padding-left-lg">
                            <a href="{{ route('diag.preview.closure',[$item->id]) }}">附录</a>
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
                        <p class="fs20 color888">{{ $item->item_datas->updated_at->year }}年{{ $item->item_datas->updated_at->month }}月{{ $item->item_datas->updated_at->day }}日</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection