@extends('layouts.admin-app')
@section('title', '客户管理')
@section('css')
    @parent
    <link rel="stylesheet" href="/../css/main.css">
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
                    <form class="am-form am-form-horizontal" id="editform" action="{{ route('user.update',[$user->id]) }}" method="POST">
                        <p class="title">
                            <a href="{{ route('user.index') }}"><i class="iconfont">&#xe604;</i></a>编辑客户信息
                            ({{ $user->name }})

                        </p>
                        <div class=" marginT30px pro-card" style="padding-right: 10%;">
                            <div class="bgfff paddt30px paddb30px">
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}
                            <!--一排一列-->
                                <div class="am-form-group">
                                    <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>注册名称</label>
                                    <div class="am-u-sm-10">
                                        <input name="name" value="{{ $user->name }}" class="br5px" type="text" placeholder="请输入你的注册名称" datatype="*" nullmsg="请输入你的注册名称">
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>企业注册地址</label>
                                    <div class="am-u-sm-10">
                                        <input name="address" value="{{ $user->address }}" class="br5px" type="text" placeholder="请输入企业注册地址" datatype="*" nullmsg="请输入企业注册地址">
                                    </div>
                                </div>
                                <!--一排两列-->
                                <div class="am-form-group">
                                    <label class="am-u-sm-2 am-form-label"><span
                                                class="colorred">* </span>企业联系电话</label>
                                    <div class="am-u-sm-10" style="padding-left: 0;">
                                        <div class="am-u-sm-5">
                                            <input name="tel" value="{{ $user->tel }}" type="text" class="br5px" placeholder="请输入企业联系电话" onkeyup="replaceAndSetPos(this,/[\u4E00-\u9FA5\s]/g,'')" oninput="replaceAndSetPos(this,/[\u4E00-\u9FA5\s]/g,'')" datatype="guhua|m" nullmsg="请输入企业联系电话" errormsg="请输入正确格式的手机号码或者固定电话" />
                                        </div>
                                        <label class="am-u-sm-2 am-form-label"><span class="colorred"></span>企业传真号码</label>
                                        <div class="am-u-sm-5" style="padding-right: 0;">
                                            <input name="fax" value="{{ $user->fax }}" class="br5px" type="text" onkeyup="replaceAndSetPos(this,/[\u4E00-\u9FA5\s]/g,'')" oninput="replaceAndSetPos(this,/[\u4E00-\u9FA5\s]/g,'')" placeholder="请输入企业传真号码" datatype="guhua|m" ignore="ignore" nullmsg="请输入企业传真号码" errormsg="请输入合法传真号码" \>
                                        </div>
                                    </div>
                                </div>
                                <!--一排两列-->
                                <div class="am-form-group">
                                    <label class="am-u-sm-2 am-form-label"><span class="colorred"></span>企业联系邮箱</label>
                                    <div class="am-u-sm-10" style="padding-left: 0;">
                                        <div class="am-u-sm-5">
                                            <input id="" name="email" value="{{ $user->email }}" type="text" onkeyup="replaceAndSetPos(this,/[\u4E00-\u9FA5\s]/g,'')" oninput="replaceAndSetPos(this,/[\u4E00-\u9FA5\s]/g,'')" class="am-form-field" placeholder="请输入企业联系邮箱" ignore="ignore" datatype="e"/>
                                        </div>
                                        <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>成立日期</label>
                                        <div class="am-u-sm-5" style="padding-right: 0;">
                                            <input name="create_date" value="{{ $user->create_date->toDateString() }}" type="text" class="am-form-field" placeholder="请选择成立日期" data-am-datepicker readonly required datatype="*" nullmsg="请选择成立日期"/>
                                        </div>
                                    </div>
                                </div>
                                <!--一排两列-->
                                <div class="am-form-group">
                                    <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>注册资本</label>
                                    <div class="am-u-sm-10" style="padding-left: 0;">
                                        <div class="am-u-sm-5">
                                            <input name="capital" value="{{ $user->capital }}" type="text" class="br5px" placeholder="请输入注册资本" datatype="*" nullmsg="请输入注册资本"/>
                                        </div>
                                        <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>海关识别码</label>
                                        <div class="am-u-sm-5" style="padding-right: 0;">
                                            <input name="code" value="{{ $user->code }}" class="br5px" type="text" placeholder="请输入你的海关识别码" maxlength="10" datatype="hgsbm" nullmsg="请输入你的海关识别码" errormsg="请输入10位合法海关识别码" onkeyup="replaceAndSetPos(this,/[\u4E00-\u9FA5\s]/g,'')" oninput="replaceAndSetPos(this,/[\u4E00-\u9FA5\s]/g,'')"  />
                                        </div>
                                    </div>
                                </div>
                                <!--一排两列-->
                                <div class="am-form-group">
                                    <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>AEO认证</label>
                                    <div class="am-u-sm-10" style="padding-left: 0;">
                                        <div class="am-u-sm-5">
                                            <div class="am-input-group br5px widthMax">
                                                <select class="br5px" {{ isset($user->hands->items) ? 'disabled' : '' }} name="aeo" id="aeo">
                                                    @if($user->aeo ==0)
                                                        <option value="-2">请选择</option>
                                                        <option value="-1">无</option>
                                                        <option selected value="0">一般认证</option>
                                                        <option value="1">高级认证</option>
                                                    @elseif($user->aeo == 1)
                                                        <option value="-2">请选择</option>
                                                        <option value="-1">无</option>
                                                        <option value="0">一般认证</option>
                                                        <option selected value="1">高级认证</option>
                                                    @elseif($user->aeo == -1)
                                                        <option value="-2">请选择</option>
                                                        <option selected value="-1">无</option>
                                                        <option value="0">一般认证</option>
                                                        <option value="1">高级认证</option>
                                                    @else
                                                        <option value="-2">请选择</option>
                                                        <option value="-1">无</option>
                                                        <option value="0">一般认证</option>
                                                        <option value="1">高级认证</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>贸易方式</label>
                                        <div class="am-u-sm-5" style="padding-right: 0;">
                                            <div class="am-input-group br5px widthMax">
                                                <select class="br5px" {{ isset($user->hands->items) ? 'disabled' : '' }} name="trade" id="trade">
                                                    @if($user->trade == 0)
                                                        <option value="-1" selected>请选择</option>
                                                        <option selected value="0">加工贸易</option>
                                                        <option value="1">一般贸易</option>
                                                        <option value="2">以上都有</option>
                                                    @elseif($user->trade == 1)
                                                        <option value="-1" selected>请选择</option>
                                                        <option value="0">加工贸易</option>
                                                        <option selected value="1">一般贸易</option>
                                                        <option value="2">以上都有</option>
                                                    @elseif($user->trade == 2)
                                                        <option value="-1" selected>请选择</option>
                                                        <option value="0">加工贸易</option>
                                                        <option value="1">一般贸易</option>
                                                        <option selected value="2">以上都有</option>
                                                    @else
                                                        <option value="-1" selected>请选择</option>
                                                        <option value="0">加工贸易</option>
                                                        <option value="1">一般贸易</option>
                                                        <option selected value="2">以上都有</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--一排两列-->
                                <div class="am-form-group">
                                    <label class="am-u-sm-2 am-form-label"><span class="colorred"></span>生产项目类别</label>
                                    <div class="am-u-sm-10" style="padding-left: 0;">
                                        <div class="am-u-sm-5">
                                            <input name="pro_item_type" value="{{$user->pro_item_type}}" type="text"
                                                   class="br5px"/>
                                        </div>
                                        @if($user->trade == 1)
                                            <div id="trade_manual_box" style="display: none;">
                                                <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>加工贸易手册</label>
                                                <div class="am-u-sm-5" style="padding-right: 0;">
                                                    <div class="br5px widthMax">
                                                        <select class="br5px" {{ isset($user->hands->items) ? 'disabled' : '' }} name="trade_manual" id="trade_manual">
                                                            @if($user->trade_manual == 0)
                                                                <option value="-1">请选择</option>
                                                                <option selected value="0">电子化手册</option>
                                                                <option  value="1">电子账册</option>
                                                            @elseif($user->trade_manual == 1)
                                                                <option value="-1">请选择</option>
                                                                <option  value="0">电子化手册</option>
                                                                <option selected value="1">电子账册</option>
                                                            @else
                                                                <option selected value="-1">请选择</option>
                                                                <option value="0">电子化手册</option>
                                                                <option value="1">电子账册</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div id="trade_manual_box">
                                                <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>加工贸易手册</label>
                                                <div class="am-u-sm-5" style="padding-right: 0;">
                                                    <div class="br5px widthMax">
                                                        <select class="br5px" {{ isset($user->hands->items) ? 'disabled' : '' }} name="trade_manual" id="trade_manual">
                                                            @if($user->trade_manual == 0)
                                                                <option value="-1">请选择</option>
                                                                <option selected value="0">电子化手册</option>
                                                                <option  value="1">电子账册</option>
                                                            @elseif($user->trade_manual == 1)
                                                                <option value="-1">请选择</option>
                                                                <option  value="0">电子化手册</option>
                                                                <option selected value="1">电子账册</option>
                                                            @else
                                                                <option value="-1">请选择</option>
                                                                <option value="0">电子化手册</option>
                                                                <option value="1">电子账册</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label class="am-u-sm-2 am-form-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span
                                                class="colorred"></span>主要进出口贸易方式</label>
                                    <div class="am-u-sm-10">
                                        <textarea name="main_trade" class="minheight-xs br5px">{{ $user->main_trade }}</textarea>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label class="am-u-sm-2 am-form-label"><span class="colorred"></span>备注</label>
                                    <div class="am-u-sm-10">
                                        <textarea name="remark" class="minheight-xs br5px">{{$user->remark}}</textarea>
                                    </div>
                                </div>
                                <div class="am-form-group am-margin-top-lg am-text-center">
                                    @if(Entrust::can('user.edit'))
                                        <button id="editformsub" class="am-btn am-btn-secondary br5px">保存</button>
                                        <a class="am-btn am-btn-white br5px am-margin-left" href="{{ route('user.index') }}">取消</a>
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
        //联动（贸易类型和加工贸易手册两个下拉框）
        $("#trade").change(function () {
            if ($("#trade").val() == -1 || $("#trade").val() == 1) {
                $("#trade_manual_box").hide();
                $("#trade_manual").html('<option value="-1" selected>请选择</option><option value="0">电子化手册</option><option value="1">电子账册</option>');
            } else {
                $("#trade_manual_box").show();
            }
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
            //表单提交之前的动作
            beforeSubmit: function (curforms) {
                //没有选择aeo的时候提示
                if ($("#aeo").val() == -2) {
                    layer.msg('请选择AEO认证类型');
                    return false;
                }
                //贸易方式未选择
                if ($("#trade").val() == -1) {
                    layer.msg('请选择贸易方式');
                    return false;
                }
                //贸易方式选择了加工贸易或者以上都是的时候，加工贸易手册要必选，反则返回false不能提交
                else if ($("#trade").val() == 0 || $("#trade").val() == 3) {
                    if ($("#trade_manual").val() == -1) {
                        layer.msg('请选择加工贸易手册');
                        return false;
                    }
                }
                openLoad()
                $("select").removeAttr('disabled');
//                return false;
            }
        });
    </script>
@endsection