@extends('layouts.admin-app')
@section('title', '客户管理')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ url('css/main.css') }}">
    <style type="text/css">
        /*.chakan-modal-dialog.am-modal-dialog [class*=am-u-]{padding-left:1rem!important}*/
        /*.chakan-modal-dialog.am-modal-dialog .am-u-sm-2{text-align:right}*/
        p.title button{margin-right:20px}
        .am-dropdown-content,ul.contents>li>a{padding:0;min-width:100px}
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
                <!--项目概况-->
                <div class="dh-main-container">
                    <p class="title fs18">客户管理
                        {{--<a class="am-fr am-btn am-btn-secondary br5px" onclick="event.preventDefault();--}}
                        {{--document.getElementById('uploadify').click();">导入客户</a>--}}

                        {{--<form class="am-hide"  id="import-form" action="{{ route('user.import') }}" method="POST" enctype="multipart/form-data">--}}
                        {{--<input id="uploadify" type="file" name="excelfile"/>--}}
                        {{--{{ csrf_field() }}--}}
                        {{--</form>--}}

                        {{--<a href="{{ route('user.export') }}" class="am-fr am-btn am-btn-white br5px" >导出客户</a>--}}
                        @if(Entrust::can('user.index'))
                            <a class="am-fr am-btn am-btn-secondary br5px" data-am-modal="{target: '#doc-modal-1', closeViaDimmer: 0}">新增客户</a>
                        @endif
                        <div style="clear:both;"></div>
                    </p>

                    <div class="search">
                        <form class="am-form am-form-horizontal am-form-inline" id="search-form" action="{{ route('user.admin.search') }}" method="POST">
                            <div class="am-form-group">
                                <select name="trade" style="min-width: 120px" class="br5px">
                                    <option {{ !isset($trade)  ? 'selected' : '' }} value="">请选择</option>
                                    <option {{ isset($trade) && $trade == 1 ? 'selected' : '' }} value="1">一般贸易</option>
                                    <option {{ isset($trade) && $trade == 0 ? 'selected' : '' }} value="0">加工贸易</option>
                                    <option {{ isset($trade) && $trade == 2 ? 'selected' : '' }} value="2">以上都有</option>
                                </select>
                            </div>
                            <div class="am-input-group">
                                <input style="width: 200px" type="text" name="searchStr" id="" value="" placeholder="可输入企业名称"/>
                                {{ csrf_field() }}
                            </div>
                            <div class="am-input-group">
                                <a href="javascript:void(0);" class="bgql colorw am-btn am-btn-secondary" onclick="event.preventDefault();document.getElementById('search-form').submit();"><i class="am-icon-search"></i> 搜索</a>
                            </div>
                        </form>
                        @if(Entrust::can('admin.user.destroy.all'))
                            <a id="adminUserDestoryAll" class="am-btn am-btn-danger">批量删除</a>
                        @endif
                    </div>
                    <table class="am-table bgfff marginT30px am-table-centered am-table-hovernew">
                        <thead>
                        <tr>
                            <th class="{{ Entrust::can('admin.user.destroy.all') ? '' : 'am-hide' }}"><a id="allChoose" href="javascript:void(0);" class="am-btn am-btn-white am-btn-xs br5px ">全选</a></th>
                            <th>企业名称</th>
                            <th>地址</th>
                            <th style="min-width: 80px">贸易类型</th>
                            <th style="min-width: 80px">AEO认证</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($users))
                            @foreach($users as $user)
                                <tr>
                                    <td style="min-width: 75px;" class="am-text-middle {{ Entrust::can('admin.user.destroy.all') ? '' : 'am-hide' }}">
                                        <input class="{{ isset($user->hands) && isset($user->user_departs) ? 'am-hide' : '' }}" name="ids" value="{{ $user->id }}" type="checkbox" style="width: 16px; height: 16px;">
                                    </td>
                                    <td class="am-text-middle">{{ $user->name }}</td>
                                    <td class="am-text-middle">{{ $user->address }}</td>
                                    @if($user->trade == 0)
                                        <td class="am-text-middle">加工贸易</td>
                                    @elseif($user->trade == 1)
                                        <td class="am-text-middle">一般贸易</td>
                                    @elseif($user->trade == 2)
                                        <td class="am-text-middle">以上都有</td>
                                    @else
                                        <td class="am-text-middle">无</td>
                                    @endif

                                    @if($user->aeo == 0)
                                        <td class="am-text-middle">一般认证</td>
                                    @elseif($user->aeo == 1)
                                        <td class="am-text-middle">高级认证</td>
                                    @else
                                        <td class="am-text-middle">无</td>
                                    @endif
                                    <td class="am-text-middle" style="min-width: 360px;">

                                        <div class="am-btn-group">
                                            @if( Entrust::can('user.edit') )
                                                <a href="{{ route('user.edit',[$user->id]) }}" type="button" class="am-btn am-btn-secondary am-radius">编辑</a>
                                            @endif

                                            <div class="am-dropdown" data-am-dropdown>
                                                @if(Entrust::can('handover.index') )
                                                    <a href="javascript:void(0);" class="am-btn am-btn-success am-dropdown-toggle" data-am-dropdown-toggle>交接单</a>
                                                @endif
                                                <ul class="am-dropdown-content contents">
                                                    @if(count($user->hands))
                                                        @if(Entrust::can('handover.index'))
                                                            <li><a href="{{ route('handover.show',[$user->id]) }}">
                                                                    <button type="button" class="am-btn am-btn-secondary am-radius">查看交接单</button>
                                                                </a></li>
                                                        @endif
                                                        @if(Entrust::can('handover.edit'))
                                                            <li><a href="{{ route('handover.edit',[$user->id]) }}">
                                                                    <button type="button" class="am-btn am-btn-warning am-radius">修改交接单</button>
                                                                </a></li>
                                                        @endif
                                                    @else
                                                        @if(Entrust::can('handover.create'))
                                                            <li>
                                                                <a href="{{ route('handover.create',[$user->id]) }}">
                                                                    <button type="button" class="am-btn am-btn-41 am-radius">新增交接单</button>
                                                                </a>
                                                            </li>
                                                        @endif
                                                    @endif
                                                </ul>
                                            </div>

                                            @if(Entrust::can('depart.show'))
                                                <a href="{{ route('depart.show',[$user->id]) }}" class="am-btn am-btn-75 am-radius">子账号管理</a>
                                            @endif
                                            @if(Entrust::can('user.destroy'))
                                                <a href="javascript:void(0);" class="am-btn am-btn-danger am-radius {{ isset($user->hands) && isset($user->user_departs) ? 'am-hide' : '' }}" data-am-modal="{target: '#doc-modal-{{ $user->id }}d', closeViaDimmer: 0}">删除</a>
                                            @endif
                                        <!--删除---------------------------start-->
                                            <div class="am-modal am-modal-no-btn" id="doc-modal-{{ $user->id }}d">
                                                <div class="am-modal-dialog modalwidth-xxs">
                                                    <div class="am-modal-hd">
                                                        <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i><span>删除客户</span></span>
                                                        <a href="javascript: void(0)" class="am-close am-close-spin"
                                                           data-am-modal-close>&times;</a>
                                                    </div>
                                                    <div class="am-modal-bd rights-modal am-margin-top">
                                                        <div class="lindiv"></div>
                                                        <p class="am-text-center">
                                                            确定删除该客户吗？
                                                        </p>
                                                        <p>
                                                            <button class="am-btn am-btn-primary br5px"
                                                                    onclick="event.preventDefault();
                                                                            document.getElementById('delete-form-{{ $user->id }}df').submit();">
                                                                确定
                                                            </button>

                                                            <button class="am-btn br5px" data-am-modal-close>取消</button>

                                                        <form id="delete-form-{{ $user->id }}df"
                                                              action="{{ route('user.destroy',[ $user->id ]) }}"
                                                              method="POST" style="display: none;">
                                                            {{ method_field('DELETE') }}
                                                            {{ csrf_field() }}
                                                        </form>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--删除---------------------------end-->
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                               <td>没有发现任何数据</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    <!--分页样式-->
                    {!! $users->render() !!}

                </div>
            </div>
        </div>
    </div>
    <!--模态框-----------------------------strat-->

    <!--新增客户模态框---------------------------strat-->
    <div class="am-modal am-modal-no-btn" id="doc-modal-1">
        <div class="am-modal-dialog modalwidth-lg">
            <div class="am-modal-hd">
                <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i>新增客户</span>
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <div class="am-modal-bd rights-modal am-margin-top">
                <div class="lindiv"></div>
                <form class="am-form am-form-horizontal am-margin-top" id="addkhform" action="{{ route('user.store') }}"
                      method="post">
                {{ csrf_field() }}
                <!--一排一列-->
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>企业注册名称</label>
                        <div class="am-u-sm-10">
                            <input name="name" class="br5px" type="text" placeholder="请输入企业注册名称" datatype="*"
                                   nullmsg="请输入企业注册名称">
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>企业注册地址</label>
                        <div class="am-u-sm-10">
                            <input name="address" class="br5px" type="text" placeholder="请输入企业注册地址" datatype="*"
                                   nullmsg="请输入企业注册地址">
                        </div>
                    </div>
                    <!--一排两列-->
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>企业联系电话</label>
                        <div class="am-u-sm-10">
                            <div class="am-u-sm-5">
                                <input name="tel" type="text" class="br5px" onkeyup="replaceAndSetPos(this,/[\u4E00-\u9FA5\s]/g,'')" oninput="replaceAndSetPos(this,/[\u4E00-\u9FA5\s]/g,'')" placeholder="请输入企业联系电话" datatype="guhua|m"
                                       nullmsg="请输入企业联系电话" errormsg="请输入合法的联系电话" />
                            </div>
                            <label class="am-u-sm-2 am-form-label"><span class="colorred"></span>企业传真号码</label>
                            <div class="am-u-sm-5" style="padding-right: 0;">
                                <input name="fax" class="br5px" type="text" onkeyup="replaceAndSetPos(this,/[\u4E00-\u9FA5\s]/g,'')" oninput="replaceAndSetPos(this,/[\u4E00-\u9FA5\s]/g,'')" placeholder="请输入企业传真号码" datatype="guhua|m" ignore="ignore" nullmsg="请输入企业传真号码" errormsg="请输入合法的传真号码">
                            </div>
                        </div>
                    </div>
                    <!--一排两列-->
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label"><span class="colorred"></span>企业联系邮箱</label>
                        <div class="am-u-sm-10">
                            <div class="am-u-sm-5">
                                <input id="" name="email" type="text" onkeyup="replaceAndSetPos(this,/[\u4E00-\u9FA5\s]/g,'')" oninput="replaceAndSetPos(this,/[\u4E00-\u9FA5\s]/g,'')" class="am-form-field" placeholder="请输入企业联系邮箱"
                                       ignore="ignore" datatype="e"/>
                            </div>
                            <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>成立日期</label>
                            <div class="am-u-sm-5" style="padding-right: 0;">
                                <input id="create_date" name="create_date" type="text" class="am-form-field"
                                       placeholder="请选择成立日期" data-am-datepicker readonly required datatype="*"
                                       nullmsg="请选择成立日期"/>
                            </div>
                        </div>
                    </div>
                    <!--一排两列-->
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>注册资本</label>
                        <div class="am-u-sm-10">
                            <div class="am-u-sm-5">
                                <input name="capital" type="text" class="br5px" placeholder="请输入注册资本" datatype="*"
                                       nullmsg="请输入注册资本"/>
                            </div>
                            <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>海关识别码</label>
                            <div class="am-u-sm-5" style="padding-right: 0;">
                                <input name="code" class="br5px uppercase" maxlength="10" onkeyup="replaceAndSetPos(this,/[\u4E00-\u9FA5\s]/g,'')" oninput="replaceAndSetPos(this,/[\u4E00-\u9FA5\s]/g,'')" type="text" placeholder="请输入你的海关识别码" datatype="hgsbm"
                                       nullmsg="请输入你的海关识别码" errormsg="请输入合法的10位海关识别码">
                            </div>
                        </div>
                    </div>
                    <!--一排两列-->
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>AEO认证</label>
                        <div class="am-u-sm-10">
                            <div class="am-u-sm-5">
                                <div class="am-input-group br5px widthMax">
                                    <select class="br5px" name="aeo" id="aeo">
                                        <option value="-2">请选择</option>
                                        <option value="-1">无</option>
                                        <option value="0">一般认证</option>
                                        <option value="1">高级认证</option>
                                    </select>
                                </div>
                            </div>
                            <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>贸易方式</label>
                            <div class="am-u-sm-5" style="padding-right: 0;">
                                <div class="am-input-group br5px widthMax">
                                    <select class="br5px" name="trade" id="trade">
                                        <option value="-1" selected>请选择</option>
                                        <option value="0">加工贸易</option>
                                        <option value="1">一般贸易</option>
                                        <option value="2">以上都有</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!--一排两列-->
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label"><span class="colorred"></span>生产项目类别</label>
                        <div class="am-u-sm-10">
                            <div class="am-u-sm-5">
                                <input name="pro_item_type" type="text" class="br5px"/>
                            </div>
                            <div id="trade_manual_box" style="display: none;">
                                <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>加工贸易手册</label>
                                <div class="am-u-sm-5" style="padding-right: 0;">
                                    <div class="br5px widthMax">
                                        <select class="br5px" name="trade_manual" id="trade_manual">
                                            <option value="-1">请选择</option>
                                            <option value="0">电子化手册</option>
                                            <option value="1">电子账册</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span
                                    class="colorred"></span>主要进出口贸易方式</label>
                        <div class="am-u-sm-10">
                            <textarea name="main_trade"  class="minheight-xxs br5px"></textarea>
                            {{--<input name="main_trade" type="text" class="br5px" placeholder="请输入主要进出口贸易方式" datatype="*" nullmsg="请输入主要进出口贸易方式" />--}}
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label"><span class="colorred"></span>备注</label>
                        <div class="am-u-sm-10">
                            <textarea name="remark" class="minheight-xxs br5px"></textarea>
                        </div>
                    </div>
                    <div class="am-form-group">
                        @if(Entrust::can('user.index'))
                            <input type="submit" class="am-btn am-btn-secondary br5px am-margin-top" value="提交">
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--新增客户模态框---------------------------end-->
    <!--模态框-----------------------------end-->
@endsection


@section('javascript')
    @parent
    // <script src="/../js/main.js" type="text/javascript" charset="utf-8"></script>
    <script>
        //	全选功能
        var ft = false;
        $("#allChoose").click(function () {
            ft = !ft;
            $('input[name="ids"]').prop("checked", ft);
            $('input[name="ids"].am-hide').prop("checked", false);
        });
        {{--设置同步提交ajax--}}
        $.ajaxSetup({
                    async: false
                     });
        //联动（贸易类型和加工贸易手册两个下拉框）
        $("#trade").change(function () {
            if ($("#trade").val() == -1 || $("#trade").val() == 1) {
                $("#trade_manual_box").hide();
                 $("#trade_manual").html('<option value="-1" selected>请选择</option><option value="0">电子化手册</option><option value="1">电子账册</option>');
            } else {
                $("#trade_manual_box").show();
            }
        });

        $("#addkhform").Validform({
            tiptype: function (msgs, o, cssctl) {
                if (o.type != 2) {     //只有不正确的时候才出发提示，输入正确不提示
                    layer.msg(msgs);
                }
            },
            ajaxPost: false,//true用ajax提交，false用form方式提交
            tipSweep: true,//true只在提交表单的时候开始验证，false每输入完一个输入框之后就开始验证
            //验证前的动作
            beforeCheck: function (curform) {
            },
            //表单提交之前的动作
            beforeSubmit: function (curforms) {
                //没有选择aeo的时候提示
                if ($("#aeo").val() == -2) {
                    layer.msg('请选择AEO认证类型');
                    return false;
                }
                //贸易方式未选择
                if ($("#trade").val() == -1) {
                    layer.msg('请选择贸易方式');
                    return false;
                }
                //贸易方式选择了加工贸易或者以上都是的时候，加工贸易手册要必选，反则返回false不能提交
                else if ($("#trade").val() == 0 || $("#trade").val() == 2) {
                    if ($("#trade_manual").val() == -1) {
                        layer.msg('请选择加工贸易手册');
                        return false;
                    }
                }
                openLoad();
            }


        });
        //修改客户信息按钮
        $(".amend-btn").click(function () {
            $('#chakan-modal-1').modal('close');
        });

        $("#adminUserDestoryAll").click(function () {
            AjaxJson('/admin/user/destroyall', {ids: CheckboxValshu('ids')}, function (data) {
                if (data.status == 1) {
                    layer.msg(data.msg);
                    window.location.reload();
                } else {
                    layer.msg(data.msg);
                }
            })
        })

    </script>
@endsection