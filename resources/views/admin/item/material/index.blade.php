@extends('layouts.admin-app')
@section('title', '材料清单')

@section('css')
    @parent
    <link rel="stylesheet" href=" {{ url('css/main.css') }}">
    <style type="text/css">
        .title * {
            margin-right: 10px;
        }

        .am-nav-tabs {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            overflow: auto;
            min-height: 45px;
        }

        .am-list li {
            padding-top: 20px;
        }

        .am-nav-tabs > li {
            margin-bottom: 0;
            -webkit-box-flex: 1;
            -webkit-flex: 1;
            -ms-flex: 1;
            flex: 1;
            text-align: center;
            word-break: keep-all; /* 不换行 */
            white-space: nowrap; /* 不换行 */
        }

        .am-list li:first-child {
            border: none;
        }

        .am-tabs-bd {
            min-height: 250px;
        }
        .am-article+.am-article {
            margin-top: 0.4rem;
        }
        .hovera {
            display: none;
        }
        .am-article:hover .hovera {
            display: inline-block;
        }
        /*.am-article-bd p {*/
            /*margin: 0;*/
        /*}*/
    </style>
@endsection

@section('content')
    <div class="dh-main">
        <div class="am-g">
            <div class="am-u-sm-3 am-u-md-3 am-u-lg-2 bgfff" id="leftNav">
                <!--左侧菜单-->
                @include('admin._partials.item-left-menu')
            </div>
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10" id="rightMain">
                <div class="dh-main-container">
                    <p class="title fs18">材料清单
                        @if(Entrust::can('material.preview'))
                            <a href="{{ route('material.preview',[$item->id])}}" target="_blank" class="am-fr am-btn am-btn-white br5px am-margin-left-xs">在线预览</a>
                        @endif
                        @if(Entrust::can('material.export.word'))
                        <a href="{{ route('material.export.word',[$item->id])}}" id="exportWord" class="am-fr am-btn am-btn-white br5px am-margin-left-xs">导出</a>
                        @endif
                        @if(Entrust::can('material.preview.active'))
                        <a href="{{ route('material.preview.active',[$item->id])}}" class="am-fr am-btn am-btn-white br5px am-margin-left-xs">交付客户</a>
                        @endif
                    </p>
                    <!--卡片-->
                    <div class="pro-card">
                        <h3>{{ $item->hands->name }} 供应链定制化服务风险诊断审核清单
                            {{--<a href="" class="am-btn am-btn-primary br5px am-fr">编辑</a>--}}
                        </h3>
                        <p><span class="color888">审核项目：</span><span>{{ $item->hands->name }}</span></p>
                        <p><span class="color888">审核地点：</span><span>{{ $item->hands->users->address }}</span></p>
                        <div class="lindiv"></div>
                        <h3>审核机构</h3>
                        <table class="am-table tablennod">
                            <tr>
                                <td class="am-text-right color888">名&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;称：</td>
                                <td>{{ $item->hands->meches->name }}</td>
                                <td class="am-text-right color888">通讯地址：</td>
                                <td>{{ $item->hands->meches->address }}</td>
                                <td class="am-text-right color888">邮政编码：</td>
                                <td>{{ $item->hands->meches->zip_code }}</td>
                            </tr>
                            <tr>
                                <td class="am-text-right color888">负&nbsp;&nbsp;责&nbsp;&nbsp;人：</td>
                                <td>{{ $item->hands->meches->master }}</td>
                                <td class="am-text-right color888">负责人电话：</td>
                                <td>{{ $item->hands->meches->master_tel }}</td>
                                <td class="am-text-right color888">负责人传真：</td>
                                <td>{{ $item->hands->meches->master_fax }}</td>
                            </tr>
                            <tr>
                                <td class="am-text-right color888">项目督导：</td>
                                <td>{{ $item->hands->meches->super }}</td>
                                <td class="am-text-right color888">电&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;话：
                                </td>
                                <td>{{ $item->hands->meches->super_tel }}</td>
                                <td class="am-text-right color888">传&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;真：
                                </td>
                                <td>{{ $item->hands->meches->super_fax }}</td>
                            </tr>
                            <tr>
                                <td class="am-text-right color888">审核团队：</td>
                                <td>{{ $item->hands->meches->verify_team }}</td>
                                <td class="am-text-right color888">电子邮箱：</td>
                                <td>{{ $item->hands->meches->email }}</td>
                            </tr>
                        </table>
                    </div>
                    <p class="title fs16">审核所涉及的资料
                        @if(Entrust::can('material.addmod'))
                            <a href="{{ route('material.addmod',[$item->id]) }}" class="am-fr am-btn am-btn-primary br5px">部门管理</a>
                        @endif
                    </p>
                    <div class="pro-card" style="padding: 0;">
                        <div class="am-tabs" data-am-tabs>
                            <ul class="am-tabs-nav am-nav am-nav-tabs">
                                @foreach($maters as $mater)
                                <li>
                                    <a style="position: relative" id="ali{{ $mater->id }}" href="#tab{{ $mater->id }}">{{ $mater->department }}</a>
                                </li>
                                @endforeach

                                {{-- 显示自定义材料清单内容--}}
                                @if(isset($material_selfs))
                                    @foreach($material_selfs  as $mater )
                                    <li>
                                        <a style="position: relative" id="ali{{ $mater->id }}" href="#tab_self{{ $mater->id }}">{{ $mater->department }}</a>
                                    </li>
                                    @endforeach
                                @endif
                            </ul>
                            <div class="am-tabs-bd paddlr20px">
                                @foreach($maters as $mater)
                                    <div class="am-tab-panel am-fade am-in" id="tab{{ $mater->id }}">
                                        <article class="am-article">
                                            <div class="am-article-hd">
                                                <a href="{{ route('material.create',[$item->id,$mater->id]) }}" class="am-fr am-btn am-btn-white br5px">新增内容</a>
                                            </div>
                                        </article>
                                        @foreach($mater->material_content_templates as $material_content_template)
                                        <article class="am-article">
                                            <div class="am-article-bd">
                                               <h2>{{ $material_content_template->name }}</h2>
                                            </div>
                                            <div class="am-article-bd">
                                                {!!  html_entity_decode(stripslashes( $material_content_template->content )) !!}
                                            </div>
                                            <div class="lindiv"></div>
                                        </article>
                                        @endforeach

                                        {{-- 显示自定义材料清单内容--}}
                                        @foreach($mater->material_contents as $material_content)
                                            <article class="am-article">
                                                <div class="am-article-hd">
                                                    <p class="am-article-title fs20">
                                                        <span></span>
                                                        <a href="javascript:void(0);" name="{{$material_content->id}}" class="hovera am-btn am-btn-white am-fr br5px am-margin-left-xs"  onclick="defun(this)">删除</a>
                                                        <a href="{{ route('material.edit',[$item->id,$mater->id,$material_content->id]) }}" class="hovera am-btn am-btn-white am-fr br5px">编辑</a>
                                                    </p>
                                                </div>
                                                <div class="am-article-bd">
                                                    <h2>{{ $material_content->name }}</h2>
                                                </div>
                                                <div class="am-article-bd">
                                                    {!!  html_entity_decode(stripslashes( $material_content->content )) !!}
                                                </div>
                                                <div class="lindiv"></div>
                                            </article>
                                        @endforeach
                                    </div>
                                @endforeach

                                {{-- 显示自定义材料清单内容--}}
                                @if(isset($material_selfs))
                                    @foreach($material_selfs  as $mater )
                                    <div class="am-tab-panel am-fade am-in" id="tab_self{{ $mater->id }}">
                                        <article class="am-article">
                                            <div class="am-article-hd">
                                                <a href="{{ route('material.create',[$item->id,$mater->id]) }}" class="am-fr am-btn am-btn-white br5px">新增内容</a>
                                            </div>
                                        </article>
                                        @foreach($mater->material_contents as $material_content)
                                        <article class="am-article">
                                            <div class="am-article-hd">
                                                <p class="am-article-title fs20">
                                                    <span></span>
                                                    <a href="javascript:void(0);" name="{{$material_content->id}}" class="hovera am-btn am-btn-white am-fr br5px am-margin-left-xs"  onclick="defun(this)">删除</a>
                                                    <a href="{{ route('material.edit',[$item->id,$mater->id,$material_content->id]) }}" class="hovera am-btn am-btn-white am-fr br5px">编辑</a>
                                                </p>
                                            </div>
                                            <div class="am-article-bd">
                                                <h2>{{ $material_content->name }}</h2>
                                            </div>
                                            <div class="am-article-bd">
                                                {!!  html_entity_decode(stripslashes( $material_content->content )) !!}
                                            </div>
                                            <div class="lindiv"></div>
                                        </article>
                                        @endforeach
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    @parent
    <script src=" {{ url('js/main.js') }}" type="text/javascript" charset="utf-8"></script>
    <script>
        var tabid = window.location.search.substring(3);
        var aliid = $("#ali" + tabid);
        var tabid = $("#tab" + tabid);
        aliid.parents('li').addClass('am-active');
        tabid.addClass('am-active');
        $('.am-nav-tabs').niceScroll({
            cursorcolor: "#ccc",//#CC0071 光标颜色
            cursoropacitymax: 1, //改变不透明度非常光标处于活动状态（scrollabar“可见”状态），范围从1到0
            touchbehavior: false, //使光标拖动滚动像在台式电脑触摸设备
            cursorwidth: "6px", //像素光标的宽度
            cursorborder: "0", // 游标边框css定义
            nativeparentscrolling: true,
            cursorborderradius: "5px",//以像素为光标边界半径
            autohidemode: false //是否隐藏滚动条
        });
        //删除内容
        function defun(e) {
            var dfid = $(e).attr('name');
            $(e).parents(".am-article");
            layer.msg('确定删除内容吗？', {
                time: 0 //不自动关闭
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    layer.close(index);
//                    点击确定之后请求删除接口
                    var url = '/admin/item/material/delete/' + dfid;
                    AjaxJson(url,{},function (data) {
                        if(data.status == 1) {
                            layer.msg(data.msg);
                            $(e).parents(".am-article").remove();
                        }else {
                            layer.msg(data.msg);
                        }
                    });
                }
            });
        }
    </script>
@endsection