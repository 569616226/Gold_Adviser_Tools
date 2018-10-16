@extends('layouts.admin-app')
@section('title', '子账号管理-客户管理')
@section('css')
    @parent
    <link rel="stylesheet" href="/../css/main.css">

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
                    <p class="title fs18"><a href="{{ route('user.index') }}"><i class="iconfont">&#xe604;</i></a>子账号管理(<span>{{ $user->name }}</span>)
                        @if(Entrust::can('user.index'))
                            <button class="am-fr am-btn am-btn-secondary br5px"
                                    data-am-modal="{target: '#doc-modal-1', closeViaDimmer: 0}">新增子账号
                            </button>
                        @endif
                    </p>
                    <div class="search">
                        <form id="search-form" action="{{ route('depart.search',[$user->id]) }}" class="am-form am-form-horizontal am-form-inline"
                              method="post">

                            {{ csrf_field() }}
                            <div class="am-form-group">
                                <div class="am-form-group">
                                    <input style="width: 200px" type="text" name="searchStr"
                                           placeholder="可输入员工姓名/用户名"/>
                                </div>
                                <div class="am-input-group">
                                    <a href="javascript:void(0);" class="bgql colorw am-btn am-btn-secondary" onclick="event.preventDefault();document.getElementById('search-form').submit();"><i class="am-icon-search"></i> 搜索</a>
                                </div>
                                @if(Entrust::can('depart.destroy.all'))
                                    <a id="adminUserDestoryAll" class="am-btn am-btn-danger">批量删除</a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <table class="am-table bgfff marginT30px am-table-centered am-table-hovernew">
                        <thead>
                        <tr>
                            <th>多选</th>
                            <th>用户名</th>
                            <th>姓名</th>
                            <th>角色</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody class="tbpadd2rem">
                        @if(count($departs))
                            @foreach($departs as $depart)
                                @if($depart->active == 1)
                                    <tr>
                                        <td><input name="ids" value="{{ $depart->id }}" type="checkbox"/></td>

                                        <td>{{ $depart->username }}</td>
                                        <td>{{ $depart->name }}</td>
                                        <td>
                                            @if($depart->croles()->count())
                                                @foreach($depart->croles()->get() as $role)
                                                    <span class="role-box">{{ $role->display_name }}</span>
                                                @endforeach
                                            @else
                                                无
                                            @endif
                                        </td>
                                        <td>{{ $depart->created_at }}</td>
                                        <td>

                                            <div class="am-btn-group">
                                                {{--编辑子账号--}}
                                                @if(Entrust::can('depart.edit'))
                                                    <a href="{{ route('depart.edit',[$depart->id,$user->id]) }}"
                                                       type="button" class="am-btn am-btn-primary am-radius">编辑</a>
                                                @endif

                                                {{--冻结子账号--}}
                                                @if(Entrust::can('user.frozen'))
                                                    <button type="button" class="am-btn am-btn-success am-radius"
                                                            data-am-modal="{target: '#doc-modal-{{ $depart->id }}dj', closeViaDimmer: 0}">
                                                        冻结
                                                    </button>

                                                    <!--冻结---------------------------start-->
                                                    <div class="am-modal am-modal-no-btn"
                                                         id="doc-modal-{{ $depart->id }}dj">
                                                        <div class="am-modal-dialog modalwidth-xxs">
                                                            <div class="am-modal-hd">
                                                                <span class="am-fl"><i
                                                                            class="iconfont color639 ">&#xe610;</i><span>冻结用户</span></span>
                                                                <a href="javascript: void(0)" class="am-close am-close-spin"
                                                                   data-am-modal-close>&times;</a>
                                                            </div>
                                                            <div class="am-modal-bd rights-modal am-margin-top">
                                                                <div class="lindiv"></div>
                                                                <p class="am-text-center">
                                                                    确定冻结该用户吗？
                                                                </p>
                                                                <p>
                                                                    <button class="am-btn am-btn-primary br5px"
                                                                            onclick="event.preventDefault();
                                                                                    document.getElementById('delete-form-{{ $depart->id }}dej').submit();">
                                                                        确定
                                                                    </button>

                                                                    <button class="am-btn br5px" data-am-modal-close>取消
                                                                    </button>

                                                                <form id="delete-form-{{ $depart->id }}dej"
                                                                      action="{{ route('user.frozen',[ $depart->id,$user->id ]) }}"
                                                                      method="POST" style="display: none;">

                                                                    {{ csrf_field() }}
                                                                </form>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                {{--删除子账号--}}
                                                @if(Entrust::can('depart.destroy'))
                                                    <button type="button" class="am-btn am-btn-danger am-radius"
                                                            data-am-modal="{target: '#doc-modal-{{ $depart->id }}d', closeViaDimmer: 0}">
                                                        删除
                                                    </button>

                                                    <!--删除---------------------------start-->
                                                    <div class="am-modal am-modal-no-btn" id="doc-modal-{{ $depart->id }}d">
                                                        <div class="am-modal-dialog modalwidth-xxs">
                                                            <div class="am-modal-hd">
                                                                <span class="am-fl"><i
                                                                            class="iconfont color639 ">&#xe610;</i><span>删除用户</span></span>
                                                                <a href="javascript: void(0)" class="am-close am-close-spin"
                                                                   data-am-modal-close>&times;</a>
                                                            </div>
                                                            <div class="am-modal-bd rights-modal am-margin-top">
                                                                <div class="lindiv"></div>
                                                                <p class="am-text-center">
                                                                    确定删除该用户吗？
                                                                </p>
                                                                <p>
                                                                    <button class="am-btn am-btn-primary br5px"
                                                                            onclick="event.preventDefault();
                                                                                    document.getElementById('delete-form-{{ $depart->id }}df').submit();">
                                                                        确定
                                                                    </button>

                                                                    <button class="am-btn br5px" data-am-modal-close>取消
                                                                    </button>

                                                                <form id="delete-form-{{ $depart->id }}df"
                                                                      action="{{ route('depart.destroy',[ $depart->id,$user->id ]) }}"
                                                                      method="POST" style="display: none;">
                                                                    {{--{{ method_field('DELETE') }}--}}
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
                                @elseif($depart->active == 0 && Entrust::can('user.frozen'))
                                    <tr>
                                        <td><input name="ids" value="{{ $depart->id }}" type="checkbox"/></td>

                                        <td>{{ $depart->username }}</td>
                                        <td>{{ $depart->contacter }}</td>
                                        <td>
                                            @if($depart->croles()->count())
                                                @foreach($depart->croles()->get() as $role)
                                                    <span class="role-box">{{ $role->display_name }}</span>
                                                @endforeach
                                            @else
                                                无
                                            @endif
                                        </td>
                                        <td>{{ $depart->created_at }}</td>
                                        <td>

                                            <div class="am-btn-group">
                                                {{--解冻客户--}}
                                                <button type="button" class="am-btn am-btn-warning am-radius"
                                                        data-am-modal="{target: '#doc-modal-{{ $depart->id }}rf', closeViaDimmer: 0}">
                                                    解冻
                                                </button>
                                                <!--解冻---------------------------start-->
                                                <div class="am-modal am-modal-no-btn" id="doc-modal-{{ $depart->id }}rf">
                                                    <div class="am-modal-dialog modalwidth-xxs">
                                                        <div class="am-modal-hd">
                                                            <span class="am-fl"><i
                                                                        class="iconfont color639 ">&#xe610;</i><span>解冻用户</span></span>
                                                            <a href="javascript: void(0)" class="am-close am-close-spin"
                                                               data-am-modal-close>&times;</a>
                                                        </div>
                                                        <div class="am-modal-bd rights-modal am-margin-top">
                                                            <div class="lindiv"></div>
                                                            <p class="am-text-center">
                                                                确定解冻该用户吗？
                                                            </p>
                                                            <p>
                                                                <button class="am-btn am-btn-primary br5px"
                                                                        onclick="event.preventDefault();
                                                                                document.getElementById('delete-form-{{ $depart->id }}drf').submit();">
                                                                    确定
                                                                </button>

                                                                <button class="am-btn br5px" data-am-modal-close>取消</button>

                                                            <form id="delete-form-{{ $depart->id }}drf"
                                                                  action="{{ route('user.refrozen',[ $depart->id,$user->id ]) }}"
                                                                  method="POST" style="display: none;">
                                                                {{ csrf_field() }}
                                                            </form>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @else
                        <tr>
                            <td colspan="6">没有发现任何数据</td>
                        </tr>
                        @endif
                        </tbody>
                    </table>

                    {!! $departs->render() !!}

                </div>
            </div>

        </div>
    </div>
    <!--模态框-----------------------------strat-->

    <!--新增员工模态框---------------------------strat-->
    <div class="am-modal am-modal-no-btn" id="doc-modal-1">
        <div class="am-modal-dialog modalwidth-md">
            <div class="am-modal-hd">
                <span class="am-fl"><i class="iconfont color639">&#xe610;</i><span>新增子账号</span></span>
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <div class="am-modal-bd rights-modal am-margin-top">
                <div class="lindiv"></div>
                <form class="am-form am-form-horizontal am-margin-top" id="addygform"
                      action="{{ route('depart.store',[$user->id	]) }}" method="post">
                    {{ csrf_field() }}
                    <div class="am-g">
                        <div class="am-form-group am-u-sm-6" style="padding: 0;">
                            <label class="am-u-sm-3 am-form-label"><span class="colorred">* </span>姓名:</label>
                            <div class="am-u-sm-9">
                                <input name="name" class="br5px" type="text" placeholder="请输入姓名" datatype="*" nullmsg="请输入姓名" sucmsg=" "/>
                            </div>
                        </div>

                        <div class="am-form-group am-u-sm-6" style="padding: 0;">
                            <label class="am-u-sm-3 am-form-label"><span class="colorred">* </span>用户名:</label>
                            <div class="am-u-sm-9">
                                <input name="username" class="br5px" type="text" placeholder="请输入用户名" datatype="*"
                                       nullmsg="请输入用户名" sucmsg=" "/>
                            </div>
                        </div>
                    </div>

                    <div class="am-g">
                        <div class="am-form-group am-u-sm-6" style="padding: 0;">
                            <label class="am-u-sm-3 am-form-label"><span class="colorred">* </span>密码:</label>
                            <div class="am-u-sm-9">
                                <input name="password" class="br5px" type="text" placeholder="请输入密码" datatype="*6-20"
                                       nullmsg="请输入密码"/>
                            </div>
                        </div>
                        <div class="am-form-group am-u-sm-6" style="padding: 0;">
                            <label class="am-u-sm-3 am-form-label"><span class="colorred">* </span>选择角色:</label>
                            <div class="am-u-sm-9">
                                <select name="roles[]" class="br5px" multiple data-am-selected id="selectroles">
                                    @foreach($roles as $role)
                                        <option selected value="{{ $role->id }}">{{ $role->display_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <div class="am-u-sm-12">
                            @if(Entrust::can('depart.create'))
                                <button type="submit" class="am-btn am-btn-secondary br5px am-margin-top">提交</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--新增权限模态框---------------------------end-->
    <!--模态框-----------------------------end-->
@endsection

@section('javascript')
    @parent
    <script src="/../js/main.js" type="text/javascript" charset="utf-8"></script>
    <script>
        $("#addygform").Validform({
            tiptype: function (msgs, o, cssctl) {
                if (o.type != 2) { //只有不正确的时候才出发提示，输入正确不提示
                    layer.msg(msgs);
                }
            },
            ajaxPost: false, //true用ajax提交，false用form方式提交
            tipSweep: true, //true只在提交表单的时候开始验证，false每输入完一个输入框之后就开始验证
            //ajax提交完之后的回调函数
            beforeSubmit: function (curform) {
                if($("#selectroles").val()==null){
                    layer.msg('请选择角色')
                    return false;
                }
                openLoad()
            }
        });

        //        批量删除
        $("#adminUserDestoryAll").click(function () {
            AjaxJson('/admin/user/depart/destroyall', {ids: CheckboxValshu('ids')}, function (data) {
                if (data.status == 1) {
                    layer.msg(data.msg);
                    window.location.reload();
                } else {
                    layer.msg(data.msg);
                }
            });
        });
    </script>
@endsection
