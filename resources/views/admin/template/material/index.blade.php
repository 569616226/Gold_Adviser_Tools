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
    </style>
@endsection

@section('content')
    <div class="dh-main">
        <div class="am-g">
            <div class="am-u-sm-3 am-u-md-3 am-u-lg-2 bgfff" id="leftNav">
                <!--左侧菜单-->
                @include('admin._partials.rbac-left-menu')
            </div>
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10" id="rightMain">
                <div class="dh-main-container">
                    <p class="title fs16"><a href="{{ route('template.index') }}"><i class="iconfont">&#xe604;</i></a>材料清单模版管理
                        {{--@if(Entrust::can('material.depart'))--}}
                            <a href="{{ route('material.depart') }}" class="am-fr am-btn am-btn-primary br5px">部门管理</a>
                        {{--@endif--}}
                    </p>
                    <div class="pro-card" style="padding: 0;">
                        <div class="am-tabs" data-am-tabs>
                            <ul class="am-tabs-nav am-nav am-nav-tabs">
                                @foreach($maters as $mater)
                                    <li>
                                        <a style="position: relative"
                                           href="#tab{{ $mater->id }}">{{ $mater->department }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="am-tabs-bd paddlr20px">
                                @foreach($maters as $mater)
                                    <div class="am-tab-panel am-fade am-in" id="tab{{ $mater->id }}">
                                        <article class="am-article">
                                            <div class="am-article-hd">
                                                <a href="{{ route('template.material.create',[$mater->id]) }}" class="am-fr am-btn am-btn-white br5px">新增内容</a>
                                            </div>
                                        </article>
                                        @foreach($mater->material_content_templates as $material_content_template)
                                        <article class="am-article">
                                            <div class="am-article-hd">
                                                <p class="am-article-title fs20">
                                                    <span></span>
                                                    <a href="javascript:void(0);" name="{{$material_content_template->id}}" class="hovera am-btn am-btn-white am-fr br5px am-margin-left-xs"  onclick="defun(this)">删除</a>
                                                    <a href="{{ route('template.material.edit',[$material_content_template->id]) }}" class="am-btn am-btn-white am-fr br5px">编辑</a>

                                                </p>
                                            </div>
                                            <div class="am-article-bd">
                                               <h2>{{ $material_content_template->name }}</h2>
                                            </div>
                                            <div class="am-article-bd">
                                                {!!  html_entity_decode(stripslashes( $material_content_template->content )) !!}
                                            </div>
                                            <div class="lindiv"></div>
                                        </article>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--删除部门模态框-->
    <div class="am-modal am-modal-no-btn" id="df-modal">
        <div class="am-modal-dialog Staff-modal-dialog" style="width: 560px;">
            <div class="am-modal-hd">
                <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i><span>删除部门</span></span>
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <div class="am-modal-bd rights-modal am-margin-top">
                <div class="lindiv"></div>
                <p class="am-text-center">
                    确定删除该审核部门吗？删除审核部门后，审核数据将无法恢复
                </p>
                <p>
                    <button class="am-btn am-btn-primary br5px" name="" id="dfsuer">确定</button>
                    <button class="am-btn br5px" data-am-modal-close>取消</button>
                </p>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    @parent
    <script src=" {{ url('js/main.js') }}" type="text/javascript" charset="utf-8"></script>
    <script>
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
        //移除
        function dftab(e) {
            var dfid = $(e).attr('name');
            $("#dfsuer").attr('name', dfid);
            $('#df-modal').modal();
        }
        $("#dfsuer").click(function (e) {
            var dfidsu = $("#dfsuer").attr("name");
            var dfurl = '/admin/template/material/delete/' + dfidsu;
            AjaxJson(dfurl, {}, function (data) {
                if (data.status == 1) {
                    layer.msg(data.msg);
                    window.location.reload()
                } else {
                    layer.msg(data.msg);
                }
            });
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
                    var url = '/admin/template/material/delete/' + dfid;
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