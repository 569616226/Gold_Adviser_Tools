@extends('layouts.admin-app')
@section('title', '角色管理')

@section('css')
    @parent
    <link rel="stylesheet" href="/../css/main.css">
    <style type="text/css">
        #collapase-nav-1 li {
            border: none !important;
            background: #F5FAFC;
        }

        #collapase-nav-1 > li {
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
                <nav class="dh-nav">
                    <!--右侧菜单-->
                    @include('admin._partials.rbac-left-menu')
                </nav>
            </div>
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10" id="rightMain">
                <!--项目概况-->
                <div class="dh-main-container">
                    <p class="title fs18">角色管理
                        @if(Entrust::can('role.create'))
                            <button class="am-fr am-btn am-btn-secondary br5px"
                                    data-am-modal="{target: '#doc-modal-1', closeViaDimmer: 0}">新增角色
                            </button>
                        @endif
                    </p>
                    <div class="search">
                        <form id="search-form" action="{{ route('role.search') }}" method="POST" class="am-form am-form-horizontal am-form-inline">
                            {{ csrf_field() }}
                            <div class="am-form-group">
                                <input style="width: 200px" type="text" name="searchStr"
                                       placeholder="可输入员工姓名"/>
                            </div>
                            <div class="am-input-group">
                                <a href="javascript:void(0);" class="bgql colorw am-btn am-btn-secondary" onclick="event.preventDefault();document.getElementById('search-form').submit();"><i class="am-icon-search"></i> 搜索</a>
                            </div>
                        </form>
                        {{--<a class="am-btn am-btn-danger">批量删除</a>--}}
                    </div>
                    @if(isset($roles))
                    <table class="am-table bgfff marginT30px am-table-centered am-table-hovernew">
                        <thead>
                        <tr>
                            <th>标识</th>
                            <th>角色名</th>
                            <th>创建时间</th>
                            <th>说明</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody class="tbpadd2rem">

                            @foreach($roles  as $role)
                                <tr>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->display_name }}</td>
                                    <td>{{ $role->created_at }}</td>
                                    <td>{{ $role->description }}</td>
                                    <td>
                                        <div class="am-btn-group">
                                            @if(Entrust::can('role.edit'))
                                                <a href="{{ route('role.edit',[$role->id]) }}" type="button"
                                                   class="am-btn am-btn-primary am-radius">编辑</a>
                                            @endif
                                            @if(Entrust::can('admin.role.permissions'))
                                            <a type="button" href="{{ route('admin.role.permissions',[$role->id]) }}"
                                               class="am-btn am-btn-5e am-radius">权限</a>
                                            @endif
                                            @if(Entrust::can('role.destroy'))
                                                <button type="button" class="am-btn am-btn-danger am-radius"
                                                        data-am-modal="{target: '#doc-modal-{{ $role->id }}d', closeViaDimmer: 0}">
                                                    删除
                                                </button>


                                                <!--删除---------------------------start-->
                                                <div class="am-modal am-modal-no-btn" id="doc-modal-{{ $role->id }}d">
                                                    <div class="am-modal-dialog modalwidth-xxs">
                                                        <div class="am-modal-hd">
                                                            <span class="am-fl"><i
                                                                        class="iconfont color639 ">&#xe610;</i><span>删除职位</span></span>
                                                            <a href="javascript: void(0)" class="am-close am-close-spin"
                                                               data-am-modal-close>&times;</a>
                                                        </div>
                                                        <div class="am-modal-bd rights-modal am-margin-top">
                                                            <div class="lindiv"></div>
                                                            <p class="am-text-center">
                                                                确定删除该职位吗？
                                                            </p>
                                                            <p>
                                                                <button class="am-btn am-btn-primary br5px"
                                                                        onclick="event.preventDefault();
                                                                                document.getElementById('delete-form-{{ $role->id }}df').submit();">
                                                                    确定
                                                                </button>

                                                                <button class="am-btn br5px" data-am-modal-close>取消</button>

                                                            <form id="delete-form-{{ $role->id }}df" action="{{ route('role.destroy',[ $role->id ]) }}" method="POST" style="display: none;">
                                                                {{ method_field('DELETE') }}
                                                                {{ csrf_field() }}
                                                            </form>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                        @endif
                                        <!--删除---------------------------end-->
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    {!! $roles->render() !!}
                    @else
                        <table class="am-table bgfff marginT30px am-table-centered am-table-hovernew">
                            <thead>
                            <tr>
                                <th>标识</th>
                                <th>角色名</th>
                                <th>创建时间</th>
                                <th>说明</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody class="tbpadd2rem">
                            <tr>
                                <td>没有发现任何数据</td>
                            </tr>
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!--模态框-----------------------------strat-->

    <!--新增职位模态框---------------------------strat-->
    <div class="am-modal am-modal-no-btn" id="doc-modal-1">
        <div class="am-modal-dialog modalwidth-md">
            <div class="am-modal-hd">
                <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i><span>新增</span></span>
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <div class="am-modal-bd rights-modal am-margin-top">
                <div class="lindiv"></div>
                <form class="am-form am-form-horizontal am-margin-top am-padding-right-lg" id="addzwform" action="{{ route('role.store') }}" method="post">
                    {{ csrf_field() }}
                    <div class="am-g">
                        {{--<div class="am-form-group am-u-sm-6" style="padding: 0;">--}}
                            {{--<label class="am-u-sm-3 am-form-label"><span class="colorred">* </span>标识:</label>--}}
                            {{--<div class="am-u-sm-9">--}}
                                {{--<input name="name" class="br5px" type="text" placeholder="请输入标识" datatype="*" nullmsg="请输入标识" sucmsg=" "/>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="am-form-group am-u-sm-6" style="padding: 0;">--}}
                            {{--<label class="am-u-sm-3 am-form-label"><span class="colorred">* </span>角色名:</label>--}}
                            {{--<div class="am-u-sm-9">--}}
                                {{--<input name="display_name" class="br5px" type="text" placeholder="请输入用户名" datatype="*" nullmsg="请输入用户名" sucmsg=" "/>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>标识</label>
                        <div class="am-u-sm-10" style="padding-left: 0;">
                            <div class="am-u-sm-5">
                                <input name="name" value="" class="br5px" type="text"
                                       placeholder="请输入标识" datatype="*" nullmsg="请输入标识" sucmsg=" "/>
                            </div>
                            <label class="am-u-sm-2 am-form-label"><span
                                        class="colorred">* </span>角色名</label>
                            <div class="am-u-sm-5" style="padding-right: 0;">
                                <input name="display_name" value="" class="br5px"
                                       type="text" placeholder="请输入用户名" datatype="*" nullmsg="请输入用户名"
                                       sucmsg=" "/>
                            </div>
                        </div>
                    </div>
                    <div class="am-g am-margin-top">
                        <label class="am-u-sm-2 am-form-label">说明:</label>
                        <div class="am-u-sm-10" style="padding-left: 0;">
                            <textarea name="description" class="br5px minheight-xxs"></textarea>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <div class="am-u-sm-12">
                            @if( Entrust::can('role.create'))
                                <button type="submit" class="am-btn am-btn-secondary br5px am-margin-top">提交</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--新增职位模态框---------------------------end-->
    <!--模态框-----------------------------end-->
@endsection


@section('javascript')
    @parent
    <script src="/../js/main.js" type="text/javascript" charset="utf-8"></script>
    <script>
//        $.ajaxSetup({
//            async:false
//        })
        $("#addzwform").Validform({
            tiptype: function (msgs, o, cssctl) {
                if (o.type != 2) {     //只有不正确的时候才出发提示，输入正确不提示
                    layer.msg(msgs);
                }

            },
            ajaxPost: false,//true用ajax提交，false用form方式提交
            tipSweep: true,//true只在提交表单的时候开始验证，false每输入完一个输入框之后就开始验证
            //ajax提交完之后的回调函数
            beforeSubmit:function (curfomr) {
                openLoad();
            },
//            callback: function (rq) {
//                window.location.reload();
//            }

        });

    </script>
@endsection