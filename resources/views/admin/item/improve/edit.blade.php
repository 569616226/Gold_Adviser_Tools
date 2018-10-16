@extends('layouts.admin-app')
@section('title', '编辑实施计划')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ url('css/main.css') }}">
    <style type="text/css">
        .edui-container {
            width: 100% !important
        }

        /*.am-form-horizontal .am-form-label{text-align:right;font-weight:400}*/
        .am-form-field[readonly] {
            cursor: pointer !important
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
                    <p class="title fs18">
                        <a href="{{ route('improve.index',[$item->id]) }}"><i class="iconfont">&#xe604;</i></a>编辑改善实施计划信息
                    </p>
                    <div class=" marginT30px">
                        <form class="am-form am-form-horizontal bgfff am-padding" id="editform" action="{{ route('improve.update',[$item->id]) }}" method="post">
                        {{ csrf_field() }}
                        <!--一排一列-->
                            <div class="fs18 am-padding-left-lg">项目信息</div>
                            <div class="lindiv am-margin-top-xs am-margin-bottom"></div>
                            <div class="am-form-group card-box">
                                <label class="am-u-sm-4 am-form-label"><span class="colorred">* </span>实施辅导单位：</label>
                                <div class="am-u-sm-8">
                                    {{ $item->hands->meches->name }}
                                </div>
                            </div>

                            <div class="am-form-group card-box">
                                <label class="am-u-sm-4 am-form-label"><span class="colorred">* </span>项目总负责人：</label>
                                <div class="am-u-sm-8">
                                    {{ $creater->name }}
                                </div>
                            </div>

                            <div class="am-form-group card-box">
                                <label class="am-u-sm-4 am-form-label"><span class="colorred">* </span>实施时间：</label>
                                <div class="am-u-sm-2 am-text-left">
                                    <input id="start_date" value="{{  $item->improve_startDate }}" name="start_date" type="text" class="am-form-field" datatype="*" nullmsg="请选择开始时间" placeholder="请选择开始时间" data-am-datepicker readonly required/>
                                </div>
                                <div class="am-u-sm-1 am-text-left">
                                    <div class="dao">到</div>
                                </div>
                                <div class="am-u-sm-2 am-text-left">
                                    <input id="end_date" value="{{  $item->improve_endDate }}" name="end_date" type="text" class="am-form-field" datatype="*" nullmsg="请选择结束时间" placeholder="请选择结束时间" data-am-datepicker readonly required/>
                                </div>
                            </div>
                            <div class="am-text-center am-margin-top-lg">
                                @if(Entrust::can('improve.edit'))
                                    <button id="editformsub" class="am-btn am-btn-secondary br5px">保存</button>
                                @endif
                                <a class="am-btn am-btn-white br5px am-margin-left" href="{{ route('improve.index',[$item->id]) }}">取消</a>
                            </div>
                            <div style="clear: both;"></div>
                        </form>
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
                var oDate1 = new Date($("#start_date").val());
                var oDate2 = new Date($("#end_date").val());
                if (oDate1.getTime() > oDate2.getTime()) {
                    layer.msg('结束时间必须大于开始时间')
                    return false;
                }
            }
        });
    </script>
@endsection