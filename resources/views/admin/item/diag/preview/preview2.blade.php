@extends('layouts.admin-preview')
@section('title', '诊断结果具体分析')

@section('css')
    @parent
    <style type="text/css">
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
                <p style="line-height: 50px;"><i class="iconfont color639">&#xe613;</i><span class="am-margin-left-lg">{{ $item->hands->users->name }} 诊断结果具体分析</span>
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
                            <a href="{{ route('diag.preview',[$item->id]) }}">诊断报告</a>
                        </li>
                        <li class="am-padding-left-lg">
                            <a href="{{ route('diag.preview.msg',[$item->id]) }}">诊断结果概述</a>
                        </li>
                        <li class="am-active am-padding-left-lg">
                            <a href="{{ route('diag.preview.data',[$item->id]) }}">诊断结果具体分析</a>
                        </li>
                        <li class="am-padding-left-lg">
                            <nav class="dh-nav dhkh-nav kh-nav-list am-padding-left-lg" id="navlist" style="margin-top: -1.5rem;">
                            @foreach($diag_mods  as $diag_mod )
                                @if ($loop->first)
                                    <li class="active am-padding-left-lg am-margin-top">
                                        <a href="javascript:void(0);">关务风险管理</a>
                                    </li>
                                @endif
                                @if($loop->index == 0)
                                    @continue
                                @endif
                                <li class="am-padding-left-lg am-margin-top">
                                    <a href="javascript:void(0);">
                                        @if($loop->index == 1)
                                            AEO管理
                                        @elseif($loop->index == 2)
                                            物流风险管理
                                        @else
                                            系统化管理
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                            </nav>
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
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10 am-padding-0" style="background: white" id="rightMain">
                <div class="dh-main-container bgfff" id="containerlist">

                    <!--选项卡内容-->
                    @foreach($diag_mods as $diag_mod)
                    @if ($loop->first)
                    <div class="tabCard active">
                        @foreach($diag_mod->diag_submods as $diag_submod)
                        <div class="am-margin-top-lg">
                            <p class="am-padding-left-lg">{{ $diag_submod->name }}</p>
                            <table class="am-table am-table-bordered">
                                <thead>
                                <tr>
                                    <th class="am-text-center am-text-middle" width="20%">审核内容</th>
                                    <th class="am-text-center am-text-middle" width="40%" style="min-width: 130px">问题风险及描述</th>
                                    <th class="am-text-center am-text-middle" width="10%" style="min-width: 100px">法律依据</th>
                                    <th class="am-text-center am-text-middle" width="30%" style="min-width: 130px">建议及改善方案</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($diag_submod->diag_subcontents as $diag_subcontent)
                                <tr>
                                    <td class="am-text-middle" style="max-width: 500px;">{!!  html_entity_decode(stripslashes($diag_subcontent->content)) !!}</td>
                                    <td class="am-text-left am-text-middle colorred">{{ $diag_subcontent->describle }}</td>
                                    <td class="am-text-center am-text-middle">
                                        <div class="stcha" name="{{ $diag_subcontent->id }}" style="cursor: pointer" onclick="flyjshowfun(this)">&nbsp;{{ $diag_subcontent->law }}</div>
                                    </td>
                                    <td class="am-text-left am-text-middle colorred">
                                        {{ $diag_subcontent->suggest }}
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    @if($loop->index == 0)
                        @continue
                    @endif
                    <div class="tabCard">
                                @foreach($diag_mod->diag_submods as $diag_submod)
                                    <div class="am-margin-top-lg">
                                        <p class="am-padding-left-lg">{{ $diag_submod->name }}</p>
                                        <table class="am-table am-table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="am-text-center am-text-middle" width="20%">审核内容</th>
                                                <th class="am-text-center am-text-middle" width="40%" style="min-width: 130px">问题风险及描述</th>
                                                <th class="am-text-center am-text-middle" width="10%" style="min-width: 100px">法律依据</th>
                                                <th class="am-text-center am-text-middle" width="30%" style="min-width: 130px">建议及改善方案</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($diag_submod->diag_subcontents as $diag_subcontent)
                                                <tr>
                                                    <td class="am-text-middle" style="max-width: 500px;">{!!  html_entity_decode(stripslashes($diag_subcontent->content)) !!}</td>
                                                    <td class="am-text-left am-text-middle colorred">{{ $diag_subcontent->describle }}</td>
                                                    <td class="am-text-center am-text-middle">
                                                        <div class="stcha" name="{{ $diag_subcontent->id }}" style="cursor: pointer" onclick="flyjshowfun(this)">&nbsp;{{ $diag_subcontent->law }}</div>
                                                    </td>
                                                    <td class="am-text-left am-text-middle colorred">
                                                        {{ $diag_subcontent->suggest }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endforeach
                            </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!--查看法律法规-->
    <div class="am-modal am-modal-no-btn" id="flyjshow_modal">
        <div class="am-modal-dialog" style="width: 980px;">
            <div class="am-modal-hd">
                <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i><span>查看法律法规</span></span>
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <div class="am-modal-bd rights-modal am-margin-top am-padding-bottom-lg">
                <div class="lindiv"></div>
                <table class="am-table am-table-bordered am-table-bd am-margin-top-lg">
                    <thead>
                    <tr class="am-active">
                        <th class="am-text-center am-text-middle" style="min-width: 180px;">法规条例名称</th>
                        <th class="am-text-center am-text-middle" style="min-width: 180px;">法规条例文号</th>
                        <th class="am-text-center am-text-middle" style="min-width: 180px;">法规条例条号</th>
                        <th class="am-text-center am-text-middle" style="min-width: 100px;">法规条例内容</th>
                    </tr>
                    </thead>
                    <tbody id="law_content">
                    </tbody>
                </table>
                <a href="javascript:void(0)" class="am-btn am-btn-primary br5px am-margin" data-am-modal-close>关闭</a>
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
        });
        //查看状态点击查看法律法规
        function flyjshowfun(e) {
            var diag_content_id = $(e).attr("name");
            var url = '/admin/item/diags/'+ diag_content_id +'/law/see';
            AjaxJson(url,{},function(data){
                $("#law_content").html(data.html);
            });
            $("#flyjshow_modal").modal();
        }

    </script>
@endsection