@extends('layouts.admin-preview')
@section('title', '企业背景描述')

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
                        <li class="am-padding-left-lg">
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
                        <li class="am-active am-padding-left-lg">
                            <a href="{{ route('diag.preview.closure',[$item->id]) }}">附录</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10 am-padding-0 bgfff" id="rightMain">
                <div class="am-padding-lg">
                    <div class="text-card">
                        <div class="fs18 marginT30px">
                            <p class="am-fl">1.法规条例索引</p>
                        </div>
                        <!--表格（小项）-->
                        <table class="am-table am-table-bordered am-table-centered am-margin-top">
                            <thead>
                                <tr class="am-active">
                                    <th class="am-text-middle" style="min-width: 70px">序号</th>
                                    <th class="am-text-middle" style="min-width: 130px">法律条例名</th>
                                    <th class="am-text-middle" style="min-width: 130px">法规条例文号</th>
                                    <th class="am-text-middle" style="min-width: 130px">法规条例内容</th>
                                </tr>
                            </thead>

                            @if(isset($laws))
                                @foreach($laws as $key => $law)
                                    <tr>
                                        <td class="am-text-middle">{{ $key }}</td>
                                        <td class="am-text-middle">{{ $law->name }}</td>
                                        <td class="am-text-middle flyj">{{ $law->title }}
                                        </td>
                                        <td class="am-text-middle am-text-left">
                                            <p>{{ $law->name }}{{ $law->title }}</p>
                                            <div>{{ $law->title_no }}</div>
                                            <div>
                                                {!! html_entity_decode(stripslashes($law->content)) !!}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="am-text-middle" colspan="4">暂无</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                    <div class="text-card">
                        <p class="title fs20">
                            2.关务分析审核资料的清单
                        </p>
                        <div class="text-main am-padding-left-lg">
                            <div class="text-child">
                                {!!  html_entity_decode(stripslashes($item->item_datas->content)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
