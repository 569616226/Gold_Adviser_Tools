@extends('layouts.admin-app')
@section('title', '审核机构')

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
                          action="{{ route('mech.update',[$mech->id]) }}" method="post">
                        <p class="title fs18">
                            <a href="{{ route('mech.index') }}"><i class="iconfont">&#xe604;</i></a>编辑审核机构
                            ({{  $mech->name }})

                        </p>
                        <div class=" marginT30px">
                            <div class="bgfff paddt30px paddb30px">
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}
                            <!--一排两列-->
                                <div class="am-form-group">
                                    <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>名称:</label>
                                    <div class="am-u-sm-10" style="padding-left: 0;">
                                        <div class="am-u-sm-5">
                                            <input name="name" value="{{ $mech->name }}" type="text"
                                                   class="am-form-field" placeholder="请输入名称" datatype="*"
                                                   nullmsg="请输入名称"/>
                                        </div>
                                        <label class="am-u-sm-2 am-form-label"><span
                                                    class="colorred"></span>邮政编码:</label>
                                        <div class="am-u-sm-5" style="padding-right: 0;">
                                            <input name="zip_code" value="{{ $mech->zip_code }}" class="br5px" type="text" placeholder="请输入邮政编码" ignore="ignore" datatype="p" errormsg="请输入合法邮政编码" />
                                        </div>
                                    </div>
                                </div>
                                <!--一排一列-->
                                <div class="am-form-group">
                                    <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>通讯地址:</label>
                                    <div class="am-u-sm-10">
                                        <input name="address" value="{{ $mech->address }}" class="br5px" type="text"
                                               placeholder="请输入通讯地址" datatype="*" nullmsg="请输入通讯地址" />
                                    </div>
                                </div>

                                <!--一排两列-->
                                <div class="am-form-group">
                                    <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>审核团队:</label>
                                    <div class="am-u-sm-10" style="padding-left: 0;">
                                        <div class="am-u-sm-5">
                                            <input name="verify_team" value="{{ $mech->verify_team }}" type="text"
                                                   class="br5px" placeholder="请输入审核团队" datatype="*" nullmsg="请输入审核团队"/>
                                        </div>
                                        <label class="am-u-sm-2 am-form-label"><span
                                                    class="colorred">* </span>电子邮箱:</label>
                                        <div class="am-u-sm-5" style="padding-right: 0;">
                                            <input name="email" value="{{ $mech->email }}" class="br5px" type="text" placeholder="请输入电子邮箱" datatype="e" nullmsg="请输入电子邮箱" errormsg="请输入合法的邮箱地址" />
                                        </div>
                                    </div>
                                </div>

                                <!--一排两列-->
                                <div class="am-form-group">
                                    <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>负责人:</label>
                                    <div class="am-u-sm-10" style="padding-left: 0;">
                                        <div class="am-u-sm-5">
                                            <input name="master" value="{{ $mech->master }}" type="text" class="br5px"
                                                   placeholder="请输入负责人" datatype="*" nullmsg="请输入负责人"/>
                                        </div>
                                        <label class="am-u-sm-2 am-form-label"><span
                                                    class="colorred">* </span>项目督导</label>
                                        <div class="am-u-sm-5" style="padding-right: 0;">
                                            <input name="super" value="{{ $mech->super }}" class="br5px" type="text"
                                                   placeholder="请输入项目督导" datatype="*" nullmsg="请输入项目督导" />
                                        </div>
                                    </div>
                                </div>

                                <!--一排两列-->
                                <div class="am-form-group">
                                    <label class="am-u-sm-2 am-form-label"><span
                                                class="colorred">* </span>负责人电话:</label>
                                    <div class="am-u-sm-10" style="padding-left: 0;">
                                        <div class="am-u-sm-5">
                                            <input name="master_tel" value="{{ $mech->master_tel }}" type="text"
                                                   class="br5px" placeholder="请输入负责人电话" datatype="guhua|m"
                                                   nullmsg="请输入负责人电话" errormsg="请输入合法的电话号码" />
                                        </div>
                                        <label class="am-u-sm-2 am-form-label"><span
                                                    class="colorred">* </span>项目督导电话:</label>
                                        <div class="am-u-sm-5" style="padding-right: 0;">
                                            <input name="super_tel" value="{{ $mech->super_tel}}" class="br5px"
                                                   type="text" placeholder="请输入项目督导电话" datatype="guhua|m" nullmsg="请输入项目督导电话" errormsg="请输入合法的电话号码" />
                                        </div>
                                    </div>
                                </div>
                                <!--一排两列-->
                                <div class="am-form-group">
                                    <label class="am-u-sm-2 am-form-label"><span
                                                class="colorred"></span>负责人传真:</label>
                                    <div class="am-u-sm-10" style="padding-left: 0;">
                                        <div class="am-u-sm-5">
                                            <input name="master_fax" value="{{ $mech->master_fax }}" type="text" class="br5px" placeholder="请输入负责人传真" ignore="ignore" datatype="guhua|m" errormsg="请输入合法传真格式" />
                                        </div>
                                        <label class="am-u-sm-2 am-form-label"><span
                                                    class="colorred"></span>项目督导传真:</label>
                                        <div class="am-u-sm-5" style="padding-right: 0;">
                                            <input name="super_fax" value="{{ $mech->super_fax }}" class="br5px"
                                                   type="text" placeholder="请输入项目督导传真" ignore="ignore" datatype="guhua|m" errormsg="请输入合法传真格式" >
                                        </div>
                                    </div>
                                </div>
                                <div class="am-text-center am-u-sm-12 am-margin-top am-form-group">
                                    @if(Entrust::can('mech.edit'))
                                        <button id="editformsub" class="am-btn am-btn-secondary br5px">保存</button>
                                        <a class="am-btn am-btn-white br5px am-margin-left" href="{{ route('mech.index') }}">取消</a>
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
        $("input[name='username']").each(function (e) {
            $(this).blur(function () {
                var valtext = $(this).val();
                $.post("admin_user/checkdata", {username: valtext}, function (data, status) {
                    if (data.status == 1) {
                        layer.msg(data.msg)
                    }
                });
            })
        });
        var editygformobj = $("#editform").Validform({
            btnSubmit: "#editformsub",
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
