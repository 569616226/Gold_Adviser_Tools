@extends('layouts.admin-app')
@section('title', '子账号管理-客户管理')
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
                @include('admin._partials.rbac-left-menu')
            </div>
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10" id="rightMain">
                <div class="dh-main-container">
                    <form class="am-form am-form-horizontal" id="editform"
                          action="{{ route('depart.update',[$depart->id,$user->id]) }}" method="POST">
                        <p class="title">
                            <a href="{{ route('depart.show',[$user->id]) }}"><i class="iconfont">&#xe604;</i></a>编辑子账号 (
                            <span>用户名：<span>{{ $depart->username }}</span></span> )
                        </p>
                        <div class=" marginT30px">
                            <div class="pro-card">
                                {{--{{ method_field('PUT') }}--}}
                                {{ csrf_field() }}
                                <div>
                                    <div class="am-form-group am-u-sm-6" style="padding: 0;">
                                        <label class="am-u-sm-3 am-form-label"><span
                                                    class="colorred">* </span>姓名:</label>
                                        <div class="am-u-sm-9">
                                            <input name="name" value="{{ $depart->name }}" class="br5px" type="text" placeholder="请输入姓名" datatype="*" nullmsg="请输入姓名" sucmsg=" "/>
                                        </div>
                                    </div>
                                </div>
                                <div class="am-form-group am-u-sm-6" style="padding: 0;">
                                    <label class="am-u-sm-3 am-form-label"><span class="colorred">* </span>选择职位:</label>
                                    <div class="am-u-sm-9">
                                        <select name="roles[]" class="br5px" multiple data-am-selected>
                                            @foreach($roles as $role)
                                                @if(in_array($role->id,$depart->croles()->pluck('id')->toArray()))
                                                    <option selected="selected"
                                                            value="{{ $role->id }}">{{ $role->display_name }}</option>
                                                @else
                                                    <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <div class="am-form-group am-u-sm-6" style="padding: 0;">
                                        <label class="am-u-sm-3 am-form-label"><span
                                                    class="colorred">* </span>密码:</label>
                                        <div class="am-u-sm-9">
                                            <input name="password" class="br5px" type="text" placeholder="请输入密码（不填写就是不修改）" ignore="ignore" datatype="*6-20" nullmsg="请输入密码" errormsg="请输入6到12位密码"/>
                                        </div>
                                </div>
                                <div class="am-form-group am-u-sm-12 am-margin-top-lg am-text-center">
                                    @if(Entrust::can('depart.edit'))
                                        <button id="editformsub" class="am-btn am-btn-secondary br5px">保存</button>
                                        <a class="am-btn am-btn-white br5px am-margin-left" href="{{ route('depart.show',[$user->id]) }}">取消</a>
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
            //ajax提交完之后的回调函数
            callback: function (rq) {

            }

        });
    </script>
@endsection