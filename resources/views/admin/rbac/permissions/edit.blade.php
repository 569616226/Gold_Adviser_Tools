@extends('layouts.admin-app')
@section('title', '权限管理')
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
                          action="{{ route('permission.update',[$permission->id]) }}" method="post">
                        <p class="title fs18">
                            <a href="{{ route('permission.index') }}"><i class="iconfont">&#xe604;</i></a>编辑权限
                            ({{ $permission->display_name }})
                            @if(Entrust::can('permission.edit'))
                                <button id="editformsub" class="am-fr am-btn am-btn-secondary br5px">保存</button>
                            @endif
                        </p>
                        <div class=" marginT30px" style="padding-right: 10%;">
                            <div class="bgfff paddt30px paddb30px">
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}
                            <!--一排两列-->
                                <div class="am-form-group">
                                    <label class="am-u-sm-2 am-form-label"><span class="colorred"></span>所属权限组：</label>
                                    <div class="am-u-sm-10" style="padding-left: 0;">
                                        <div class="am-u-sm-5">
                                            @inject('permissionPresenter','App\Presenters\PermissionPresenter')

                                            {!! $permissionPresenter->topPermissionSelect($permission->fid) !!}

                                        </div>
                                        <label class="am-u-sm-2 am-form-label"><span
                                                    class="colorred">* </span>权限路由:</label>
                                        <div class="am-u-sm-5" style="padding-right: 0;">
                                            <input name="name" class="br5px" type="text" placeholder="请输入路由"
                                                   datatype="*" nullmsg="请输入路由" sucmsg=" "
                                                   value="{{ $permission->name }}"/>
                                        </div>
                                    </div>
                                </div>

                                <!--一排两列-->
                                <div class="am-form-group">
                                    <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>显示名称:</label>
                                    <div class="am-u-sm-10" style="padding-left: 0;">
                                        <div class="am-u-sm-5">
                                            <input name="display_name" class="br5px" type="text" placeholder="请输入名称" datatype="*" nullmsg="请输入名称" sucmsg=" " value="{{ $permission->display_name }}"/>
                                        </div>
                                        {{--<label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>是否菜单:</label>--}}
                                        {{--<div class="am-u-sm-5" style="padding-right: 0;">--}}
                                            {{--<select class="br5px" name="is_menu">--}}
                                                {{--<--}}
                                                {{--<option value="1" {{ $permission->is_menu == 1 ? 'selected':'' }}>是--}}
                                                {{--</option>--}}
                                                {{--<option value="0" {{ $permission->is_menu == 0 ? '':'selected' }}>否--}}
                                                {{--</option>--}}
                                            {{--</select>--}}
                                        {{--</div>--}}
                                    </div>
                                </div>

                                <!--一排一列-->
                                <div class="am-form-group">
                                    <label class="am-u-sm-2 am-form-label"><span class="colorred"></span>说明:</label>
                                    <div class="am-u-sm-10">
                                        <textarea name="description" class="br5px minheight-xxs" rows="6">{{ $permission->description }}</textarea>
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
    <script src=" {{ url('js/searchableSelect/jquery.searchableSelect.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="/../js/main.js" type="text/javascript" charset="utf-8"></script>
    <script>
        $("#fid").searchableSelect();
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