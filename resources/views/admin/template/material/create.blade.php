@extends('layouts.admin-app')
@section('title', '材料清单编辑')

@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href=" {{ url('/js/umeditor/themes/default/css/umeditor.min.css') }}"/>
    <link rel="stylesheet" href=" {{ url('css/main.css') }}">
    <style type="text/css">
        input:-ms-input-placeholder{font-size:14px}
        input::-webkit-input-placeholder{font-size:14px}
        input::-moz-placeholder{font-size:14px}
        input:-moz-placeholder{font-size:14px}
        .edui-body-container,.edui-container{width:100%!important}
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
                    <form action="" class="am-form" id="editform">
                        <p class="title fs18">
                            <a href="{{ route('template.material',[$material_name_id]) }}"><i class="iconfont">&#xe604;</i></a>审核所涉及的资料 (新增审核资料)
                        </p>
                        <div class="pro-card">
                            <div class="am-g card-box am-margin-top">
                                <div class="am-u-sm-2 am-text-right" style="line-height: 2.2;">
                                    <span class="colorred"> </span> 清单内容名称：
                                </div>
                                <div class="am-u-sm-10">
                                    <input id="bm_name" class="br5px" type="text" value="{{isset($mater_content) ? $mater_content->name : ''}}" />
                                </div>
                            </div>
                            <div class="am-g card-box am-margin-top">
                                <div class="am-u-sm-2 am-text-right" style="line-height: 2.2;">
                                    <span class="colorred"> *</span> 清单内容：
                                </div>
                                <div class="am-u-sm-10">
                                    <script type="text/plain" id="myEditor">{!!  html_entity_decode(stripslashes( isset($mater_content) ? $mater_content->content : '')) !!}</script>
                                </div>
                            </div>
                            <div class="am-margin-top am-text-center">
                                <button id="editformsub"  type="submit" class="am-btn am-btn-primary br5px">提交</button>
                                <a href="{{ route('template.material',[$material_name_id]) }}" class="am-btn am-btn-white br5px">返回</a>
                            </div>
                        </div>
                        <input id="mater_id" type="hidden" value="{{isset($material_id) ? $material_id : null}}">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--在这里编写你的代码-->
@endsection

@section('javascript')
    @parent
    <script src="{{ url('/js/umeditor/third-party/template.min.js') }} " type="text/javascript" charset="utf-8"></script>
    <script src="{{ url('/js/umeditor/umeditor.config.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ url('/js/umeditor/umeditor.min.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ url('/js/main.js') }}" type="text/javascript" charset="utf-8"></script>
    <script>
        //实例化编辑器
        var um = UM.getEditor('myEditor');
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
            beforeSubmit: function (curform) {
                var url = '/admin/template/material/'+ $('#mater_id').val() +'/store';
                AjaxJson(url, {
                    'name': $("#bm_name").val(),
                    'content': UM.getEditor('myEditor').getContent(),
                }, function (data) {
                    if (data.status == 1) {
                        layer.msg(data.msg);
                        window.location.href = data.url;
                    } else {
                        layer.msg(data.msg);
                        window.location.href = data.url;
                    }
                });
                return false;
            }
        });
    </script>
@endsection