@extends('layouts.admin-preview')
@section('title', '材料清单审核资料')

@section('css')
    @parent
    <style type="text/css">
        .am-table > tbody > tr > td {
            border: none;
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
                <img src=" {{ url('images/donghua.png') }}"/>
            </div>
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10 dh-header-right bgfff box-shadow-black">
                <p style="line-height: 50px;"><i class="iconfont color639">&#xe613;</i><span class="am-margin-left-lg">{{ $item->hands->users->name }}
                        诊断前需提前准备的材料清单</span></p>
            </div>
        </div>
    </header>

    <div class="dh-main bgfff">
        <div class="am-g heightMax">
            <div class="am-u-sm-3 am-u-md-3 am-u-lg-2 bgkynav am-padding-bottom-lg" id="leftNav">
                <nav class="dh-nav dhkh-nav">
                    <ul class="am-nav am-g" style="margin-bottom: 100px">
                        <div class="lindiv" style="background: #292E47;"></div>
                        <li class="am-padding-left-lg">
                            <a href="{{ route('guest.material.preview',[$item->id]) }}">清单封面</a>
                        </li>
                        <li class="am-padding-left-lg">
                            <a href="{{ route('guest.material.preview.msg',[$item->id])}}">清单信息</a>
                        </li>
                        <li class="am-active am-padding-left-lg">
                            <a href="{{ route('guest.material.preview.data',[$item->id]) }}">审核所涉及的资料</a>
                        </li>

                        <li class="am-padding-left-lg">
                            <nav class="dh-nav dhkh-nav kh-nav-list am-padding-left-lg" id="navlist" style="margin-top: -1.5rem;">
                            @foreach($maters  as $mater )
                                @if ($loop->first)
                                    <li class="active am-padding-left-lg am-margin-top">
                                        <a href="javascript:void(0);">{{ $mater->department }}</a>
                                    </li>
                                @endif
                                @if($loop->index == 0)
                                    @continue
                                @endif
                                <li class="am-padding-left-lg am-margin-top">
                                    <a href="javascript:void(0);">{{ $mater->department }}</a>
                                </li>
                            @endforeach

                        {{-- 显示自定义材料清单内容--}}
                            @if(isset($material_selfs))
                                @foreach($material_selfs  as $mater )
                                    <li class="am-padding-left-lg am-margin-top">
                                        <a href="javascript:void(0);">{{ $mater->department }}</a>
                                    </li>
                            @endforeach
                            @endif
                            </nav>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10 bgfff am-padding-bottom-lg" id="rightMain">
                <div class="dh-main-container heightMax" id="containerlist">
                    @foreach($maters as $mater)
                        @if ($loop->first)
                        <div class="tabCard active">
                            <div class="am-margin-top-lg">
                                <p class="am-padding-left-lg fs20 lanbefore">{{ $mater-> department }}</p>
                                @foreach($mater->material_content_templates as $material_content_template)
                                <div>
                                    {{ $material_content_template->name }}
                                    {!!  html_entity_decode(stripslashes($material_content_template->content)) !!}
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        @if($loop->index == 0)
                            @continue
                        @endif
                    <div class="tabCard">
                        <div class="am-margin-top-lg">
                            <p class="am-padding-left-lg fs20 lanbefore">{{ $mater-> department }}</p>
                            @foreach($mater->material_content_templates as $material_content_template)
                            <div>
                                {{ $material_content_template->name }}
                                {!!  html_entity_decode(stripslashes($material_content_template->content)) !!}
                            </div>
                            @endforeach

                            {{-- 显示自定义材料清单内容--}}
                            @foreach($mater->material_contents as $material_content)
                            <div>
                                {{ $material_content->name }}
                                {!!  html_entity_decode(stripslashes($material_content->content)) !!}
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach

                    {{-- 显示自定义材料清单内容--}}
                    @if(isset($material_selfs))
                        @foreach($material_selfs  as $mater )
                        <div class="tabCard">
                            <div class="am-margin-top-lg">
                                <p class="am-padding-left-lg fs20 lanbefore">{{ $mater-> department }}</p>
                                @foreach($mater->material_contents as $material_content)
                                    <div>
                                        {{ $material_content->name }}
                                        {!!  html_entity_decode(stripslashes($material_content->content)) !!}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    @endif
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