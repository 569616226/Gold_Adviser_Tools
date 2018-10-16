@extends('layouts.admin-app')
@section('title', '法律法规')

@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="/../js/umeditor/themes/default/css/umeditor.min.css"/>
    <link rel="stylesheet" href="/../css/main.css">
    <style type="text/css">
        .edui-container {
            width: 100% !important;

        }
        .edui-body-container {
            min-height: 250px !important;
        }
    </style>
@endsection

@section('content')
    <div class="dh-main">
        <div class="am-g">
            <div class="am-u-sm-3 am-u-md-3 am-u-lg-2 bgfff" id="leftNav">

                @include('admin._partials.rbac-left-menu')
            </div>
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10" id="rightMain">
                <!--项目概况-->
                <div class="dh-main-container">
                    <p class="title fs18">法律法规管理
                        @if( Entrust::can('law.create'))
                            <button class="am-fr am-btn am-btn-secondary br5px" data-am-modal="{target: '#doc-modal-1', closeViaDimmer: 0}">
                                新增法律法规
                            </button>
                        @endif
                    </p>
                    <div class="search">
                        <form action="{{ route('law.search') }}" class="am-form am-form-horizontal am-form-inline" id="search-form" method="POST">
                            {{ csrf_field() }}
                            <div class="am-form-group">
                                <input style="width: 250px" type="text" name="searchStr"
                                       placeholder="可输入法律法规名称/部分关键词"/>
                            </div>
                            <div class="am-input-group">
                                <a href="#" class="bgql colorw am-btn am-btn-secondary" onclick="event.preventDefault();document.getElementById('search-form').submit();"><i class="am-icon-search"></i> 搜索</a>
                            </div>
                        </form>
                    </div>
                    @if(isset($laws))
                    <table class="am-table bgfff marginT30px am-table-bordered am-table-hovernew">
                        <thead>
                        <tr>
                            <th style="min-width: 70px;" class="am-text-center">序号</th>
                            <th class="am-text-center" style="min-width: 120px; max-width: 180px">法规条例名称</th>
                            <th class="am-text-center" style="min-width: 120px;">法规条例文号</th>
                            <th class="am-text-center" style="min-width: 120px;">法规条例条号</th>
                            <th class="am-text-center" style="max-width: 480px; overflow: auto;">法规条例内容</th>
                            <th style="min-width: 170px;" class="am-text-center">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($laws as $law)
                            <tr>
                                <td class="am-text-middle am-text-center">{{ $law->id }}</td>
                                <td class="am-text-middle" style="min-width: 120px; max-width: 180px">{{ $law->name }}</td>
                                <td class="am-text-middle am-text-center">{{ $law->title }}</td>
                                <td class="am-text-middle am-text-center">第{{ $law->title_no }}条</td>
                                <td class="am-text-middle Textcontent" style="max-width: 480px; overflow: auto">
                                    {!!  html_entity_decode(stripslashes($law->content)) !!}
                                </td>
                                <td class="am-text-middle am-text-center">
                                    <div class="am-btn-group">
                                        @if(Entrust::can('law.edit'))
                                            <a href="{{ route('law.edit',[$law->id]) }}" class="am-btn am-btn-primary am-radius">编辑</a>
                                        @endif
                                        @if(Entrust::can('law.destroy'))
                                            <button type="button" class="am-btn am-btn-danger  am-radius"
                                                    data-am-modal="{target: '#doc-modal-4', closeViaDimmer: 0}">删除
                                            </button>

                                            <!--删除---------------------------start-->
                                            <div class="am-modal am-modal-no-btn" id="doc-modal-4">
                                                <div class="am-modal-dialog modalwidth-xxs">
                                                    <div class="am-modal-hd">
                                                        <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i><span>删除法律法规</span></span>
                                                        <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
                                                    </div>
                                                    <div class="am-modal-bd rights-modal am-margin-top">
                                                        <div class="lindiv"></div>
                                                        <p class="am-text-center">
                                                            确定删除该法律法规吗？
                                                        </p>
                                                        <p>
                                                            <button class="am-btn am-btn-primary br5px" onclick="event.preventDefault();
                                                                document.getElementById('delete-form-{{ $law->id }}df').submit();">
                                                                确定
                                                            </button>
                                                            <button class="am-btn br5px" data-am-modal-close>取消</button>
                                                        <form id="delete-form-{{ $law->id }}df"
                                                              action="{{ route('law.destroy',[ $law->id ]) }}"
                                                              method="POST" style="display: none;">
                                                            {{ method_field('DELETE') }}
                                                            {{ csrf_field() }}
                                                        </form>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--删除---------------------------end-->
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $laws->render() }}
                    @else
                        <table class="am-table bgfff marginT30px am-table-bordered am-table-hovernew">
                            <thead>
                            <tr>
                                <th style="min-width: 70px;" class="am-text-center">序号</th>
                                <th class="am-text-center" style="min-width: 120px; max-width: 180px">法规条例名称</th>
                                <th class="am-text-center" style="min-width: 120px;">法规条例文号</th>
                                <th class="am-text-center" style="min-width: 120px;">法规条例条号</th>
                                <th class="am-text-center" style="max-width: 480px; overflow: auto;">法规条例内容</th>
                                <th style="min-width: 170px;" class="am-text-center">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="6">没有任何数据被发现</td>
                                </tr>
                            </tbody>
                        </table>
                    @endif


                </div>
            </div>

        </div>
    </div>

    <!--模态框-----------------------------strat-->

    <!--新增审核机构模态框---------------------------strat-->
    <div class="am-modal am-modal-no-btn" id="doc-modal-1">
        <div class="am-modal-dialog modalwidth-md">
            <div class="am-modal-hd">
                <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i>新增法律法规</span>
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <div class="am-modal-bd rights-modal am-margin-top">
                <div class="lindiv"></div>
                <form class="am-form am-form-horizontal am-margin-top" id="addkhform" action="{{ route('law.store') }}" method="post">
                {{ csrf_field() }}
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>法律法规名称:</label>
                        <div class="am-u-sm-10">
                            <input name="name" class="br5px" type="text" placeholder="请输入法律法规名称" datatype="*" nullmsg="请输入法律法规名称">
                        </div>
                    </div>
                    <!--一排一列-->
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>法规条例文号:</label>
                        <div class="am-u-sm-10">
                            <input name="title" class="br5px" type="text" placeholder="请输入法规条例文号" datatype="*" nullmsg="请输入法规条例文号">
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>法规条例条号:</label>
                        <div class="am-u-sm-10 am-text-left">
                                <span>第</span> <input name="title_no" class="br5px" type="text" datatype="*" nullmsg="请输入法规条例条号" style="width: 50px;display: inline-block; position: relative; top: -3px;">
                                <span>条</span>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>法规条例内容:</label>
                        <div class="am-u-sm-10 am-text-left">
                            <input type="hidden" id="content" name="content" datatype="*" nullmsg="请输入法规条例内容">
                            <script type="text/plain" id="myEditor" ></script>
                        </div>
                    </div>
                    <div class= "am-form-group" >
                        @if(Entrust::can('law.create'))
                            <button type="submit" id="addformsub" class="am-btn am-btn-secondary br5px am-margin-top"> 提交 </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection
    @section('javascript')
    @parent
    <script src="/../js/umeditor/third-party/template.min.js" type="text/javascript" charset="utf-8" ></script>
    <script src="/../js/umeditor/umeditor.config.js" type="text/javascript"
            charset="utf-8"></script>
    <script src="/../js/umeditor/umeditor.min.js" type="text/javascript"
            charset="utf-8"></script>
    <script src="/../js/main.js" type="text/javascript" charset="utf-8"></script>
    <script>
        //实例化编辑器
        var um = UM.getEditor('myEditor');
        //获取富文本编辑内容（带格式）
        um.addListener('blur', function () {
            getContent()
        });
        function getContent() {
            var arr = [];
            arr.push(UM.getEditor('myEditor').getContent());
            $("#content").val(arr)
        }
        var addkhform = $("#addkhform").Validform({
            btnSubmit: "#addformsub",
            tiptype: function (msgs, o, cssctl) {
                if (o.type != 2) { //只有不正确的时候才出发提示，输入正确不提示
                    layer.msg(msgs);
                }
            },
            ajaxPost: false, //true用ajax提交，false用form方式提交
            tipSweep: true, //true只在提交表单的时候开始验证，false每输入完一个输入框之后就开始验证
            beforeSubmit: function (curform) {
                openLoad();
            }
        });
    </script>
@endsection