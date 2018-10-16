@extends('layouts.admin-app')
@section('title', '法律法规编辑')

@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="/../js/umeditor/themes/default/css/umeditor.min.css"/>
    <link rel="stylesheet" href="/../css/main.css">
    <style type="text/css">
        .edui-container {width: 100% !important;}
        .edui-body-container {min-height: 250px !important;}
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
                    <form class="am-form am-form-horizontal" id="editform" action="{{ route('law.update',[$law->id]) }}"
                          method="post">
                        <p class="title fs18"><a href="{{ route('law.index') }}"><i class="iconfont">&#xe604;</i></a>编辑法律法规管理
                            ({{ $law->name }})

                        </p>
                      <div class="pro-card">
                        <div class=" marginT30px" style="padding-right: 10%;">
                            <form class="bgfff paddt30px paddb30px">
                                <!--一排一列-->
                                {{ method_field('PUT') }}
                                {{ csrf_field() }}
                                <div class="am-form-group card-box">
                                    <label class="am-u-sm-2 am-form-label" style="padding-right: 1.5rem;"><span
                                                class="colorred">* </span>序号:</label>
                                    <div class="am-u-sm-2" style="padding-left: 1.5rem;">
                                        <input name="number" value="{{ $law->id }}" class="br5px" type="text"
                                               placeholder="请输入序号" datatype="*" nullmsg="请输入序号" readonly>
                                    </div>
                                </div>

                                <!--一排一列-->
                                <div class="am-form-group">
                                    <label class="am-u-sm-2 am-form-label"><span
                                                class="colorred">* </span>法律法规名称:</label>
                                    <div class="am-u-sm-10">
                                        <input name="name" value="{{ $law->name }}" class="br5px" type="text"
                                               placeholder="请输入法律法规名称" datatype="*" nullmsg="请输入法律法规名称">
                                    </div>
                                </div>

                                <!--一排一列-->
                                <div class="am-form-group">
                                    <label class="am-u-sm-2 am-form-label"><span
                                                class="colorred">* </span>法规条例文号:</label>
                                    <div class="am-u-sm-10">
                                        <input name="title" value="{{ $law->title }}" class="br5px" type="text"
                                               placeholder="请输入法规条例文号" datatype="*" nullmsg="请输入法规条例文号">
                                    </div>
                                </div>

                                <!--一排一列-->
                                <div class="am-form-group">
                                    <label class="am-u-sm-2 am-form-label"><span
                                                class="colorred">* </span>法规条例条号:</label>
                                    <div class="am-u-sm-10">
                                        <span>第</span> <input name="title_no" value=" {{ $law->title_no }}" class="br5px" type="text"
                                                              placeholder="请输入法规条例条号" datatype="*" nullmsg="请输入法规条例条号" style="width: 50px;display: inline-block; position: relative; top: -3px;">
                                        <span>条</span>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label class="am-u-sm-2 am-form-label"><span
                                                class="colorred">* </span>法规条例内容</label>
                                    <div class="am-u-sm-10">
                                        <input type="hidden" id="content" name="content" datatype="*" nullmsg="请输入法规条例内容"/>
                                        <script type="text/plain" id="myEditor" >{!! html_entity_decode(stripslashes($law->content)) !!}</script>
                                    </div>
                                </div>
                                <div class="am-text-center am-u-sm-12 am-margin-top am-form-group">
                                    @if(Entrust::can('law.edit'))
                                        <button id="editformsub" class="am-btn am-btn-secondary br5px">保存</button>
                                        <a class="am-btn am-btn-white br5px am-margin-left" href="{{ route('law.index') }}">返回</a>
                                    @endif
                                </div>
                                <div style="clear: both"></div>
                            </form>
                        </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>
        <!--模态框-----------------------------strat-->
        @endsection

        @section('javascript')
            @parent
            <script src = "/../js/umeditor/third-party/template.min.js" charset = "utf-8" ></script>
            <script src="/../js/umeditor/umeditor.config.js" type="text/javascript"
                    charset="utf-8"></script>
            <script src="/../js/umeditor/umeditor.min.js" type="text/javascript"
                    charset="utf-8"></script>
            <script src="/../js/main.js" type="text/javascript" charset="utf-8"></script>
            <script>
                //实例化编辑器
                var um = UM.getEditor('myEditor');
                //获取富文本编辑内容（带格式）
                function getContent() {
                    $("#content").val(UM.getEditor('myEditor').getContent())
                }
                var editygformobj = $("#editform").Validform({
                    btnSubmit: "#editformsub",
                    tiptype: function (msgs, o, cssctl) {
                        if (o.type != 2) { //只有不正确的时候才出发提示，输入正确不提示
                            layer.msg(msgs);
                        }
                    },
                    ajaxPost: false, //true用ajax提交，false用form方式提交
                    tipSweep: true, //true只在提交表单的时候开始验证，false每输入完一个输入框之后就开始验证
                    beforeCheck: function(curform){
                        getContent()
                    },
                    beforeSubmit: function (curform) {
                        openLoad();
                    }
                });
            </script>
@endsection

