@extends('layouts.admin-app')
@section('title', '模块管理')

@section('css')
    @parent
    <link rel="stylesheet" href=" {{ url('/css/main.css') }}">
    <style type="text/css">
        .edui-container {
            width: 100% !important;
        }

        .am-form-horizontal .am-form-label {
            text-align: right;
            font-weight: normal;
        }
        .layui-layer-btn {
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <div class="dh-main">
        <div class="am-g">
            <div class="am-u-sm-3 am-u-md-3 am-u-lg-2 bgfff" id="leftNav">
                {{--左侧菜单--}}
                @include('admin._partials.item-left-menu')
            </div>
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10" id="rightMain">
                <div class="dh-main-container">
                    <p class="title fs18">
                        @if($diag_mod->name == 1)
                            <a href="{{ route('guanwu.diags',[$item->id]) }}"><i class="iconfont">&#xe604;</i></a>
                            关务风险管理
                        @elseif($diag_mod->name == 2)
                            <a href="{{ route('aeo.diags',[$item->id]) }}"><i class="iconfont">&#xe604;</i></a>
                            AEO管理
                        @elseif($diag_mod->name == 3)
                            <a href="{{ route('wuliu.diags',[$item->id]) }}"><i class="iconfont">&#xe604;</i></a>
                            物流风险管理
                        @else
                            <a href="{{ route('system.diags',[$item->id]) }}"><i class="iconfont">&#xe604;</i></a>
                            系统化管理
                        @endif

                        <span>模块管理</span>
                    </p>
                    <div class="pro-card">
                        @if(Entrust::can('diags.addmod'))
                            <p><a href="javascript:void(0);" class="am-btn am-btn-primary br5px"
                                  data-am-modal="{target: '#doc-modal-1', closeViaDimmer: 0}">添加新模块</a></p>
                        @endif
                        <div class="am-g card-box">
                            <div class="am-u-sm-5"><div class="am-padding-left-lg">模块名称</div></div>
                            <div class="am-u-sm-5"><div class="am-padding-left-lg">操作</div></div>
                        </div>
                        <ul class="am-list">
                            @foreach($diag_mod->diag_submods as $diag_submod)
                                <li class="am-g am-padding-left-lg card-box">
                                    <a class="am-u-sm-5" href="javascript:void(0);">{{ $diag_submod->name }}</a>
                                    <div class="am-u-sm-5" style="padding: 1rem">
                                        <a href="javascript:void(0);" class="am-margin-right" name="{{$diag_submod->id}}" onclick="editfun(this)">编辑</a>
                                        <a href="javascript:void(0);" name="{{$diag_submod->id}}" onclick="dffun(this)" class="colorred">删除</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        {{ $diag_mod->diag_submods->render() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--模态框-----------------------------strat-->
    {{--新增模块--}}
    <div class="am-modal am-modal-no-btn" id="doc-modal-1">
        <div class="am-modal-dialog Staff-modal-dialog" style="width: 560px;">
            <div class="am-modal-hd">
                <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i><span>新增模块</span></span>
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <div class="am-modal-bd rights-modal am-margin-top">
                <div class="lindiv"></div>
                <form class="am-form am-form-horizontal" id="addmkform" style="padding:20px 40px;" action="{{ route('diags.submod.store',[$diag_mod->id]) }}" method="post">
                    {{ csrf_field() }}
                    <div class="am-form-group">
                        <label class="am-u-sm-4 am-form-label"><span class="colorred">* </span><span>模块名称：</span></label>
                        <div class="am-u-sm-8">
                            <input name="name" class="br5px" type="text" datatype="*" nullmsg="请输入模块名称"/>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label class="am-u-sm-4 am-form-label"><span class="colorred">* </span><span>贸易类型：</span></label>
                        <div class="am-u-sm-8">
                            <select class="br5px" name="trade_type" datatype="*" nullmsg="请选择贸易类型">
                                <option value="null">无</option>
                                <option value="0">一般贸易</option>
                                <option value="1">加工贸易</option>
                            </select>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label class="am-u-sm-4 am-form-label"><span class="colorred">* </span><span>AEO认证类型：</span></label>
                        <div class="am-u-sm-8">
                            <select class="br5px" name="aeo_type" datatype="*" nullmsg="请选择AEO认证类型">
                                <option value="null">无</option>
                                <option value="0">一般认证</option>
                                <option value="1">高级认证</option>
                            </select>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <div class="am-u-sm-10 am-u-sm-offset-2">
                            @if(Entrust::can('diags.addmod'))
                                <button type="submit" class="am-btn am-btn-primary br5px">提交</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--编辑模块--}}
    <div class="am-modal am-modal-no-btn" id="editmodal">
        <div class="am-modal-dialog Staff-modal-dialog" style="width: 560px;">
            <div class="am-modal-hd">
                <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i><span>编辑模块</span></span>
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <div class="am-modal-bd rights-modal am-margin-top">
                <div class="lindiv"></div>
                <form class="am-form am-form-horizontal" id="editmkform" style="padding:20px 40px;" method="post">
                    <div class="am-form-group">
                        <label class="am-u-sm-4 am-form-label"><span
                                    class="colorred">* </span><span>模块名称：</span></label>
                        <div class="am-u-sm-8">
                            <input name="name" id="editinput" class="br5px" type="text" datatype="*" nullmsg="请输入模块名称"/>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label class="am-u-sm-4 am-form-label"><span class="colorred">* </span><span>贸易类型：</span></label>
                        <div class="am-u-sm-8">
                            <select class="br5px" name="trade_type" datatype="*" nullmsg="请选择贸易类型">
                                <option value="null">无</option>
                                <option value="0">一般贸易</option>
                                <option value="1">加工贸易</option>
                            </select>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label class="am-u-sm-4 am-form-label"><span class="colorred">* </span><span>AEO认证类型：</span></label>
                        <div class="am-u-sm-8">
                            <select class="br5px" name="aeo_type" datatype="*" nullmsg="请选择AEO认证类型">
                                <option value="null">无</option>
                                <option value="0">一般认证</option>
                                <option value="1">高级认证</option>
                            </select>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <div class="am-u-sm-10 am-u-sm-offset-2">
                                <button type="button" id="editsub" class="am-btn am-btn-primary br5px">提交</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    @parent
    <script src=" {{ url('js/main.js') }}" type="text/javascript" charset="utf-8"></script>
    <script>

        $("#addmkform").Validform({
            tiptype: function (msgs, o, cssctl) {
                if (o.type != 2) {     //只有不正确的时候才出发提示，输入正确不提示
                    layer.msg(msgs);
                }
            },
            ajaxPost: false,//true用ajax提交，false用form方式提交
            tipSweep: true,//true只在提交表单的时候开始验证，false每输入完一个输入框之后就开始验证
            beforeSubmit: function (curform) {
                openLoad()
            },
            callback: function (rq) {
            }
        });

        //编辑
        function editfun(e) {
            $("#editsub").attr("name",$(e).attr("name"));
            var url = '/admin/item/diags/addmod/'+ $(e).attr("name") +'/edit';
            $("#editmodal").modal();
        //调取数据填充到编辑模态框去
            AjaxJson(url,{},function (data) {
                $("#editinput").val(data.name);
                if(data.status == -1) {
                    layer.msg(data.msg)
                }
            });
        };
        //点击了编辑模态框里面的提交按钮之后的动作
        $("#editsub").click(function () {
            var url = '/admin/item/diags/addmod/'+ $("#editsub").attr("name") +'/update';
            var name = $("#editinput").val();
            AjaxJson(url,{name:name},function (data) {
                if(data.status == 1){
                    layer.msg(data.msg);
                    window.location.reload()
                }else {
                    layer.msg(data.msg)
                }
            });
        });

        //删除
        function dffun(e) {
            var submod_id = $(e).attr("name");
            var url = '/admin/item/diags/addmod/destroy/'+ submod_id;
            layer.msg('确定删除该模块吗？删除之后数据将无法恢复！', {
                time: 0 //不自动关闭
                , btn: ['确定', '取消']
                , yes: function (index) {
                    AjaxJson(url,{},function (data) {
                        layer.msg(data.msg);
                        window.location.reload();
                    })
                }
            });
        }
    </script>
@endsection