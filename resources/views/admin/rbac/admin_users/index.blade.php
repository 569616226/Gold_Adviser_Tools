@extends('layouts.admin-app')
@section('title', '员工管理')

@section('css')
    @parent
    <link rel="stylesheet" href="/../css/main.css">
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

                    <p class="title fs18">员工管理
                        @if( Entrust::can('admin_user.create'))
                            <button class="am-fr am-btn am-btn-secondary br5px"
                                    data-am-modal="{target: '#doc-modal-1', closeViaDimmer: 0}">新增员工
                            </button>
                        @endif
                    </p>

                    <div class="search">
                        <form id="search-form" action="{{ route('admin_user.search') }}" method="POST"
                              class="am-form am-form-horizontal am-form-inline">
                            <div class="am-form-group">
                                    <input style="width: 200px" type="text" name="searchStr"
                                           placeholder="可输入员工姓名/用户名"/>
                                    {{ csrf_field() }}
                            </div>
                            <div class="am-input-group">
                                <a href="javascript:void(0);" class="bgql colorw am-btn am-btn-secondary" onclick="event.preventDefault();document.getElementById('search-form').submit();"><i class="am-icon-search"></i> 搜索</a>
                            </div>
                        </form>
                        @if(Entrust::can('admin.admin_user.destroy.all'))
                            <a id="adminUserDestoryAll" class="am-btn am-btn-danger">批量删除</a>
                        @endif
                    </div>

                    <table class="am-table bgfff marginT30px am-table-centered am-table-hovernew">
                        <thead>
                        <tr>
                            <th><a id="allChoose" href="javascript:void(0);" class="am-btn am-btn-white am-btn-xs br5px">全选</a></th>
                            <th>姓名</th>
                            <th>用户名</th>
                            <th>角色</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody class="tbpadd2rem">
                        @if(count($admin_users))
                        @foreach($admin_users as  $admin_user)
                            @if($admin_user->active == 1)
                                <tr>
                                    <td><input name="ids" value="{{ $admin_user->id }}" type="checkbox"
                                               style="width: 16px; height: 16px;"/></td>
                                    <td>{{ $admin_user->name }}</td>
                                    <td>{{ $admin_user->username }}</td>
                                    <td>
                                        @if($admin_user->roles()->count())
                                            @foreach($admin_user->roles()->get() as $role)
                                                <span class="role-box">{{ $role->display_name }}</span>
                                            @endforeach
                                        @else
                                            无
                                        @endif
                                    </td>
                                    <td>{{ $admin_user->created_at }}</td>
                                    <td>
                                        <div class="am-btn-group">

                                            {{--编辑员工--}}
                                            @if( Entrust::can('admin_user.edit'))
                                                <a href="{{ route('admin_user.edit',[$admin_user->id]) }}" type="button"
                                                   class="am-btn am-btn-primary am-radius">编辑</a>
                                            @endif

                                            {{--冻结员工--}}
                                            @if(Entrust::can('admin_user.frozen'))
                                                <button type="button" class="am-btn am-btn-success am-radius"
                                                        data-am-modal="{target: '#doc-modal-{{ $admin_user->id }}dj', closeViaDimmer: 0}">
                                                    冻结
                                                </button>

                                                <!--冻结---------------------------start-->
                                                <div class="am-modal am-modal-no-btn"
                                                     id="doc-modal-{{ $admin_user->id }}dj">
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
                                                                                document.getElementById('delete-form-{{ $admin_user->id }}dej').submit();">
                                                                    确定
                                                                </button>

                                                                <button class="am-btn br5px" data-am-modal-close>取消
                                                                </button>

                                                            <form id="delete-form-{{ $admin_user->id }}dej"
                                                                  action="{{ route('admin_user.frozen',[ $admin_user->id ]) }}"
                                                                  method="POST" style="display: none;">
                                                                {{--{{ method_field('DELETE') }}--}}
                                                                {{ csrf_field() }}
                                                            </form>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            {{--删除员工--}}
                                            @if(Entrust::can('admin_user.destroy'))
                                                <button type="button" class="am-btn am-btn-danger am-radius"
                                                        data-am-modal="{target: '#doc-modal-{{ $admin_user->id }}de', closeViaDimmer: 0}">
                                                    删除
                                                </button>

                                                <!--删除---------------------------start-->
                                                <div class="am-modal am-modal-no-btn"
                                                     id="doc-modal-{{ $admin_user->id }}de">
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
                                                                                document.getElementById('delete-form-{{ $admin_user->id }}df').submit();">
                                                                    确定
                                                                </button>

                                                                <button class="am-btn br5px" data-am-modal-close>取消
                                                                </button>

                                                            <form id="delete-form-{{ $admin_user->id }}df"
                                                                  action="{{ route('admin_user.destroy',[ $admin_user->id ]) }}"
                                                                  method="POST" style="display: none;">
                                                                {{ method_field('DELETE') }}
                                                                {{ csrf_field() }}
                                                            </form>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @elseif($admin_user->active == 0 && Entrust::can('admin_user.frozen'))
                                <tr>
                                    <td><input name="ids" value="{{ $admin_user->id }}" type="checkbox"
                                               style="width: 16px; height: 16px;"/></td>
                                    <td>{{ $admin_user->name }}</td>
                                    <td>{{ $admin_user->username }}</td>
                                    <td>
                                        @if($admin_user->roles()->count())
                                            @foreach($admin_user->roles()->get() as $role)
                                                <span class="role-box">{{ $role->display_name }}</span>
                                            @endforeach
                                        @else
                                            无
                                        @endif
                                    </td>
                                    <td>{{ $admin_user->created_at }}</td>
                                    <td>
                                        <div class="am-btn-group">
                                            {{--解冻员工--}}
                                            <button type="button" class="am-btn am-btn-warning am-radius"
                                                    data-am-modal="{target: '#doc-modal-{{ $admin_user->id }}rf', closeViaDimmer: 0}">
                                                解冻
                                            </button>
                                            <!--解冻---------------------------start-->
                                            <div class="am-modal am-modal-no-btn"
                                                 id="doc-modal-{{ $admin_user->id }}rf">
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
                                                                            document.getElementById('delete-form-{{ $admin_user->id }}drf').submit();">
                                                                确定
                                                            </button>

                                                            <button class="am-btn br5px" data-am-modal-close>取消</button>

                                                        <form id="delete-form-{{ $admin_user->id }}drf"
                                                              action="{{ route('admin_user.refrozen',[ $admin_user->id ]) }}"
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
                            没有发现任何数据
                        @endif
                        </tbody>
                    </table>
                    {!! $admin_users->render() !!}
                </div>
            </div>
        </div>
    </div>

    <!--模态框-----------------------------strat-->

    <!--新增员工模态框---------------------------strat-->
    <div class="am-modal am-modal-no-btn" id="doc-modal-1">
        <div class="am-modal-dialog modalwidth-md">
            <div class="am-modal-hd">
                <span class="am-fl"><i class="iconfont color639">&#xe610;</i><span>新增员工</span></span>
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <div class="am-modal-bd rights-modal am-margin-top">
                <div class="lindiv"></div>
                <form class="am-form am-form-horizontal am-margin-top" id="addygform"
                      action="{{ route('admin_user.store')}}" method="post">
                    {{ csrf_field() }}
                    <div class="am-g">

                        <div class="am-form-group am-u-sm-6" style="padding: 0;">
                            <label class="am-u-sm-3 am-form-label"><span class="colorred">* </span>姓名:</label>
                            <div class="am-u-sm-9">
                                <input name="name" class="br5px" type="text" placeholder="请输入姓名" datatype="*"
                                       nullmsg="请输入姓名" sucmsg=" "/>
                            </div>
                        </div>
                        <div class="am-form-group am-u-sm-6" style="padding: 0;">
                            <label class="am-u-sm-3 am-form-label"><span class="colorred">* </span>用户名:</label>
                            <div class="am-u-sm-9">
                                <input id="username" name="username" class="br5px" type="text" placeholder="请输入用户名"
                                       datatype="*" nullmsg="用户名不能为空" sucmsg=" "/>
                            </div>
                        </div>
                    </div>

                    <div class="am-g">
                        <div class="am-form-group am-u-sm-6" style="padding: 0;">
                            <label class="am-u-sm-3 am-form-label"><span class="colorred">* </span>手机号:</label>
                            <div class="am-u-sm-9">
                                <input name="tel" class="br5px" type="text" placeholder="请输入手机号" datatype="m" onkeyup="replaceAndSetPos(this,/[\u4E00-\u9FA5\s]/g,'')" oninput="replaceAndSetPos(this,/[\u4E00-\u9FA5\s]/g,'')" nullmsg="手机号不能为空" sucmsg=" " errormsg="请输入合法手机号"/>
                            </div>
                        </div>

                        <div class="am-form-group am-u-sm-6" style="padding: 0;">
                            <label class="am-u-sm-3 am-form-label"><span class="colorred">* </span>密码:</label>
                            <div class="am-u-sm-9">
                                <input name="password" class="br5px" type="text" placeholder="请输入密码" datatype="*6-20"
                                       nullmsg="密码不能为空" sucmsg=" " errormsg="请输入6到20位的密码"/>
                            </div>
                        </div>
                    </div>
                    <div class="am-g">
                        <div class="am-form-group am-u-sm-6" style="padding: 0;">
                            <label class="am-u-sm-3 am-form-label"><span class="colorred">* </span>选择职位:</label>
                            <div class="am-u-sm-9">
                                <select name="roles[]" class="br5px" multiple data-am-selected datatype="*"
                                        nullmsg="请选择角色">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="am-form-group am-u-sm-6" style="padding: 0;">
                            <label class="am-u-sm-3 am-form-label">电子邮箱:</label>
                            <div class="am-u-sm-9">
                                <input name="email" class="br5px" type="text" placeholder="请输入电子邮箱" datatype="/^\s*$/|e"
                                       errormsg="请输入合法邮箱" sucmsg=" "/>
                            </div>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <div class="am-u-sm-12">
                            @if(Entrust::can('admin_user.create'))
                                <button type="submit" class="am-btn am-btn-secondary br5px am-margin-top">提交</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--新增权限模态框---------------------------end-->

@endsection

@section('javascript')
    @parent
    <script src="/../js/main.js" type="text/javascript" charset="utf-8"></script>
    <script>

        //	全选功能
        var ft = false;
        $("#allChoose").click(function () {
            ft = !ft;
            $('input[name="ids"]').prop("checked", ft);
        })

        {{--设置同步提交ajax--}}
        $.ajaxSetup({
            async: false
        });
        $("#addygform").Validform({
            tiptype: function (msgs, o, cssctl) {
                if (o.type != 2) {     //只有不正确的时候才出发提示，输入正确不提示
                    layer.msg(msgs);
                }
            },
            ajaxPost: false,//true用ajax提交，false用form方式提交
            tipSweep: true,//true只在提交表单的时候开始验证，false每输入完一个输入框之后就开始验证
//             验证完提交前的动作
            beforeSubmit: function (curform) {
                var Ttmsg = true;
                openLoad();
                $.post("admin_user/checkdata", {username: $("#username").val()}, function (data) {
                    if (data.status == 1) {
                        layer.msg("用户名已存在");
                        closeLoad()
                        Ttmsg = false
                    }
                });
                return Ttmsg
            }
        });


        //批量删除
        $("#adminUserDestoryAll").click(function () {
              if(CheckboxValshu('ids') == ""){
                  layer.msg("请勾选删除项")
              }else {
                  AjaxJson('admin_user/destroyall', {ids: CheckboxValshu('ids')}, function (data) {
                      if (data.status == 1) {
                          layer.msg(data.msg);
                          window.location.reload();
                      } else {
                          layer.msg(data.msg);
                      }
                  });
              }
        });
    </script>
@endsection