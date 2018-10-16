@extends('layouts.admin-app')
@section('title', '部门管理')

@section('css')
    @parent
    <link rel="stylesheet" href=" {{ url('css/main.css') }}">
    <style type="text/css">
        .edui-container {
            width: 100% !important;
        }

        .am-form-horizontal .am-form-label {
            text-align: right;
            font-weight: normal;
        }
        .layui-layer-btn {
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <div class="dh-main">
        <div class="am-g">
            <div class="am-u-sm-3 am-u-md-3 am-u-lg-2 bgfff" id="leftNav">
                {{--左侧菜单--}}
                @include('admin._partials.rbac-left-menu')
            </div>
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10" id="rightMain">
                <div class="dh-main-container">
                    <p class="title fs18">
                        <a href="{{ route('template.material',[$materials[1]->material_template_names->id]) }}"><i class="iconfont">&#xe604;</i></a>
                        材料清单 <span>部门管理</span>
                    </p>
                    <div class="pro-card">
                        <p><a href="#" class="am-btn am-btn-primary br5px" data-am-modal="{target: '#doc-modal-1', closeViaDimmer: 0}">添加新部门</a></p>
                        <div class="am-g card-box">
                            <div class="am-u-sm-5"><div class="am-padding-left-lg">部门名称</div></div>
                            <div class="am-u-sm-5"><div class="am-padding-left-lg">操作</div></div>
                        </div>
                        <ul class="am-list">
                            @foreach($materials as $material)
                                <li class="am-g am-padding-left-lg card-box">
                                    <a class="am-u-sm-5" href="#">{{ $material->department }}</a>
                                    <div class="am-u-sm-5" style="padding: 1rem">
                                        {{--@if(Entrust::can('material.destroy'))--}}
                                            <a href="#" class="am-margin-right" name="{{$material->id}}" onclick="editfun(this)">编辑</a>
                                        {{--@endif--}}
                                        {{--@if(Entrust::can('material.destroy'))--}}
                                            <a href="#" name="{{$material->id}}" onclick="dffun(this)" class="colorred">删除</a>
                                        {{--@endif--}}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                            {{ $materials->render() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!--模态框-----------------------------strat-->
    {{--新增部门--}}
    <div class="am-modal am-modal-no-btn" id="doc-modal-1">
        <div class="am-modal-dialog Staff-modal-dialog" style="width: 560px;">
            <div class="am-modal-hd">
                <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i><span>新增部门</span></span>
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <div class="am-modal-bd rights-modal am-margin-top">
                <div class="lindiv"></div>
                <form class="am-form am-form-horizontal" id="addmkform" style="padding:20px 40px;" action="{{ route('template.material.sub.store',[$materials[1]->material_template_names->id]) }}" method="post">
                    {{ csrf_field() }}
                    <div class="am-form-group">
                        <label class="am-u-sm-4 am-form-label"><span
                                    class="colorred">* </span><span>部门名称：</span></label>
                        <div class="am-u-sm-8">
                            <input name="department" class="br5px" type="text" datatype="*" nullmsg="请输入部门名称"/>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <div class="am-u-sm-10 am-u-sm-offset-2">
                            <button type="submit" class="am-btn am-btn-primary br5px">提交</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--编辑部门--}}
    <div class="am-modal am-modal-no-btn" id="editmodal">
        <div class="am-modal-dialog Staff-modal-dialog" style="width: 560px;">
            <div class="am-modal-hd">
                <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i><span>编辑部门</span></span>
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <div class="am-modal-bd rights-modal am-margin-top">
                <div class="lindiv"></div>
                <form class="am-form am-form-horizontal" id="editmkform" style="padding:20px 40px;" method="post">
                    <div class="am-form-group">
                        <label class="am-u-sm-4 am-form-label"><span
                                    class="colorred">* </span><span>部门名称：</span></label>
                        <div class="am-u-sm-8">
                            <input name="department" id="editinput" class="br5px" type="text" datatype="*" nullmsg="请输入部门名称"/>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <div class="am-u-sm-10 am-u-sm-offset-2">
                                <button type="button" id="editsub" class="am-btn am-btn-primary br5px">提交</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    @parent
    <script src=" {{ url('js/main.js') }}" type="text/javascript" charset="utf-8"></script>
    <script>

        $("#addmkform").Validform({
            tiptype: function (msgs, o, cssctl) {
                if (o.type != 2) {     //只有不正确的时候才出发提示，输入正确不提示
                    layer.msg(msgs);
                }
            },
            ajaxPost: false,//true用ajax提交，false用form方式提交
            tipSweep: true,//true只在提交表单的时候开始验证，false每输入完一个输入框之后就开始验证
            beforeSubmit: function (curform) {

            },
            callback: function (rq) {

            }

        });

        //编辑
        function editfun(e) {
            $("#editsub").attr("name",$(e).attr("name"));
            var url = '/admin/template/material/sub/'+ $(e).attr("name") +'/edit';

        //调取数据填充到编辑模态框去
            AjaxJson(url,{},function (data) {
                $("#editinput").val(data.department);
            });
            $("#editmodal").modal();
        };

        //点击了编辑模态框里面的提交按钮之后的动作
        $("#editsub").click(function () {
            var url = '/admin/template/material/sub/'+ $("#editsub").attr("name") +'/update';
            var department = $("#editinput").val();
            AjaxJson(url,{department:department},function (data) {
                if(data.status == 1){
                    layer.msg(data.msg);
                    window.location.reload()
                }else {
                    window.location.reload();
                    layer.msg(data.msg)
                }
            });
        });

        //删除
        function dffun(e) {
            var dfidsu = $(e).attr("name");
            var url = '/admin/template/material/sub/' + dfidsu +'/destroy';
            layer.msg('确定删除该部门吗？删除之后数据将无法恢复！', {
                time: 0 //不自动关闭
                , btn: ['确定', '取消']
                , yes: function (index) {
                    AjaxJson(url,{},function (data) {
                        if(data.status == 1){
                            layer.msg(data.msg)
                            window.location.reload();
                        }
                    })
                }
            });
        }
    </script>
@endsection