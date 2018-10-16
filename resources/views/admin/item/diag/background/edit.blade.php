@extends('layouts.admin-app')
@section('title', '企业背景编辑')
@section('css')
    @parent
    <link rel="stylesheet" href=" {{ url('/css/main.css') }}">
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
                @include('admin._partials.item-left-menu')
            </div>
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10" id="rightMain">
                <div class="dh-main-container">
                    <form class="am-form am-form-horizontal " id="editform" action="{{ route('user.background.update',[$user->id]) }}" method="post">
                        <p class="title fs18">
                            <a href="{{ route('user.background',[$item->id]) }}"><i class="iconfont">&#xe604;</i></a>编辑企业背景描述
                            @if(Entrust::can('user.background.edit') )
                                <button id="editformsub" class="am-fr am-btn am-btn-secondary br5px">保存</button>
                            @endif
                        </p>
                        <div class=" marginT30px" style="padding-right: 10%;">
                            <div class="bgfff paddt30px paddb30px">
                                <!--一排一列-->
                                {{ csrf_field() }}
                                {{--{{ method_field('PUT') }}--}}
                                <div class="am-form-group card-box">
                                    <label class="am-u-sm-2 am-form-label"><span class="colorred"></span>注册名称</label>
                                    <div class="am-u-sm-8" style="padding-top: .7rem;">
                                        {{ $user->name }}
                                    </div>
                                </div>
                                <div class="am-form-group card-box">
                                    <label class="am-u-sm-2 am-form-label"><span class="colorred"></span>注册地址</label>
                                    <div class="am-u-sm-8">
                                        {{ $user->address }}
                                    </div>
                                </div>

                                <div class="am-form-group card-box">
                                    <label class="am-u-sm-2 am-form-label"><span class="colorred"></span>成立日期</label>
                                    <div class="am-u-sm-8">
                                        {{ $user->create_date }}
                                    </div>
                                </div>

                                <div class="am-form-group card-box">
                                    <label class="am-u-sm-2 am-form-label"><span class="colorred"></span>注册资本</label>
                                    <div class="am-u-sm-8">
                                        {{ $user->capital }}
                                    </div>
                                </div>

                                <div class="am-form-group card-box">
                                    <label class="am-u-sm-2 am-form-label"><span class="colorred"></span>海关识别码</label>
                                    <div class="am-u-sm-8">
                                        {{ $user->code }}
                                    </div>
                                </div>

                                <div class="am-form-group card-box">
                                    <label class="am-u-sm-2 am-form-label"><span class="colorred"></span>AEO认证</label>
                                    <div class="am-u-sm-5">
                                        <div class="am-input-group br5px widthMax">
                                            {{ $user->aeo == 0 ? '一般认证':'高级认证'  }}
                                        </div>
                                    </div>
                                </div>
                                <div class="am-form-group card-box">
                                    <label class="am-u-sm-2 am-form-label"><span class="colorred"></span>加工贸易手册</label>
                                    <div class="am-u-sm-5">
                                        <div class="br5px widthMax">
                                            {{ $user->trade_manual == 0 ? '电子化手册':'电子账册'  }}
                                        </div>
                                    </div>
                                </div>
                                <div class="am-form-group card-box">
                                    <label class="am-u-sm-2 am-form-label"><span class="colorred"></span>贸易方式</label>
                                    <div class="am-u-sm-5">
                                        <div class="am-input-group br5px widthMax">
                                            @if($user->trade == 0)
                                                加工贸易
                                            @elseif($user->trade == 1)
                                                来料加工
                                            @elseif($user->trade == 2)
                                                以上都有
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="am-form-group card-box">
                                    <label class="am-u-sm-2 am-form-label"><span class="colorred"></span>生产项目类别</label>
                                    <div class="am-u-sm-8">
                                        <input name="pro_item_type" value="{{ $user->pro_item_type }}" type="text" class="br5px" placeholder="请输入生产项目类别" datatype="*" nullmsg="请输入生产项目类别"/>
                                    </div>
                                </div>

                                <div class="am-form-group card-box">
                                    <label class="am-u-sm-2 am-form-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="colorred"></span>主要进出口贸易方式</label>
                                    <div class="am-u-sm-8">
                                        <input name="main_trade" value="{{ $user->main_trade }}" type="text" class="br5px" placeholder="请输入主要进出口贸易方式" datatype="*" nullmsg="请输入主要进出口贸易方式"/>
                                    </div>
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
    <script src=" {{ url('js/main.js') }}" type="text/javascript" charset="utf-8"></script>
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