@extends('layouts.admin-preview')
@section('title', '诊断结果概述')

@section('content')
    <header class="am-topbar dh-header bgfff" style="margin-bottom: 0;">
        <div class="am-g">
            <div class="am-u-sm-3 am-u-md-3 am-u-lg-2 dh-header-left bgkynav">
                <img src="/../images/donghua.png"/>
            </div>
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10 dh-header-right bgfff box-shadow-black">
                <p style="line-height: 50px;"><i class="iconfont color639">&#xe613;</i><span class="am-margin-left-lg">{{ $item->hands->users->name }} 诊断报告</span>
                </p>
            </div>
        </div>
    </header>

    <div class="dh-main bgfff">
        <div class="am-g bgfff">
            <div class="am-u-sm-3 am-u-md-3 am-u-lg-2 bgkynav" id="leftNav">
                <nav class="dh-nav dhkh-nav">
                    <ul class="am-nav am-g">
                        <div class="lindiv" style="background: #292E47;"></div>
                        <li class="am-padding-left-lg">
                            <a href="{{ route('guest.diag.preview',[$item->id]) }}">诊断报告</a>
                        </li>
                        <li class="am-active am-padding-left-lg">
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
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10 am-padding-bottom-lg bgfff" id="rightMain">
                <div class="am-padding-lg">
                    <p class="fs18">通过本次诊断，我司发现贵司存在如下主要问题</p>

                    @foreach($item->diags as $diag)
                    <div class="text-card">
                        <h3 class="title fs20">
                            @if($diag->title == 1)
                                （一）关于关务管理诊断存在问题如下：
                            @elseif($diag->title == 2)
                                （二）关于AEO管理诊断存在问题如下：
                            @elseif($diag->title == 3)
                                （三）关于物流风险管理诊断存在问题如下：
                            @elseif($diag->title == 4)
                                （四）关于系统化管理诊断存在问题如下：
                            @elseif($diag->title == 5)
                                （五）关于预归类诊断存在问题如下：
                            @elseif($diag->title == 6)
                                （六）关于预估价诊断存在问题如下：
                            @endif
                        </h3>
                        <div class="text-main am-padding-left-lg">
                            <div class="text-child">
                                {!!  html_entity_decode(stripslashes($diag->content)) !!}
                            </div>
                        </div>
                    </div>
                    @endforeach
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