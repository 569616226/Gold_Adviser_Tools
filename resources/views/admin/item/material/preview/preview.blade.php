@extends('layouts.admin-preview')
@section('title', '材料清单封面')

@section('content')
    <header class="am-topbar dh-header bgfff" style="margin-bottom: 0;">
        <div class="am-g">
            <div class="am-u-sm-3 am-u-md-3 am-u-lg-2 dh-header-left bgkynav">
                <img src=" {{ url('images/donghua.png') }}"/>
            </div>
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10 dh-header-right bgfff box-shadow-black">
                <p style="line-height: 50px;"><i class="iconfont color639">&#xe613;</i><span class="am-margin-left-lg">{{ $item->hands->users->name }}
                        诊断前需提前准备的材料清单</span></p>
            </div>
        </div>
    </header>

    <div class="dh-main heightMax">
        <div class="am-g heightMax">
            <div class="am-u-sm-3 am-u-md-3 am-u-lg-2 bgkynav" id="leftNav">
                <nav class="dh-nav dhkh-nav">
                    <ul class="am-nav am-g">
                        <div class="lindiv" style="background: #292E47;"></div>
                        <li class="am-active am-padding-left-lg">
                            <a href="{{ route('material.preview',[$item->id]) }}">清单封面</a>
                        </li>
                        <li class="am-padding-left-lg">
                            <a href="{{ route('material.preview.msg',[$item->id])}}">清单信息</a>
                        </li>
                        <li class="am-padding-left-lg">
                            <a href="{{ route('material.preview.data',[$item->id]) }}">审核所涉及的资料</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10 heightMax am-padding-0" id="rightMain">
                <div class="dh-main-container heightMax kybjfm">
                    <div class="am-text-center FmText">
                        <img style="width: 50%;" src=" {{ url('images/kuayitong.png') }}"/>
                        <p class="fs44" style="color: #2354B0;">跨易通供应链定制化服务</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection