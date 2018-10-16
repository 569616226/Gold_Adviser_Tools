@extends('layouts.admin-app')
@section('title', '权限管理')

@section('css')
@parent
<link rel="stylesheet" href=" {{ url('css/main.css') }}">
<script src="{{ url('js/jquery.min.js') }}"></script>
<script src="{{ url('js/loading/perfectLoad.js') }}"></script>
<script>
        $.MyCommon.PageLoading({loadingTips:'', sleep: 2000 });
</script>
@endsection
@section('content')
    <div class="dh-main">
        <div class="am-g">
            <div class="am-u-sm-3 am-u-md-3 am-u-lg-2 bgfff" id="leftNav">
                <!--右侧菜单-->
                @include('admin._partials.rbac-left-menu')
            </div>
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10" id="rightMain">
                <!--项目概况-->
                <div class="dh-main-container">
                    <p class="title fs18">权限管理
                        @if(Entrust::can('permission.create'))
                            <button class="am-fr am-btn am-btn-secondary br5px"
                                    data-am-modal="{target: '#doc-modal-1', closeViaDimmer: 0}">新建权限
                            </button>
                        @endif
                    </p>
                    <div class="search">
                        <form id="search-form" action="{{ route('permission.search') }}" method="POST" class="am-form am-form-horizontal am-form-inline">
                            {{ csrf_field() }}

                            <div class="am-form-group">
                                <input style="width: 220px" type="text" name="searchStr"
                                       placeholder="可输入权限名称和路由"/>
                            </div>
                            <div class="am-input-group">
                                <a href="javascript:void(0);" class="bgql colorw am-btn am-btn-secondary" onclick="event.preventDefault();document.getElementById('search-form').submit();"><i class="am-icon-search"></i> 搜索</a>
                            </div>
                        </form>
                    </div>

                    <div class="tableList-box marginT30px">
                        <ul class="am-list admin-sidebar-list" id="collapase-nav-1">
                            <!--列表头部-->
                            <li class="am-panel tableList-th">
                                <div class="am-u-sm-3 am-u-sm-offset-1">
                                    显示名称
                                </div>
                                <div class="am-u-sm-3">
                                    路由
                                </div>
                                <div class="am-u-sm-3">
                                    说明
                                </div>
                                <div class="am-u-sm-2">
                                    操作
                                </div>
                                <div style="clear: both;"></div>
                            </li>

                        @if(isset($permissions))
                        @foreach($permissions as $permission)
                            <!--列表大项-->
                            <li class="am-panel tableList-tb">
                                @if(count($permission->subPermission))
                                    <div class="am-u-sm-1 am-text-center">
                                        <a data-am-collapse="{parent: '#collapase-nav-1', target: '#nav-{{ $permission->id }}'}"
                                           class="am-collapsed">
                                            <span class="dropdownicon"><i class="iconfont">&#xe653;</i></span>
                                        </a>
                                    </div>
                                    @else
                                    <div class="am-u-sm-1 "></div>
                                    @endif
                                    <div class="am-u-sm-3">
                                        {{ $permission->display_name }}
                                    </div>
                                    <div class="am-u-sm-3">
                                        {{ $permission->name }}
                                    </div>
                                    <div class="am-u-sm-3">
                                        {{ $permission->description }}
                                    </div>
                                    {{--<div class="am-u-sm-2">--}}
                                        {{--{!! $permission->is_menu==1 ? '<span class="am-btn am-btn-success">是</span>':'<span class="am-btn am-btn-danger">否</span>' !!}--}}
                                    {{--</div>--}}
                                    <div class="am-u-sm-2">
                                        <div class="am-btn-group">
                                            @if(Entrust::can('permission.edit'))
                                                <a href="{{ route('permission.edit',[$permission->id]) }}" type="button" class="am-btn am-btn-primary am-radius">编辑</a>
                                            @endif
                                            @if(Entrust::can('permission.destroy'))
                                                <button type="button" class="am-btn am-btn-danger am-radius" data-am-modal="{target: '#doc-modal-{{ $permission->id }}d', closeViaDimmer: 0}">
                                                    删除
                                                </button>
                                                <!--模态框-----------------------------strat-->

                                                <!--删除权限模态框---------------------------start-->
                                                <div class="am-modal am-modal-no-btn"
                                                     id="doc-modal-{{ $permission->id }}d">
                                                    <div class="am-modal-dialog modalwidth-xxs">
                                                        <div class="am-modal-hd">
                                                            <span class="am-fl"><i
                                                                        class="iconfont color639 ">&#xe610;</i><span>删除权限</span></span>
                                                            <a href="javascript: void(0)" class="am-close am-close-spin"
                                                               data-am-modal-close>&times;</a>
                                                        </div>
                                                        <div class="am-modal-bd am-margin-top">
                                                            <div class="lindiv"></div>
                                                            <p class="am-text-center">确定删除该权限吗？</p>
                                                            <button class="am-btn am-btn-primary br5px" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $permission->id }}df').submit();">
                                                                确定
                                                            </button>
                                                            <button class="am-btn br5px" data-am-modal-close>取消</button>
                                                            <form id="delete-form-{{ $permission->id }}df" action="{{ route('permission.destroy',[ $permission->id ]) }}" method="POST" style="display: none;">
                                                                {{ method_field('DELETE') }}
                                                                {{ csrf_field() }}
                                                            </form>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <!--删除权限模态框---------------------------end-->
                                            <!--模态框-----------------------------end-->
                                        </div>
                                    </div>
                                    <div style="clear: both;"></div>

                                    <!--列表下的小项-->
                                    <ul class="am-list am-collapse admin-sidebar-sub" id="nav-{{ $permission->id }}">
                                        @if(count($permission->subPermission))
                                            @foreach($permission->subPermission as $sub)
                                                <li style="margin-left: 40px">
                                                    @if(count($sub->subPermission))
                                                        <div class="am-u-sm-1 am-text-right">
                                                            <a data-am-collapse="{parent: '#collapase-nav-2', target: '#nav-{{ $sub->id }}'}" class="am-collapsed">
                                                                <span class="dropdownicon"><i class="iconfont">&#xe653;</i></span>
                                                            </a>
                                                        </div>
                                                    @else
                                                        <div class="am-u-sm-1 "></div>
                                                    @endif
                                                    <div class="am-u-sm-3">
                                                        {{ $sub->display_name }}
                                                    </div>
                                                    <div class="am-u-sm-3">
                                                        {{ $sub->name }}
                                                    </div>
                                                    <div class="am-u-sm-3">
                                                        {{ $sub->description }}
                                                    </div>
                                                    {{--<div class="am-u-sm-1">--}}
                                                        {{--{!! $sub->is_menu ==1 ? '<span class="am-btn am-btn-success">是</span>':'<span class="am-btn am-btn-danger">否</span>' !!}--}}
                                                    {{--</div>--}}
                                                    <div class="am-u-sm-2">
                                                        <div class="am-btn-group">
                                                            @if(Entrust::can('permission.edit'))
                                                                <a href="{{ route('permission.edit',[$sub->id]) }}" type="button" class="am-btn am-btn-primary am-radius">编辑</a>
                                                            @endif
                                                            @if(Entrust::can('permission.destroy'))
                                                                <button type="button" class="am-btn am-btn-danger am-radius" data-am-modal="{target: '#doc-modal-{{ $sub->id }}d', closeViaDimmer: 0}">
                                                                    删除
                                                                </button>

                                                                <!--删除权限模态框---------------------------start-->
                                                                <div class="am-modal am-modal-no-btn" id="doc-modal-{{ $sub->id }}d">
                                                                    <div class="am-modal-dialog modalwidth-xxs">
                                                                        <div class="am-modal-hd">
                                                                            <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i><span>删除权限</span></span>
                                                                            <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
                                                                        </div>
                                                                        <div class="am-modal-bd rights-modal am-margin-top">
                                                                            <div class="lindiv"></div>
                                                                            <p class="am-text-center">确定删除该权限吗？</p>
                                                                            <p>
                                                                                <button class="am-btn am-btn-primary br5px" onclick="event.preventDefault();document.getElementById('delete-form-{{ $sub->id }}df').submit();">确定</button>
                                                                                <button class="am-btn br5px" data-am-modal-close>取消</button>
                                                                                <form id="delete-form-{{ $sub->id }}df" action="{{ route('permission.destroy',[ $sub->id ]) }}" method="POST" style="display: none;">
                                                                                    {{ method_field('DELETE') }}
                                                                                    {{ csrf_field() }}
                                                                                </form>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        <!--删除权限模态框---------------------------end-->
                                                            <!--模态框-----------------------------end-->
                                                        </div>
                                                    </div>
                                                    <div style="clear: both;"></div>

                                                    <!--列表下的小项-->
                                                    <ul class="am-list am-collapse admin-sidebar-sub" id="nav-{{ $sub->id }}">
                                                        @if(count($sub->subPermission))
                                                            @foreach($sub->subPermission as $subPermission_1)
                                                                <li style="margin-left: 40px">
                                                                    @if(count($subPermission_1->subPermission))
                                                                        <div class="am-u-sm-1 am-text-right">
                                                                            <a data-am-collapse="{parent: '#collapase-nav-2', target: '#nav-{{ $subPermission_1->id }}'}" class="am-collapsed">
                                                                                <span class="dropdownicon"><i class="iconfont">&#xe653;</i></span>
                                                                            </a>
                                                                        </div>
                                                                    @else
                                                                        <div class="am-u-sm-1 "></div>
                                                                    @endif
                                                                    <div class="am-u-sm-3">
                                                                        {{ $subPermission_1->display_name }}
                                                                    </div>
                                                                    <div class="am-u-sm-3">
                                                                        {{ $subPermission_1->name }}
                                                                    </div>
                                                                    <div class="am-u-sm-3">
                                                                        {{ $subPermission_1->description }}
                                                                    </div>
                                                                    <div class="am-u-sm-1">
                                                                    {!! $sub->is_menu ==1 ? '<span class="am-btn am-btn-success">是</span>':'<span class="am-btn am-btn-danger">否</span>' !!}
                                                                    </div>
                                                                    <div class="am-u-sm-2">
                                                                        <div class="am-btn-group">
                                                                            @if(Entrust::can('permission.edit'))
                                                                                <a href="{{ route('permission.edit',[$subPermission_1->id]) }}" type="button" class="am-btn am-btn-primary am-radius">编辑</a>
                                                                            @endif
                                                                            @if(Entrust::can('permission.destroy'))
                                                                                <button type="button" class="am-btn am-btn-danger am-radius" data-am-modal="{target: '#doc-modal-{{ $sub->id }}d', closeViaDimmer: 0}">删除</button>

                                                                                <!--删除权限模态框---------------------------start-->
                                                                                <div class="am-modal am-modal-no-btn"
                                                                                     id="doc-modal-{{ $subPermission_1->id }}d">
                                                                                    <div class="am-modal-dialog modalwidth-xxs">
                                                                                        <div class="am-modal-hd">
                                                                                        <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i><span>删除权限</span></span>
                                                                                            <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
                                                                                        </div>
                                                                                        <div class="am-modal-bd rights-modal am-margin-top">
                                                                                            <div class="lindiv"></div>
                                                                                            <p class="am-text-center">
                                                                                                确定删除该权限吗？
                                                                                            </p>
                                                                                            <p>
                                                                                                <button class="am-btn am-btn-primary br5px" onclick="event.preventDefault();document.getElementById('delete-form-{{ $subPermission_1->id }}df').submit();">确定</button>
                                                                                                <button class="am-btn br5px" data-am-modal-close>取消
                                                                                                </button>

                                                                                                <form id="delete-form-{{ $subPermission_1->id }}df" action="{{ route('permission.destroy',[ $subPermission_1->id ]) }}" method="POST" style="display: none;">
                                                                                                    {{ method_field('DELETE') }}
                                                                                                    {{ csrf_field() }}
                                                                                                </form>
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        <!--删除权限模态框---------------------------end-->
                                                                            <!--模态框-----------------------------end-->
                                                                        </div>
                                                                    </div>
                                                                    <div style="clear: both;"></div>

                                                                    {{--<!--列表下的小项-->--}}
                                                                   {{-- <ul class="am-list am-collapse admin-sidebar-sub" id="nav-{{ $subPermission_1->id }}">--}}
                                                                        {{--@if(count($subPermission_1->subPermission))--}}
                                                                            {{--@foreach($subPermission_1->subPermission as $subPermission_2)--}}
                                                                                {{--<li style="margin-left: 40px">--}}
                                                                                    {{--<div class="am-u-sm-1">--}}
                                                                                    {{--</div>--}}
                                                                                    {{--<div class="am-u-sm-3">--}}
                                                                                        {{--{{ $subPermission_2->display_name }}--}}
                                                                                    {{--</div>--}}
                                                                                    {{--<div class="am-u-sm-3">--}}
                                                                                        {{--{{ $subPermission_2->name }}--}}
                                                                                    {{--</div>--}}
                                                                                    {{--<div class="am-u-sm-3">--}}
                                                                                        {{--{{ $subPermission_2->description }}--}}
                                                                                    {{--</div>--}}
                                                                                    {{----}}{{----}}{{--<div class="am-u-sm-1">--}}{{----}}{{----}}
                                                                                    {{----}}{{----}}{{--{!! $sub->is_menu ==1 ? '<span class="am-btn am-btn-success">是</span>':'<span class="am-btn am-btn-danger">否</span>' !!}--}}{{----}}{{----}}
                                                                                    {{----}}{{----}}{{--</div>--}}{{----}}{{----}}
                                                                                    {{--<div class="am-u-sm-2">--}}
                                                                                        {{--<div class="am-btn-group">--}}
                                                                                            {{--@if(Entrust::can('permission.edit'))--}}
                                                                                                {{--<a href="{{ route('permission.edit',[$subPermission_2->id]) }}" type="button" class="am-btn am-btn-primary am-radius">编辑</a>--}}
                                                                                            {{--@endif--}}
                                                                                            {{--@if(Entrust::can('permission.destroy'))--}}
                                                                                                {{--<button type="button" class="am-btn am-btn-danger am-radius" data-am-modal="{target: '#doc-modal-{{ $subPermission_1->id }}d', closeViaDimmer: 0}">删除</button>--}}

                                                                                                {{--<!--删除权限模态框---------------------------start-->--}}
                                                                                                {{--<div class="am-modal am-modal-no-btn"--}}
                                                                                                     {{--id="doc-modal-{{ $subPermission_2->id }}d">--}}
                                                                                                    {{--<div class="am-modal-dialog modalwidth-xxs">--}}
                                                                                                        {{--<div class="am-modal-hd">--}}
                                                                                                            {{--<span class="am-fl"><i class="iconfont color639 ">&#xe610;</i><span>删除权限</span></span>--}}
                                                                                                            {{--<a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>--}}
                                                                                                        {{--</div>--}}
                                                                                                        {{--<div class="am-modal-bd rights-modal am-margin-top">--}}
                                                                                                            {{--<div class="lindiv"></div>--}}
                                                                                                            {{--<p class="am-text-center">--}}
                                                                                                                {{--确定删除该权限吗？--}}
                                                                                                            {{--</p>--}}
                                                                                                            {{--<p>--}}
                                                                                                                {{--<button class="am-btn am-btn-primary br5px" onclick="event.preventDefault();document.getElementById('delete-form-{{ $subPermission_2->id }}df').submit();">确定</button>--}}
                                                                                                                {{--<button class="am-btn br5px" data-am-modal-close>取消--}}
                                                                                                                {{--</button>--}}

                                                                                                            {{--<form id="delete-form-{{ $subPermission_2->id }}df" action="{{ route('permission.destroy',[ $subPermission_2->id ]) }}" method="POST" style="display: none;">--}}
                                                                                                                {{--{{ method_field('DELETE') }}--}}
                                                                                                                {{--{{ csrf_field() }}--}}
                                                                                                            {{--</form>--}}
                                                                                                            {{--</p>--}}
                                                                                                        {{--</div>--}}
                                                                                                    {{--</div>--}}
                                                                                                {{--</div>--}}
                                                                                        {{--@endif--}}
                                                                                        {{--<!--删除权限模态框---------------------------end-->--}}
                                                                                            {{--<!--模态框-----------------------------end-->--}}
                                                                                        {{--</div>--}}
                                                                                    {{--</div>--}}
                                                                                    {{--<div style="clear: both;"></div>--}}
                                                                                {{--</li>--}}
                                                                            {{--@endforeach--}}
                                                                        {{--@endif--}}
                                                                    {{--</ul>--}}

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
                        @else
                            <div class="am-center">
                                没有任何数据被发现
                            </div>
                        @endif
                        </ul>
                    </div>
                </div>

                <!--新增权限模态框---------------------------strat-->
                <div class="am-modal am-modal-no-btn" id="doc-modal-1">
                    <div class="am-modal-dialog modalwidth-md">
                        <div class="am-modal-hd">
                            <span class="am-fl"><i class="iconfont color639">&#xe610;</i><span>新增权限</span></span>
                            <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
                        </div>
                        <div class="am-modal-bd rights-modal am-margin-top">
                            <div class="lindiv"></div>
                            <form class="am-form am-form-horizontal am-margin-top" id="addqxform"
                                  action="{{ route('permission.store') }}" method="post">
                                {{ csrf_field() }}
                                <div class="am-form-group">
                                    <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>所属权限组:</label>
                                    <div class="am-u-sm-10">
                                        <div class="am-u-sm-5">
                                            @inject('permissionPresenter','App\Presenters\PermissionPresenter')
                                            {!! $permissionPresenter->topPermissionSelect(isset($permissions) ? $permission->fid : '') !!}
                                        </div>
                                        <label class="am-u-sm-2 am-form-label"><span class="colorred"></span>权限路由:</label>
                                        <div class="am-u-sm-5" style="padding-right: 0;">
                                            <input class="br5px" type="text" placeholder="请输入路由" datatype="*"  nullmsg="请输入路由" sucmsg=" " name="name"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>显示名称:</label>
                                    <div class="am-u-sm-10">
                                        <div class="am-u-sm-5">
                                            <input class="br5px" type="text" placeholder="请输入名称" datatype="*" nullmsg="请输入名称" sucmsg=" " name="display_name"/>
                                        </div>
                                        {{--<label class="am-u-sm-2 am-form-label"><span class="colorred"></span>邮政编码:</label>--}}
                                        {{--<div class="am-u-sm-5" style="padding-right: 0;">--}}
                                            {{--<input name="zip_code" class="br5px" type="text" placeholder="请输入你的邮政编码" datatype="p" errormsg="请输入合法邮政编码" ignore="ignore" />--}}
                                        {{--</div>--}}
                                    </div>
                                </div>
                                <!--一排一列-->
                                <div class="am-form-group">
                                    <label class="am-u-sm-2 am-form-label"><span class="colorred"></span>说明:</label>
                                    <div class="am-u-sm-10">
                                        <textarea class="br5px minheight-xxs" name="description"></textarea>
                                    </div>
                                </div>

                                <div class="am-g am-padding-bottom">
                                    <div class="am-u-sm-12">
                                        @if( Entrust::can('permission.create'))
                                            <button type="submit" class="am-btn am-btn-secondary br5px am-margin-top">提交
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--新增权限模态框---------------------------end-->
            </div>
        </div>
    </div>
    <div id="loading"></div>
@endsection

@section('javascript')
@parent
<script src=" {{ url('js/searchableSelect/jquery.searchableSelect.js') }}" type="text/javascript" charset="utf-8"></script>
    <script>
        $("#fid").searchableSelect();
        $("#addqxform").Validform({
            tiptype: function (msgs, o, cssctl) {
                if (o.type != 2) {     //只有不正确的时候才出发提示，输入正确不提示
                    layer.msg(msgs);
                }
            },
            ajaxPost: false,//true用ajax提交，false用form方式提交
            tipSweep: true,//true只在提交表单的时候开始验证，false每输入完一个输入框之后就开始验证
            beforeSubmit: function (rq) {
                openLoad();
            }
        });
    </script>
@endsection