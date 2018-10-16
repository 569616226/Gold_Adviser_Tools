@extends('layouts.admin-app')
@section('title', '角色管理')
@section('css')
    @parent
    <link rel="stylesheet" href="/../css/main.css">
    <style type="text/css">
        .edui-container {
            width: 100% !important;
        }
    </style>
@endsection


@section('content')
    <div class="dh-main">
        <div class="am-g">
            <div class="am-u-sm-3 am-u-md-3 am-u-lg-2 bgfff" id="leftNav">
                <!--右侧菜单-->
                @include('admin._partials.rbac-left-menu')
            </div>
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10" id="rightMain">
                <div class="dh-main-container">
                    <form class="am-form am-form-horizontal" id="editform"
                          action="{{ route('role.update',[$role->id]) }}" method="post">
                        <p class="title fs18">
                            <a href="{{ route('role.index') }}"><i class="iconfont">&#xe604;</i></a>编辑角色
                            ({{ $role->display_name }})

                        </p>
                        <div class=" marginT30px">
                            <div class="pro-card">
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}
                            <!--一排两列-->
                                <div class="am-form-group">
                                    <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>标识</label>
                                    <div class="am-u-sm-10" style="padding-left: 0;">
                                        <div class="am-u-sm-5">
                                            <input name="name" value="{{ $role->name }}" class="br5px" type="text"
                                                   placeholder="请输入标识" datatype="*" nullmsg="请输入标识" sucmsg=" "/>
                                        </div>
                                        <label class="am-u-sm-2 am-form-label"><span
                                                    class="colorred">* </span>角色名</label>
                                        <div class="am-u-sm-5" style="padding-right: 0;">
                                            <input name="display_name" value="{{ $role->display_name }}" class="br5px"
                                                   type="text" placeholder="请输入用户名" datatype="*" nullmsg="请输入用户名"
                                                   sucmsg=" "/>
                                        </div>
                                    </div>
                                </div>
                                <!--<div>
                                    <div class="am-u-sm-2"><label class="am-u-sm-3 am-form-label"><span class="colorred"></span>说明:</label></div>
                                    <div class="am-u-sm-10" style="padding-left: 0; position: relative; left: -40px;">
                                        <textarea class="br5px" rows="6"></textarea>
                                    </div>
                                </div>-->
                                <!--一排一列-->
                                <div class="am-form-group">
                                    <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>说明</label>
                                    <div class="am-u-sm-10">
                                        <textarea name="description" class="br5px minheight-xxs">{{ $role->description }}</textarea>
                                    </div>
                                </div>
                                <div class="am-text-center am-margin-top am-form-group">
                                    @if( Entrust::can('role.edit'))
                                        <button id="editformsub" class="am-btn am-btn-secondary br5px">保存</button>
                                        <a class="am-btn am-btn-white br5px am-margin-left" href="{{ route('role.index') }}">取消</a>
                                    @endif
                                </div>
                                <div style="clear: both;"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('javascript')
    @parent
    <script src="/../js/main.js" type="text/javascript" charset="utf-8"></script>
    <script>
        var editygformobj = $("#editform").Validform({
            btnSubmit: "#editformsub",
            tiptype: function (msgs, o, cssctl) {
                if (o.type != 2) { //只有不正确的时候才出发提示，输入正确不提示
                    layer.msg(msgs);
                }
            },
            ajaxPost: false, //true用ajax提交，false用form方式提交
            tipSweep: true, //true只在提交表单的时候开始验证，false每输入完一个输入框之后就开始验证

        });
    </script>
@endsection