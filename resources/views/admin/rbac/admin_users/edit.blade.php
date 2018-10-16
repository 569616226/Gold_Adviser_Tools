@extends('layouts.admin-app')
@section('title', '员工管理')
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
                          action="{{ route('admin_user.update',[$user->id]) }}" method="post">
                        <p class="title fs18">
                            <a href="{{ route('admin_user.index') }}"><i class="iconfont">&#xe604;</i></a>编辑员工信息 (
                            <span>用户名：<span>{{ $user->name }}</span></span> )

                        </p>

                        <div class=" marginT30px">
                            <div class="bgfff paddt30px paddb30px">
                                {{ method_field('PUT') }}
                                {{ csrf_field() }}
                                <div>
                                    <div class="am-form-group am-u-sm-6" style="padding: 0;">
                                        <label class="am-u-sm-3 am-form-label"><span
                                                    class="colorred">* </span>姓名:</label>
                                        <div class="am-u-sm-9">
                                            <input name="name" class="br5px" type="text" placeholder="请输入姓名" datatype="*" nullmsg="请输入姓名" sucmsg=" " value="{{ $user->name }}"
                                                   datatype="*" nullmsg="姓名不能为空" sucmsg=" " />
                                        </div>
                                    </div>

                                    <div class="am-form-group am-u-sm-6" style="padding: 0;">
                                        <label class="am-u-sm-3 am-form-label"><span
                                                    class="colorred">* </span>密码:</label>
                                        <div class="am-u-sm-9">
                                            <input name="password" class="br5px" type="text"
                                                   placeholder="请输入密码(不填写则不修改)" datatype="*6-20" ignore="ignore"
                                                   sucmsg=" " errormsg="请输入6到20位的密码"/>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <div class="am-form-group am-u-sm-6" style="padding: 0;">
                                        <label class="am-u-sm-3 am-form-label"><span
                                                    class="colorred">* </span>手机号:</label>
                                        <div class="am-u-sm-9">
                                            <input name="tel" class="br5px" type="text" placeholder="请输入手机号" onkeyup="replaceAndSetPos(this,/[\u4E00-\u9FA5\s]/g,'')" oninput="replaceAndSetPos(this,/[\u4E00-\u9FA5\s]/g,'')" datatype="m" nullmsg="请输入手机号" sucmsg=" " errormsg="请输入合法手机号"
                                                   value="{{ $user->tel }}"/>
                                        </div>
                                    </div>

                                    <div class="am-form-group am-u-sm-6" style="padding: 0;">
                                        <label class="am-u-sm-3 am-form-label">电子邮箱:</label>
                                        <div class="am-u-sm-9">
                                            <input name="email" class="br5px" type="text" placeholder="请输入电子邮箱"
                                                   value="{{ $user->email }}" ignore="ignore" datatype="e"
                                                   errormsg="请输入合法邮箱" sucmsg=" "/>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-box">
                                    <div class="am-form-group am-u-sm-6" style="padding: 0;">
                                        <label class="am-u-sm-3 am-form-label"><span
                                                    class="colorred">* </span>选择角色:</label>
                                        <div class="am-u-sm-9">
                                            <select name="roles[]" class="br5px" multiple data-am-selected>
                                                @foreach($roles as $role)
                                                    @if(in_array($role->id,$user->roles()->pluck('id')->toArray()))
                                                        <option selected="selected"
                                                                value="{{ $role->id }}">{{ $role->display_name }}</option>
                                                    @else
                                                        <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="am-text-center am-u-sm-12 am-margin-top am-form-group">
                                    @if( Entrust::can('admin_user.edit'))
                                        <button id="editformsub" class="am-btn am-btn-secondary br5px">保存</button>
                                        <a class="am-btn am-btn-white br5px am-margin-left" href="{{ route('admin_user.index') }}">取消</a>
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