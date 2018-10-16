@extends('layouts.admin-preview')
@section('title', '诊断报告封面')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ url('css/main.css') }}">
    <style type="text/css">
        .dhkh-nav > ul > li.am-active:before {
            content: "";
            height: .6rem;
            width: .6rem;
            border-radius: 100%;
            background: #03A9F4;
            position: absolute;
            left: 2rem;
            top: 2.2rem;
            z-index: 100;
        }

        .am-table-bordered > tbody > tr:first-child > td, .am-table-bordered > tbody > tr:first-child > th {
            border-left: 1px solid #ddd;
        }

        .dhkh-nav > ul > li.am-active:before {

        }

        .tabCard {
            display: none;
        }

        .tabCard.active {
            display: block;
        }
    </style>
@endsection

@section('content')
<header class="am-topbar dh-header bgfff" style="margin-bottom: 0;">
    <div class="am-g">
        <div class="am-u-sm-3 am-u-md-3 am-u-lg-2 dh-header-left bgkynav">
            <img src="{{ url('images/donghua.png') }}"/>
        </div>
        <div class="am-u-sm-9 am-u-md-9 am-u-lg-10 dh-header-right bgfff box-shadow-black">
            <p style="line-height: 50px;"><i class="iconfont color639">&#xe613;</i><span class="am-margin-left-lg">{{ $item->hands->users->name }} 改善实施计划</span>
            </p>
        </div>
    </div>
</header>

<div class="dh-main bgfff">
    <div class="am-g bgfff">
        <div class="am-u-sm-3 am-u-md-3 am-u-lg-2 bgkynav am-padding-bottom-lg" id="leftNav">
            <nav class="dh-nav dhkh-nav">
                <ul class="am-nav am-g" style="margin-bottom: 50px;">
                    <div class="lindiv" style="background: #292E47;"></div>
                    <li class="am-padding-left-lg">
                        <a href="{{ route('improve.preview',[$item->id]) }}">改善实施计划</a>
                    </li>
                    <li class="am-active am-padding-left-lg">
                        <a href="{{ route('improve.preview.msg',[$item->id]) }}">实施计划安排</a>
                    </li>
                    <li class="am-padding-left-lg">
                        <nav class="dh-nav dhkh-nav kh-nav-list am-padding-left-lg" id="navlist"
                             style="margin-top: -1.5rem;">
                            @foreach($improves  as $improve )
                                @if ($loop->first)
                                    <li class="active am-padding-left-lg am-margin-top">
                                        <a href="#">{{ $improve->name }}</a>
                                    </li>
                                @endif
                                @if ($improve->id == 1)
                                    @continue
                                @endif
                                    <li class="am-padding-left-lg am-margin-top">
                                    <a href="#">{{ $improve->name }}</a>
                                </li>
                            @endforeach
                </ul>
            </nav>
        </div>
        <div class="am-u-sm-9 am-u-md-9 am-u-lg-10 am-padding-0" style="background: white" id="rightMain">
            <div id="containerlist" class="dh-main-container">
                @foreach($improves  as $improve )
                    @if ($loop->first)
                        <div class="tabCard active">
                            <table class="am-table am-table-compact am-table-bordered am-table-centered am-margin-top-lg">
                                <tr>
                                    <th class="am-text-middle" style="min-width: 70px">项目</th>
                                    <th class="am-text-middle">服务内容</th>
                                    <th class="am-text-middle">服务目标</th>
                                    <th class="am-text-middle" style="min-width: 82px;">执行类型</th>
                                    <th class="am-text-middle" style="min-width: 82px;">开始时间</th>
                                    <th class="am-text-middle" style="min-width: 82px;">结束时间</th>
                                    <th class="am-text-middle" style="min-width: 82px;">负责人</th>
                                    <th class="am-text-middle" style="min-width: 82px;">备注</th>
                                </tr>
                                @foreach($improve->improve_list_tems as $improve_list)
                                    @foreach($improve_list->improve_con_tems as $improve_con_tem)
                                        @if($loop->iteration == 1 )
                                            <tr>
                                                <td class="am-text-middle" rowspan="{{ count($improve_list->improve_con_tems) }}">
                                                    {{ $improve_list->name }}
                                                </td>
                                                <td class="am-text-middle am-text-left">{{ $improve_con_tem->content }}</td>
                                                <td class="am-text-middle am-text-left" rowspan="{{ count($improve_list->improve_con_tems) }}">
                                                    {{ $improve_list->target }}
                                                </td>
                                                <td class="am-text-middle am-text-left">
                                                    {{ $improve_con_tem->type }}
                                                </td>
                                                <td class="am-text-middle am-text-left">{{ $improve_con_tem->start_date }}</td>
                                                <td class="am-text-middle am-text-left">{{ $improve_con_tem->end_date }}</td>
                                                <td class="am-text-middle am-text-left">{{ $improve_con_tem->master }}</td>
                                                <td class="am-text-middle am-text-left">{{ $improve_con_tem->remark }}</td>

                                            </tr>
                                        @else
                                            <tr>
                                                <td class="am-text-middle am-text-left">{{ $improve_con_tem->content }}</td>
                                                <td class="am-text-middle am-text-left">
                                                    {{ $improve_con_tem->type }}
                                                </td>
                                                <td class="am-text-middle am-text-left">{{ $improve_con_tem->start_date }}</td>
                                                <td class="am-text-middle am-text-left">{{ $improve_con_tem->end_date }}</td>
                                                <td class="am-text-middle am-text-left">{{ $improve_con_tem->master }}</td>
                                                <td class="am-text-middle am-text-left">{{ $improve_con_tem->remark }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            </table>
                        </div>
                    @endif
                    @if($improve->id == 1)
                        @continue
                    @endif
                    <div class="tabCard ">
                        <table class="am-table am-table-compact am-table-bordered am-table-centered am-margin-top-lg">
                            <tr>
                                <th class="am-text-middle" style="min-width: 70px">项目</th>
                                <th class="am-text-middle">服务内容</th>
                                <th class="am-text-middle">服务目标</th>
                                <th class="am-text-middle" style="min-width: 82px;">执行类型</th>
                                <th class="am-text-middle" style="min-width: 82px;">开始时间</th>
                                <th class="am-text-middle" style="min-width: 82px;">结束时间</th>
                                <th class="am-text-middle" style="min-width: 82px;">负责人</th>
                                <th class="am-text-middle" style="min-width: 82px;">备注</th>
                            </tr>
                            @foreach($improve->improve_list_tems as $improve_list)
                                @foreach($improve_list->improve_con_tems as $improve_con_tem)
                                    @if($loop->iteration == 1 )
                                        @for($x = 1; $x<=count($improve_list->improve_con_tems); $x++)
                                            <tr>
                                                @if($x == 1)
                                                    <td class="am-text-middle" rowspan="{{ count($improve_list->improve_con_tems) }}">
                                                        {{ $improve_list->name }}
                                                    </td>
                                                @endif
                                                <td class="am-text-middle am-text-left">{{ $improve_con_tem->content }}</td>
                                                @if($x == 1)
                                                    <td class="am-text-middle am-text-left" rowspan="{{ count($improve_list->improve_con_tems) }}">
                                                        {{ $improve_list->target }}
                                                    </td>
                                                @endif
                                                <td class="am-text-middle am-text-left">{{ $improve_con_tem->type }}</td>
                                                <td class="am-text-middle am-text-left"></td>
                                                <td class="am-text-middle am-text-left"></td>
                                                <td class="am-text-middle am-text-left"></td>
                                                <td class="am-text-middle am-text-left">{{ $improve_con_tem->remark }}</td>
                                            </tr>
                                        @endfor
                                    @endif
                                @endforeach
                            @endforeach
                        </table>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
@parent
<script>
    $(document).ready(function () {
        $("#navlist li").each(function (index) {
            $(this).click(function () {
                $("#navlist li.active").removeClass("active");
                $(".tabCard").removeClass("active");
                $("#containerlist .tabCard").eq(index).addClass("active");
                $(this).addClass("active");
            })
        })
    })
</script>
@endsection