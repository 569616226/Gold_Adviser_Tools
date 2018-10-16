@extends('layouts.admin-app')
@section('title', '审核机构')
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
                    <p class="title fs18">审核机构管理
                        @if(Entrust::can('mech.create'))
                            <button class="am-fr am-btn am-btn-secondary br5px" data-am-modal="{target: '#doc-modal-1', closeViaDimmer: 0}">新增审核机构</button>
                        @endif
                    </p>
                    <div class="search">
                        <form action="{{ route('mech.search') }}" class="am-form am-form-horizontal am-form-inline" id="search-form" method="POST">
                            {{ csrf_field() }}
                            <div class="am-form-group">
                                    <input style="width: 260px" type="text" name="searchStr"
                                           placeholder="可输入机构名称/负责人/审核团队"/>
                            </div>
                            <div class="am-input-group">
                                <a href="javascript:void(0);" class="bgql colorw am-btn am-btn-secondary" onclick="event.preventDefault();document.getElementById('search-form').submit();"><i class="am-icon-search"></i> 搜索</a>
                            </div>
                        </form>
                    </div>

                    <table class="am-table bgfff marginT30px am-table-centered am-table-hovernew">
                        <thead>
                        <tr>
                            <!--<th>多选</th>-->
                            <th>机构名称</th>
                            <th>地址</th>
                            <th>负责人</th>
                            <th>电话</th>
                            <th>传真电话</th>
                            <th>审核团队</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mechs as $mech)
                            <tr>
                                <!--<td><input type="checkbox" style="width: 16px; height: 16px;" /></td>-->
                                <td class="am-text-middle am-text-left">{{ $mech->name }}</td>
                                <td class="am-text-middle am-text-left">{{ $mech->address }}</td>
                                <td class="am-text-middle" style="min-width: 70px;">{{ $mech->master }}</td>
                                <td class="am-text-middle">{{ $mech->master_tel }}</td>
                                <td class="am-text-middle">{{ $mech->master_fax }}</td>
                                <td class="am-text-middle" style="min-width: 120px">{{ $mech->verify_team }}</td>
                                <td class="am-text-middle" style="min-width: 150px">
                                    <div class="am-btn-group">
                                        @if(Entrust::can('mech.edit'))
                                            <a href="{{ route('mech.edit',[$mech->id]) }}" type="button" class="am-btn am-btn-primary am-radius">编辑</a>
                                        @endif

                                        @if( Entrust::can('mech.destroy'))
                                            <button type="button" class="am-btn am-btn-danger  am-radius" data-am-modal="{target: '#doc-modal-4', closeViaDimmer: 0}">
                                                删除
                                            </button>
                                            <!--删除---------------------------start-->
                                            <div class="am-modal am-modal-no-btn" id="doc-modal-4">
                                                <div class="am-modal-dialog modalwidth-xxs">
                                                    <div class="am-modal-hd">
                                                        <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i><span>删除审核机构</span></span>
                                                        <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
                                                    </div>
                                                    <div class="am-modal-bd rights-modal am-margin-top">
                                                        <div class="lindiv"></div>
                                                        <p class="am-text-center">
                                                            确定删除该审核机构吗？
                                                        </p>
                                                        <p>
                                                            <button class="am-btn am-btn-primary br5px" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $mech->id }}df').submit();">
                                                                确定
                                                            </button>
                                                            <button class="am-btn br5px" data-am-modal-close>取消</button>
                                                            <form id="delete-form-{{ $mech->id }}df"
                                                                  action="{{ route('mech.destroy',[ $mech->id ]) }}"
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
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $mechs->render() }}
                </div>
            </div>

        </div>
    </div>
    <!--模态框-----------------------------strat-->

    <!--新增审核机构模态框---------------------------strat-->
    <div class="am-modal am-modal-no-btn" id="doc-modal-1">
        <div class="am-modal-dialog modalwidth-lg">
            <div class="am-modal-hd">
                <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i>新增审核机构</span>
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <div class="am-modal-bd rights-modal am-margin-top">
                <div class="lindiv"></div>
                <form class="am-form am-form-horizontal am-margin-top" id="addkhform" action="{{ route('mech.store') }}"
                      method="post">
                {{ csrf_field() }}
                <!--一排两列-->
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>名称:</label>
                        <div class="am-u-sm-10">
                            <div class="am-u-sm-5">
                                <input name="name" type="text" class="am-form-field" placeholder="请输入名称" datatype="*"
                                       nullmsg="请输入名称"/>
                            </div>
                            <label class="am-u-sm-2 am-form-label"><span class="colorred"></span>邮政编码:</label>
                            <div class="am-u-sm-5" style="padding-right: 0;">
                                <input name="zip_code" class="br5px" type="text" placeholder="请输入你的邮政编码" datatype="p" errormsg="请输入合法邮政编码" ignore="ignore" />
                            </div>
                        </div>
                    </div>
                    <!--一排一列-->
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>通讯地址:</label>
                        <div class="am-u-sm-10">
                            <input name="address" class="br5px" type="text" placeholder="请输入你的通讯地址" datatype="*" nullmsg="请输入你的通讯地址" />
                        </div>
                    </div>

                    <!--一排两列-->
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>审核团队:</label>
                        <div class="am-u-sm-10">
                            <div class="am-u-sm-5">
                                <input name="verify_team" type="text" class="br5px" placeholder="请输入审核团队" datatype="*"  nullmsg="请输入审核团队" />
                            </div>
                            <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>电子邮箱:</label>
                            <div class="am-u-sm-5" style="padding-right: 0;">
                                <input name="email" class="br5px" type="text" placeholder="请输入电子邮箱" datatype="e"
                                       nullmsg="请输入电子邮箱" errormsg="请输入合法的邮箱地址" />
                            </div>
                        </div>
                    </div>

                    <!--一排两列-->
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>负责人:</label>
                        <div class="am-u-sm-10">
                            <div class="am-u-sm-5">
                                <input name="master" type="text" class="br5px" placeholder="请输入负责人" datatype="*"
                                       nullmsg="请输入负责人"/>
                            </div>
                            <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>项目督导</label>
                            <div class="am-u-sm-5" style="padding-right: 0;">
                                <input name="super" type="text" class="br5px" placeholder="请输入项目督导" datatype="*" nullmsg="请输入项目督导" />
                            </div>
                        </div>
                    </div>

                    <!--一排两列-->
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>负责人电话:</label>
                        <div class="am-u-sm-10">
                            <div class="am-u-sm-5">
                                <input name="master_tel" type="text" class="br5px" placeholder="请输入负责人电话" datatype="guhua|m" nullmsg="请输入负责人电话" errormsg="请输入合法电话格式" />
                            </div>
                            <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>项目督导电话:</label>
                            <div class="am-u-sm-5" style="padding-right: 0;">
                                <input name="super_tel" class="br5px" type="text" placeholder="请输入项目督导电话" datatype="guhua|m" nullmsg="请输入项目督导电话" errormsg="请输入合法电话格式" />
                            </div>
                        </div>
                    </div>
                    <!--一排两列-->
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label"><span class="colorred"></span>负责人传真:</label>
                        <div class="am-u-sm-10">
                            <div class="am-u-sm-5">
                                <input name="master_fax" type="text" class="br5px" placeholder="请输入负责人传真" ignore="ignore" datatype="guhua|m" errormsg="请输入合法传真格式" />
                            </div>
                            <label class="am-u-sm-2 am-form-label"><span class="colorred"></span>项目督导传真:</label>
                            <div class="am-u-sm-5" style="padding-right: 0;">
                                <input name="super_fax" class="br5px" type="text" placeholder="请输入项目督导传真" ignore="ignore" datatype="guhua|m" errormsg="请输入合法传真格式" />
                            </div>
                        </div>
                    </div>

                    <div class="am-form-group">
                        @if(Entrust::can('mech.create'))
                            <button type="submit" class="am-btn am-btn-secondary br5px am-margin-top">提交</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--新增审核机构模态框---------------------------end-->


    <!--模态框-----------------------------end-->
@endsection
@section('javascript')
    @parent
    <script src="/../js/main.js" type="text/javascript" charset="utf-8"></script>
    <script>
        $("#addkhform").Validform({
            tiptype: function (msgs, o, cssctl) {
                if (o.type != 2) { //只有不正确的时候才出发提示，输入正确不提示
                    layer.msg(msgs);
                }
            },
            ajaxPost: false, //true用ajax提交，false用form方式提交
            tipSweep: true, //true只在提交表单的时候开始验证，false每输入完一个输入框之后就开始验证
            //ajax提交完之后的回调函数
            beforeSubmit: function (curform) {
                openLoad();
            }
        });
    </script>
@endsection