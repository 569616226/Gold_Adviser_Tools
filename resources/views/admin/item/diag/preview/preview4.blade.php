@extends('layouts.admin-preview')
@section('title', '附录')

@section('content')
    <header class="am-topbar dh-header bgfff" style="margin-bottom: 0;">
        <div class="am-g">
            <div class="am-u-sm-3 am-u-md-3 am-u-lg-2 dh-header-left bgkynav">
                <img src=" {{ url('images/donghua.png') }}"/>
            </div>
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10 dh-header-right bgfff box-shadow-black">
                <p style="line-height: 50px;"><i class="iconfont color639">&#xe613;</i><span class="am-margin-left-lg">{{ $item->hands->users->name }} 诊断报告</span>
                </p>
            </div>
        </div>
    </header>

    <div class="dh-main bgfff">
        <div class="am-g heightMax">
            <div class="am-u-sm-3 am-u-md-3 am-u-lg-2 bgkynav" id="leftNav">
                <nav class="dh-nav dhkh-nav">
                    <ul class="am-nav am-g">
                        <div class="lindiv" style="background: #292E47;"></div>
                        <li class=" am-padding-left-lg">
                            <a href="{{ route('diag.preview',[$item->id]) }}">诊断报告</a>
                        </li>
                        <li class="am-padding-left-lg">
                            <a href="{{ route('diag.preview.msg',[$item->id]) }}">诊断结果概述</a>
                        </li>
                        <li class="am-padding-left-lg">
                            <a href="{{ route('diag.preview.data',[$item->id]) }}">诊断结果具体分析</a>
                        </li>
                        <li class="am-active  am-padding-left-lg">
                            <a href="{{ route('diag.preview.company',[$item->id]) }}">企业背景描述</a>
                        </li>
                        <li class="am-padding-left-lg">
                            <a href="{{ route('diag.preview.closure',[$item->id]) }}">附录</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10 am-padding-0 bgfff" id="rightMain">
                <div class="am-padding-lg">
                    <div>
                        <div class="am-g fs18 marginT30px">
                            <p class="am-u-sm-2 am-text-right">企业背景描述</p>
                            <div style="clear: both;"></div>
                        </div>
                        <div class="am-g marginT15px">
                            <div class="am-u-sm-3 am-text-right color888">
                                注册名称：
                            </div>
                            <div class="am-u-sm-9 am-text-left">
                                {{ $item->hands->users->name }}
                            </div>
                        </div>
                        <div class="am-g marginT15px">
                            <div class="am-u-sm-3 am-text-right color888">
                                注册地址：
                            </div>
                            <div class="am-u-sm-9 am-text-left">
                                {{ $item->hands->users->address }}
                            </div>
                        </div>
                        <div class="am-g marginT15px">
                            <div class="am-u-sm-3 am-text-right color888">
                                成立日期/营业期限：
                            </div>
                            <div class="am-u-sm-9 am-text-left">
                                {{ $item->hands->users->create_date->year }}年{{ $item->hands->users->create_date->month }}月{{ $item->hands->users->create_date->day }}日
                            </div>
                        </div>
                        <div class="am-g marginT15px">
                            <div class="am-u-sm-3 am-text-right color888">
                                企业贸易类型：
                            </div>
                            <div class="am-u-sm-9 am-text-left">
                                @if($item->hands->users->trade == 0)
                                    一般贸易
                                @elseif($item->hands->users->trade == 1)
                                    加工贸易
                                @elseif($item->hands->users->trade == 2)
                                    无
                                @endif
                            </div>
                        </div>
                        <div class="am-g marginT15px">
                            <div class="am-u-sm-3 am-text-right color888">
                                注册资本：
                            </div>
                            <div class="am-u-sm-9 am-text-left">
                                {{ $item->hands->users->capital }}
                            </div>
                        </div>
                        <div class="am-g marginT15px">
                            <div class="am-u-sm-3 am-text-right color888">
                                海关注册登记编码：
                            </div>
                            <div class="am-u-sm-9 am-text-left">
                                {{ $item->hands->users->code }}
                            </div>
                        </div>
                        <div class="am-g marginT15px">
                            <div class="am-u-sm-3 am-text-right color888">
                                管理类型：
                            </div>
                            <div class="am-u-sm-9 am-text-left">
                                @if($item->hands->users->aeo == 0)
                                    一般认证企业
                                @elseif($item->hands->users->aeo == 1)
                                    无
                                @endif
                            </div>
                        </div>
                        <div class="am-g marginT15px">
                            <div class="am-u-sm-3 am-text-right color888">
                                加工贸易手册监管方式：
                            </div>
                            <div class="am-u-sm-9 am-text-left">
                                {{ $item->hands->users->trade_manual }}
                            </div>
                        </div>
                        <div class="am-g marginT15px">
                            <div class="am-u-sm-3 am-text-right color888">
                                生产项目类别：
                            </div>
                            <div class="am-u-sm-9 am-text-left">
                                {{ $item->hands->users->pro_item_type }}
                            </div>
                        </div>
                        <div class="am-g marginT15px">
                            <div class="am-u-sm-3 am-text-right color888">
                                主要进出口贸易方式：
                            </div>
                            <div class="am-u-sm-9 am-text-left">
                                {{ $item->hands->users->main_trade }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection