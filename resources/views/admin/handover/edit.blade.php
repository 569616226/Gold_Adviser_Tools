@extends('layouts.admin-app')
@section('title', '交接单编辑')

@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="/../js/umeditor/themes/default/css/umeditor.min.css"/>
    <link rel="stylesheet" href="/../css/main.css">
    <style type="text/css">
        .edui-container{width:100%!important}
        .edui-body-container{min-height:250px!important}
        .am-table-bordered>tbody>tr:first-child>th{border-left:1px solid #ddd}
        .am-table-bordered>thead>tr>th{border-bottom:1px solid #ddd}
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
                <!--项目概况-->
                <div class="dh-main-container">
                    <form class="am-form am-form-horizontal am-margin-top" action="{{ route('handover.update',[$hand->id,$user->id])}}" method="post" id="xmjjd">
                        <input id="user_id" type="hidden" value="{{ $user->id }}"/>
                        <input id="hand_id" type="hidden" value="{{ $hand->id }}"/>
                        {{ csrf_field() }}
                        <p class="title fs18"><a href="{{ route('handover.show',[$user->id]) }}"><i class="iconfont">&#xe604;</i></a>项目交接单
                            ({{ $hand->name }})
                            {{--@if(Entrust::can('handover.edit'))--}}
                                {{--<a href="javascript:void(0);" id="falshBtn" class="am-fr am-btn am-btn-secondary br5px">提交</a>--}}
                            {{--@endif--}}
                        </p>
                        <div class="am-margin-top">
                            <div class="am-g" id="formbox1">
                                <div class="sreceiptCard sreceiptCard0">
                                    <h3>项目基本信息</h3>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-2 am-form-label"><span
                                                    class="colorred">* </span>选择审核机构：</label>
                                        <div class="am-u-sm-10">
                                            <select name="mech_id" class="br5px" data-am-selected>
                                                @foreach($mechs as $mech)
                                                    <option value="{{ $mech->id }}" {{ $hand->mech_id == $hand->id ? 'selected':'' }}>{{ $mech->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!--一排一列-->
                                    <div class="am-form-group">
                                        <label class="am-u-sm-2 am-form-label"><span
                                                    class="colorred">* </span>项目名称：</label>
                                        <div class="am-u-sm-10">
                                            <input name="name" value="{{ $hand->name }}" class="br5px" type="text"
                                                   placeholder="请输入你的注册名称" datatype="*" nullmsg="请输入你的项目名称">
                                        </div>
                                    </div>

                                    <!--一排两列-->
                                    <div class="am-form-group">
                                        <label class="am-u-sm-2 am-form-label"><span
                                                    class="colorred">* </span>项目有效期：</label>
                                        <div class="am-u-sm-10">
                                            <div class="am-u-sm-5">
                                                <input type="text" style="background: white" class="am-form-field"
                                                       placeholder="请输入项目有效期" data-am-datepicker readonly required
                                                       datatype="*" nullmsg="请输入项目有效期" name="end_time"
                                                       value="{{ $hand->end_time }}"/>
                                            </div>
                                            <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>合同编号：</label>
                                            <div class="am-u-sm-5" style="padding-right: 0;">
                                                <input class="br5px" type="text" placeholder="请输入你的合同编号" maxlength="20" onkeyup="replaceAndSetPos(this,/\W/g,'')" oninput="replaceAndSetPos(this,/\W/g,'')"  datatype="sz" nullmsg="请输入你的合同编号" errormsg="请输入不超过20的合法的合同编号" name="handover_no" value="{{ $hand->handover_no }}">
                                            </div>
                                        </div>
                                    </div>
                                    <!--一排两列-->
                                    <div class="am-form-group">
                                        <label class="am-u-sm-2 am-form-label"><span
                                                    class="colorred">* </span>客户公司名称：</label>
                                        <div class="am-u-sm-10">
                                            <div class="am-u-sm-5">
                                                <div class="am-input-group br5px widthMax">
                                                    <input class="br5px" type="text" readonly="true"
                                                           placeholder="请输入客户公司名称" value="{{ $user->name }}">
                                                </div>
                                            </div>
                                            <label class="am-u-sm-2 am-form-label"><span class="colorred">* </span>客户公司电话</label>
                                            <div class="am-u-sm-5" style="padding-right: 0;">
                                                <div class="br5px widthMax">
                                                    <input class="br5px" type="text" readonly="true"
                                                           placeholder="请输入客户公司电话" value="{{ $user->tel }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--一排一列-->
                                    <div class="am-form-group">
                                        <label class="am-u-sm-2 am-form-label"><span
                                                    class="colorred">* </span>客户公司地址：</label>
                                        <div class="am-u-sm-10">
                                            <input class="br5px" type="text" placeholder="请输入客户公司地址" readonly="true"
                                                   value="{{ $user->address }}">
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-2 am-form-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <span class="colorred">* </span>项目描述：
                                        </label>
                                        <div class="am-u-sm-10">
                                            {{--<textarea name="description" rows="8" style="min-height: 180px !important;">{{ $hand->description }}</textarea>--}}
                                            <script type="text/plain" id="myEditor" >{!!  html_entity_decode(stripslashes($hand->description)) !!}</script>
                                            <!--<input type="text" class="br5px" placeholder="请输入主要进出口贸易方式" datatype="*" nullmsg="请输入主要进出口贸易方式" />-->
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="am-g am-margin-top">
                                <div class="sreceiptCard">
                                    <h3>客户联系资料</h3>
                                    <div>
                                        <table id="formbox2"
                                               class="am-table am-table-bordered am-table-centered am-table-compact tabinpbordernone">
                                            <thead>
                                            <tr>
                                                <th class="am-text-middle">负责人</th>
                                                <th class="am-text-middle">职务</th>
                                                <th class="am-text-middle">电话</th>
                                                <th class="am-text-middle">固话</th>
                                                <th class="am-text-middle">邮件</th>
                                                <th class="am-text-middle">操作</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr class="am-text-center">
                                                <td colspan="6">
                                                    <a id="addrowbtn" href="javascript:void(0)">
                                                        <i class="iconfont" style="position: relative; top: 2px;">&#xe622;</i>
                                                        添加新的负责人
                                                    </a>
                                                </td>
                                            </tr>
                                            </tfoot>
                                            <tbody id="contacts">
                                            @foreach($hand->contacts as $contact)
                                                <tr class="main">
                                                    <input class="contacter_id" type="hidden" value="{{$contact->id}}"
                                                           name="contacter_id">
                                                    <td><input type="text" name="contacter"
                                                               value="{{ $contact->contacter }}" datatype="*"
                                                               nullmsg="负责人姓名不能为空"/></td>
                                                    <td><input type="text" name="busniess"
                                                               value="{{ $contact->business }}" datatype="*"
                                                               nullmsg="职务不能为空"/></td>
                                                    <td><input type="text" name="phone" value="{{ $contact->phone }}" onkeyup="replaceAndSetPos(this,/[\u4E00-\u9FA5\s]/g,'')" oninput="replaceAndSetPos(this,/[\u4E00-\u9FA5\s]/g,'')" datatype="m" nullmsg="手机不能为空" errormsg="请输入合法手机号码"/></td>
                                                    <td><input type="text" name="wechat"
                                                               value="{{ $contact->wechat }}"/></td>
                                                    <td><input type="text" name="email" value="{{ $contact->email }}"  onkeyup="replaceAndSetPos(this,/[\u4E00-\u9FA5\s]/g,'')" oninput="replaceAndSetPos(this,/[\u4E00-\u9FA5\s]/g,'')" datatype="e" ignore="ignore" errormsg="请输入合法邮箱地址"/></td>
                                                    <td class="am-text-middle"><a onclick="dfrowsql(this)" href="javascript:void(0)" class="colorred">删除</a></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <div class="am-form-group" id="formbox3">
                                            <label>营销中心建议：</label>
                                            <textarea name="suggest" class="minheight-xxs br5px">{{ $hand->suggest }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="am-margin-top am-text-center">
                                @if(Entrust::can('handover.index')&& Entrust::can('user.index')&& Entrust::can('handover.create'))
                                    <a href="javascript:void(0);" id="falshBtn" class="am-btn am-btn-secondary br5px">提交</a>
                                @endif
                                <a href="{{ route('user.index') }}"  class="am-btn am-btn-white br5px">返回</a>
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
    <script src="/../js/umeditor/third-party/template.min.js" type="text/javascript" charset="utf-8" ></script>
    <script src="/../js/umeditor/umeditor.config.js" type="text/javascript"
            charset="utf-8"></script>
    <script src="/../js/umeditor/umeditor.min.js" type="text/javascript"
            charset="utf-8"></script>
    <script src="/../js/main.js" type="text/javascript" charset="utf-8"></script>
    <script>
        //实例化编辑器
        var um = UM.getEditor('myEditor');
        $("#xmjjd").Validform({
            tiptype: function (msgs, o, cssctl) {
                if (o.type != 2) {     //只有不正确的时候才出发提示，输入正确不提示
                    layer.msg(msgs);
                }
            },
            btnSubmit: "#falshBtn",
            ajaxPost: true,//true用ajax提交，false用form方式提交
            tipSweep: true,//true只在提交表单的时候开始验证，false每输入完一个输入框之后就开始验证
            beforeSubmit: function (curform) {
//            获取项目基本信息和营销中心建议的数据
                var container = JsonInsert(GetWebControls('#formbox1'), GetWebControls('#formbox3'));
                container = JsonInsert(container, {'description':UM.getEditor('myEditor').getContent()});
                if(UM.getEditor('myEditor').getContent() == ""){
                    layer.msg("请输入项目描述");
                    return false;
                }
                var user_id = $('#user_id').val();
                var hand_id = $('#hand_id').val();
                var url = "/admin/handover/" + hand_id + "/update/" + user_id;
                // 跳转接口
                var onurl = '/admin/handover/' + user_id + '/show';
//            获取联系人的数据（数组形式）
                var contacts = [];
                $("#formbox2 tr.main").each(function (e) {
                    var $this = $(this);
                    contacts.push(GetWebControls($this))
                });
                openLoad();
                AjaxJson(url, {'container': container, 'contacts': contacts}, function (data) {
                    if (data.status == 1) {
                        layer.msg(data.msg);
                        setTimeout(function () {
                            window.location.href = onurl;
                        },1500)
                    } else {
                        layer.msg(data.msg);
                        setTimeout(function () {
                            window.location.href = onurl;
                        },1500)
                    }

                });
//            console.log(contacs);
                return false;
            }
        });


        //增加一行
        $("#addrowbtn").click(function () {
            var strVar = "";
            strVar += '<tr class="main"><input class="contacter_id" type="hidden" value="" name="contacter_id">';
            strVar += '<td class="am-text-middle"><input type="text" name="contacter" datatype="*" nullmsg="负责人姓名不能为空" /></td>';
            strVar += '<td class="am-text-middle"><input type="text" name="busniess" datatype="*" nullmsg="职务不能为空" /></td>';
            strVar += '<td class="am-text-middle"><input type="text" name="phone"  datatype="m" nullmsg="手机不能为空" errormsg="请输入合法手机号码" /></td>';
            strVar += '<td class="am-text-middle"><input type="text" name="wechat"/></td>';
            strVar += '<td class="am-text-middle"><input type="text" name="email" datatype="e" ignore="ignore"  errormsg="请输入合法邮箱地址" /></td>';
            strVar += '<td  class="am-text-middle"><a onclick="dfrow(this)" href="javascript:void(0)" class="colorred">删除</a></td></tr>';
            $("#contacts").append(strVar);
        });

        //客户端删除
        function dfrow(e) {
            layer.msg('确定删除该行吗？', {
                time: 0 //不自动关闭
                , btn: ['确定', '取消']
                , yes: function (index) {
                    $(e).parents("tr").remove();
                    layer.close(index);
                }
            });
        }


        //数据库删除
        function dfrowsql(e) {
            var user_id = $('#user_id').val();
            var contacter_id = $(e).parents('.main').find(".contacter_id").val();
            var dfurl = '/admin/handover/' + contacter_id + '/destroy';
            layer.msg('确定删除该行吗？', {
                time: 0 //不自动关闭
                , btn: ['确定', '取消']
                , yes: function (index) {
                    AjaxJson(dfurl, {}, function (data) {
                        if (data.status == 1) {
                            layer.msg(data.msg);
                            $(e).parents("tr").remove();
                            layer.close(index);
                        }
                    });
                }
            });
        }


    </script>
@endsection