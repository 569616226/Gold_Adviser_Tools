@extends('layouts.admin-app')
@section('title', '诊断结果具体分析')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ url('css/main.css') }}">
    <style type="text/css">
        .tabs-child .am-nav-tabs,.tabs-child .am-nav-tabs>li.am-active>a,.tabs-child .am-tabs-bd{border:none}
        table>tbody>tr.am-active>th{border-left:1px solid #ddd}
        .am-form-field[readonly]{cursor:pointer!important}
        .nav-child li.am-active a,.nav-child li.am-active a:focus,.nav-child li.am-active a:hover{background:0 0;color:#000}
        .am-form textarea{height:35px}
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
                    @include('admin.template._partials.diags_menu')
                    <div class="pro-card am-margin-top-sm">
                        <div class="paddlr20px">
                            <div style="overflow: hidden;" class="marginT30px">
                                <i class="iconfont" style="color: #FF9800;">&#xe633;</i> 诊断结果具体分析
                                <div class="paddlr20px" style="width: 100%;">
                                    <div class="bigm-card marginT30px">
                                        <div class="am-margin-top">
                                            <h2 class="am-fl">{{ $diag_mod_tem->name }}
                                                <a href="{{ route('template.diags.addmod',[$diag_mod_tem->id]) }}" class="am-margin-left am-btn am-btn-white br5px fs14" data-am-modal="{target: '#doc-modal-4', closeViaDimmer: 0}">
                                                    <i class="iconfont">&#xe617;</i>
                                                </a>
                                            </h2>

                                            <div style="clear: both;"></div>
                                            <!--小模块-->

                                                @foreach($diag_mod_tem->diag_submod_tems as $diag_submod_tem)
                                                    <div class="smallm-card">
                                                        <div class="am-fl">{{ $diag_submod_tem->name }}</div>

                                                        <div style="clear: both;"></div>
                                                        <!--表格（小项）-->
                                                        <table class="am-table am-table-bordered am-table-centered am-margin-top ">
                                                            <thead>
                                                            <tr class="am-active">
                                                                <th class="am-text-middle">
                                                                    审核内容
                                                                </th>
                                                                {{--<th class="am-text-middle" style="min-width: 130px">--}}
                                                                    {{--问题及风险描述--}}
                                                                {{--</th>--}}
                                                                {{--<th class="am-text-middle" style="min-width: 100px">--}}
                                                                    {{--法律依据--}}
                                                                {{--</th>--}}
                                                                {{--<th class="am-text-middle" style="min-width: 130px">--}}
                                                                    {{--建议及改善方案--}}
                                                                {{--</th>--}}
                                                                <th class="am-text-middle" style="min-width: 100px">
                                                                    操作
                                                                </th>
                                                            </tr>
                                                            </thead>
                                                            <tfoot>
                                                            <tr>
                                                                <td colspan="5">
                                                                    <a href="javascript:void(0);" class="br5px" name="{{ $diag_submod_tem->id }}" onclick="addcontent(this)">
                                                                        <i class="iconfont">&#xe61e;</i>新增审核内容
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            </tfoot>
                                                            <tbody>
                                                            <tr>
                                                            @foreach($diag_submod_tem->diag_subcontent_tems as $diag_subcontent_tem)
                                                                <tr>
                                                                    <td class="am-text-middle am-text-left" style="max-width: 500px;">{{ $diag_subcontent_tem->content }}</td>
                                                                    {{--<td class="am-text-middle am-text-left">{{ $diag_subcontent_tem->describle }}</td>--}}
                                                                    {{--<td class="am-text-middle"><div class="stcha" name="{{ $diag_subcontent_tem->id }}" onclick="flyjshowfun(this)">{{ $diag_subcontent_tem->law }}</div></td>--}}
                                                                    {{--<td class="am-text-middle am-text-left" style="max-width: 500px;">{{ $diag_subcontent_tem->suggest }}</td>--}}
                                                                    <td class="am-text-middle">
                                                                        <a href="javascript:void(0);" name="{{ $diag_subcontent_tem->id }}" onclick="editcontent(this)"> 编辑</a>
                                                                        <a href="javascript:void(0);" name="{{ $diag_subcontent_tem->id }}" onclick="dfcontent(this)" class="colorred"> 删除</a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--模态框-----------------start-->

    {{--新增审核内容模态框--}}
    <div class="am-modal am-modal-no-btn" id="doc-modal-5">
        <div class="am-modal-dialog modalwidth-md">
            <div class="am-modal-hd">
                <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i><span>新增审核内容</span></span>
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <div class="am-modal-bd rights-modal am-margin-top">
                <div class="lindiv"></div>
                <form class="am-form am-form-horizontal" style="padding:20px 40px;"  id="addcontentform">
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label"><span
                                    class="colorred">* </span><span>审核内容：</span></label>
                        <div class="am-u-sm-10">
                            <textarea name="content" id="addcontent" class="br5px minheight-xxs"></textarea>
                            {{--<input  name="content" class="br5px" type="text"/>--}}
                        </div>
                    </div>
                    <div class="am-form-group">
                        <div class="am-u-sm-10 am-u-sm-offset-2">
                            @if(Entrust::can('diags.addcontent'))
                                <button id="addcontentbtn" type="submit" class="am-btn am-btn-primary br5px">提交</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--编辑审核内容模态框--}}
    <div class="am-modal am-modal-no-btn" id="editcontent-modal">
        <div class="am-modal-dialog modalwidth-md">
            <div class="am-modal-hd">
                <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i><span>编辑审核内容</span></span>
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <div class="am-modal-bd rights-modal am-margin-top">
                <div class="lindiv"></div>
                <form class="am-form am-form-horizontal" style="padding:20px 40px;" id="editcontentform">
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label"><span
                                    class="colorred">* </span><span>审核内容：</span></label>
                        <div class="am-u-sm-10">
                            {{--<input id="editcontentinp" class="br5px" type="text"/>--}}
                            <textarea id="editcontentinp" name="editcontentinp" class="br5px minheight-xxs"></textarea>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <div class="am-u-sm-10 am-u-sm-offset-2">
                            <button id="editcontentbtn" type="button" class="am-btn am-btn-primary br5px">提交</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--删除部门模态框-->
    <div class="am-modal am-modal-no-btn" id="df-modal">
        <div class="am-modal-dialog modalwidth-xxs">
            <div class="am-modal-hd">
                <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i><span>删除审核内容</span></span>
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <div class="am-modal-bd rights-modal am-margin-top">
                <div class="lindiv"></div>
                <p class="am-text-center">
                    确定删除此条审核内容吗？删除后，内容将无法恢复
                </p>

                <p>
                    <button class="am-btn am-btn-primary br5px" name="" id="dfsuer">确定</button>
                    <button class="am-btn br5px" data-am-modal-close>取消</button>
                </p>
            </div>
        </div>
    </div>


@endsection
@section('javascript')
    @parent
    <script src=" {{ url('js/validform/js/Validform_Datatype.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src=" {{ url('js/main.js') }}" type="text/javascript" charset="utf-8"></script>
    <script>

        //增加审核内容
        function addcontent(e) {
            $("#addcontentbtn").attr("name", $(e).attr("name"));
            $("#doc-modal-5").modal();
        }
        var addcontentform = $("#addcontentform").Validform({
            //btnSubmit:"#editformsub",
            tiptype: function (msgs, o, cssctl) {
                if (o.type != 2) { //只有不正确的时候才出发提示，输入正确不提示
                    layer.msg(msgs);
                }
            },
            ajaxPost: true, //true用ajax提交，false用form方式提交
            tipSweep: true, //true只在提交表单的时候开始验证，false每输入完一个输入框之后就开始验证
            beforeSubmit: function (curform) {
                openLoad();
                var url = '/admin/template/diags/addcontent/' + $("#addcontentbtn").attr("name");
                var postDta = {'content':$("#addcontent").val()}
                AjaxJson(url, {'content': postDta.content}, function (data) {
                    if (data.status == 1) {
                        if (data.msg != null && data.msg != undefined) {
                            layer.msg(data.msg)
                        }
                        window.location.reload();
                    } else {
                        if (data.msg != null && data.msg != undefined) {
                            layer.msg(data.msg)
                        }
                    }
                });
                return false;
            },
        });

        //编辑审核内容
        function editcontent(e) {
            $("#editcontentbtn").attr("name", $(e).attr("name"));
            var bjid = $(e).attr("name");
            var url = '/admin/template/diags/editcontent/' + bjid;
            //调用接口返回审核内容填充到输入框(data.content指的是输入框的审核内容)
            AjaxJson(url, {}, function (data) {
                $("#editcontentinp").val(data.content);
                $("#editcontent-modal").modal();
            })
        }
        //        点击编辑审核内容的模态框的提交按钮提交数据。
        $("#editcontentbtn").click(function () {
            var content = $("#editcontentinp").val();
            var tidi =  $("#editcontentbtn").attr("name");
            var url = '/admin/template/diags/storecontent/' + tidi;
            AjaxJson(url, {content:content}, function (data) {
                if (data.status == 1) {
                    if (data.msg != null && data.msg != undefined) {
                        layer.msg(data.msg)
                    }
                    window.location.reload();
                } else {
                    if (data.msg != null && data.msg != undefined) {
                        layer.msg(data.msg)
                    }
                }
            });
        });

        //客户端删除
        function dfcontent(e) {
            var dfid = $(e).attr("name");
            var url = '/admin/template/diags/delcontent/' + dfid;
            layer.msg('确定删除该行吗？', {
                time: 0 //不自动关闭
                , btn: ['确定', '取消']
                , yes: function (index) {
                    //点击确定删除之后的动作
                    AjaxJson(url, {}, function (data) {
                        if (data.status == 1) {
                            if (data.msg != null && data.msg != undefined) {
                                layer.msg(data.msg)
                            }
                            window.location.reload();
                        } else {
                            if (data.msg != null && data.msg != undefined) {
                                layer.msg(data.msg)
                            }
                        }
                    });
                }
            });
        }

    </script>
@endsection