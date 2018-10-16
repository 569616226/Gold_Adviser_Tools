@extends('layouts.admin-app')
@section('title', '设置权限-角色管理')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ url('jstree/themes/default/style.css') }}" />
    <link rel="stylesheet" href=" {{ url('css/main.css') }}">
    <script src="{{ url('js/jquery.min.js') }}"></script>
    <script src="{{ url('js/loading/perfectLoad.js') }}"></script>
    <script>
        $.MyCommon.PageLoading({loadingTips:'拼命加载中......', sleep: 500 });
    </script>
    <style type="text/css">
        .admin-sidebar-list li {
            border: none !important;
        }
        .admin-sidebar-list > li {
            padding-top: 10px;
        }
        .icheckbox_flat-blue {
            top: -2px;
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
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10">

                <div class="dh-main-container">
                    <p class="title fs18">
                        <a href="{{ route('role.index') }}"><i class="iconfont">&#xe604;</i></a>设置权限
                        ({{ $role->display_name }})
                        {{--@if( Entrust::can('admin.role.permissions.update') )--}}
                            <button id="savebtn" class="am-fr am-btn am-btn-secondary br5px">保存</button>
                        {{--@endif--}}
                    </p>
                    <div>
                        <div>
                            <form action="{{ route('admin.role.permissions',[$role->id ]) }}">
                                {{--隐藏数据--}}
                                <input type="hidden" id="hiddID" name="hiddID" value="{{ $role->id }}">
                                <div class="am-margin-top">
                                    <div class="quanset-box">
                                        <p class="title"><span class="fs16">角色名:</span>
                                            <span>{{ $role->display_name }}</span></p>
                                            <div id="container" style="margin-left: 80px;">
                                                <ul class="am-list admin-sidebar-list">
                                                    @foreach($topPermissions as $topPermission)
                                                    <!--列表大项-->
                                                    <li id="{{ $topPermission->id }}" class="am-panel" data-jstree='{"selected" : {{ in_array($topPermission->id,$rolePermissions) ? true : false  }}}'>{{ $topPermission->display_name }}
                                                        <ul class="am-list admin-sidebar-list">
                                                            @if(isset($topPermission->sub_permission))
                                                                @foreach($topPermission->sub_permission as $sub_permission)
                                                                <li id="{{ $sub_permission->id }}" data-jstree='{ "selected" : {{  in_array($sub_permission->id,$rolePermissions) ? true : false  }}}'>{{ $sub_permission->display_name }}
                                                                    <ul class="am-list admin-sidebar-list">
                                                                        @if(isset($sub_permission->sub_permission))
                                                                            @foreach($sub_permission->sub_permission as $sub_permission_1)
                                                                                <li  id="{{ $sub_permission_1->id }}" data-jstree='{ "selected" : {{ in_array($sub_permission_1->id,$rolePermissions) ? true : false  }}}'>{{ $sub_permission_1->display_name  }}
                                                                                    @if(isset($sub_permission_1->sub_permission))
                                                                                        @foreach($sub_permission_1->sub_permission as $sub_permission_2)
                                                                                        <ul class="am-list admin-sidebar-list">
                                                                                            <li id="{{ $sub_permission_2->id }}">{{ $sub_permission_2->display_name  }}</li>
                                                                                        </ul>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </li>
                                                                            @endforeach
                                                                        @endif
                                                                    </ul>
                                                                </li>
                                                                @endforeach
                                                            @endif
                                                        </ul>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    @parent
    {{--<script src="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.3/jstree.min.js"></script>--}}
    <script src="{{ url('jstree/jstree.min.js') }}"></script>
    <script src="/../js/main.js" type="text/javascript" charset="utf-8"></script>
    <script>
        $("#savebtn").click(function () {
            var instance = $('#container').jstree(true);
            var permissions = instance.get_selected(true);//获取选中的值
            console.log(permissions);
            var url = "/admin/role/" + $("#hiddID").val() + "/permissions";
            openLoad();
            AjaxJson(url, {permissions: permissions}, function (data) {
                if (data.status == 1) {
                    layer.msg(data.msg);
                    window.location.reload();
                } else {
                    layer.msg(data.msg);
                }
            });
        });

        /*树形结构*/
            $(function() {
                $('#container').bind("loaded.jstree", function (e, data) {
                    data.inst.close_all(); // -1默认全部展开节点
                }).jstree({
                    "checkbox" : {
                        'three_state' : false,
                    },
                    "plugins" : ["checkbox",'wholerow'],
                    'core' : {
                        "themes" : {
                            "variant" : "large"
                        }
                    }
                });
            });
    </script>
@endsection