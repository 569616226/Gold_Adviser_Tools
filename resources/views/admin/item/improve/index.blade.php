@extends('layouts.admin-app')
@section('title', '改善实施计划')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ url('css/main.css') }}">
    <style type="text/css">
        .am-table-bordered>tbody>tr:first-child>th{border-left:1px solid #ddd}
        .tabCard{display:none}
        .tabCard.active{display:block}
        .new-tabs-box .am-active a{color:#000!important}
    </style>
@endsection
@section('content')

    <div class="dh-main">
        <div class="am-g">
            <div class="am-u-sm-3 am-u-md-3 am-u-lg-2 bgfff" id="leftNav">
                @include('admin._partials.item-left-menu')
            </div>
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10" id="rightMain">
                <div class="dh-main-container">
                    <p class="title fs18">供应链定制化服务实施计划
                        @if(Entrust::can('improve.preview'))
                            <a href="{{ route('improve.preview',[$item->id]) }}" target="_blank" class="am-fr am-btn am-btn-white br5px am-margin-left-xs">在线预览</a>
                        @endif
                        {{--<button class="am-fr am-btn am-btn-white br5px">导出PDF</button>--}}
                        <a href="{{ route('improve.preview.active',[$item->id]) }}" class="am-fr am-btn am-btn-white br5px am-margin-left-xs {{ Entrust::can('improve.preview.active') ? '': 'am-hide' }} ">交付客户</a>
                    </p>
                    <div class="pro-card marginT30px">
                        <div class="am-g">
                            <div class="am-u-sm-10">
                                <p class="am-g">
                                    <span class="color888 am-u-sm-3 am-text-right">实施辅导单位：</span>
                                    <span>{{ $item->hands->name }}</span>
                                </p>
                                <p class="am-g">
                                    <span class="color888 am-u-sm-3 am-text-right">顾问总负责人：</span>
                                    <span>{{ $creater->name }}</span>
                                </p>
                                <p class="am-g">
                                    <span class="color888 am-u-sm-3 am-text-right">项目执行负责人：</span>
                                    <span>{{ isset($fuser) ? $fuser->name : '无' }}</span>
                                </p>
                                <p class="am-g">
                                    <span class="color888 am-u-sm-3 am-text-right">实施时间：</span>
                                    <time>{{ $item->improve_startDate->toDateString() }} 至 {{  $item->improve_endDate->toDateString() }}</time>
                                </p>
                            </div>
                            <div class="am-u-sm-1 am-text-center">
                                @if(Entrust::can('improve.edit'))
                                    <a href="{{ route('improve.edit',[$item->id]) }}" class="am-btn am-btn-primary br5px am-btn-sm {{ $item->diag_active == 0 ? 'am-hide' : ''}}">编辑</a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="pro-card am-margin-top" style="padding-top: 1rem">
                        <ul class="am-nav am-g am-nav-pills new-tabs-box" id="navlist">
                            @foreach($improves  as $improve )
                                @if ($loop->first)
                                    <li class="am-active">
                                        <a href="javascript:void(0);">{{ $improve->name }}</a>
                                    </li>
                                @endif
                                @if ($loop->index == 0)
                                    @continue
                                @endif
                                <li>
                                    <a href="javascript:void(0);">{{ $improve->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="lindiv am-g"></div>
                        <div id="containerlist">

                            @foreach($improves  as $improve )
                                @if ($loop->first)
                                    <div class="tabCard active">
                                        <table class="am-table am-table-compact am-table-bordered am-table-centered am-margin-top-lg">
                                            <thead>
                                                <tr class="am-active">
                                                    <th class="am-text-middle" style="width: 120px;">项目</th>
                                                    <th class="am-text-middle" style="width: 440px;">服务内容</th>
                                                    <th class="am-text-middle" style="width: 300px;">服务目标</th>
                                                    <th class="am-text-middle" style="min-width: 82px;">执行类型</th>
                                                    <th class="am-text-middle" style="min-width: 120px;">开始时间</th>
                                                    <th class="am-text-middle" style="min-width: 120px;">结束时间</th>
                                                    <th class="am-text-middle" style="min-width: 82px;">负责人</th>
                                                    <th class="am-text-middle" style="min-width: 82px;">备注</th>
                                                    <th class="am-text-middle" style="min-width: 82px;">管理</th>
                                                </tr>
                                            </thead>

                                            @foreach($improve->improve_list_tems as $improve_list)
                                                @foreach($improve_list->improve_con_tems as $improve_con_tem)
                                                    @if($loop->iteration == 1 )
                                                        <tr>
                                                        <td class="am-text-middle am-text-left" rowspan="{{ count($improve_list->improve_con_tems) }}">
                                                                {{ $improve_list->name }}
                                                            </td>
                                                        <td class="am-text-middle am-text-left">{{ $improve_con_tem->content }}</td>
                                                        <td class="am-text-middle am-text-left" rowspan="{{ count($improve_list->improve_con_tems) }}">
                                                            {{ $improve_list->target }}
                                                        </td>
                                                        <td class="am-text-middle am-text-center">{{ $improve_con_tem->type }}</td>
                                                        <td class="am-text-middle am-text-center">{{ $improve_con_tem->start_date }}</td>
                                                        <td class="am-text-middle am-text-center">{{ $improve_con_tem->end_date }}</td>
                                                        <td class="am-text-middle am-text-center">{{ $improve_con_tem->master }}</td>
                                                        <td class="am-text-middle am-text-left">{{ $improve_con_tem->remark }}</td>
                                                        <td class="am-text-middle">
                                                            <a href="javascript:void(0);" class="am-btn am-btn-white am-btn-sm br5px {{ Entrust::can('task.settask')
                                                             || $is_see ? '' : 'am-hide' }}" name="{{ $improve_con_tem->id  }}" onclick="fpfun(this)">分配</a>
                                                        </td>
                                                    </tr>
                                                    @else
                                                        <tr>
                                                            <td class="am-text-middle am-text-left">{{ $improve_con_tem->content }}</td>
                                                            <td class="am-text-middle am-text-center">{{ $improve_con_tem->type }}</td>
                                                            <td class="am-text-middle am-text-center">{{ $improve_con_tem->start_date }}</td>
                                                            <td class="am-text-middle am-text-center">{{ $improve_con_tem->end_date }}</td>
                                                            <td class="am-text-middle am-text-center">{{ $improve_con_tem->master }}</td>
                                                            <td class="am-text-middle am-text-left">{{ $improve_con_tem->remark }}</td>
                                                            <td class="am-text-middle">
                                                                <a href="javascript:void(0);" class="am-btn am-btn-white am-btn-sm br5px {{ Entrust::can('task.settask')
                                                                 || $is_see ? '' : 'am-hide' }}" name="{{ $improve_con_tem->id  }}" onclick="fpfun(this)">分配</a>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </table>
                                    </div>
                                @endif
                                @if($improve->id == 1)
                                    @continue
                                @endif
                                    <div class="tabCard ">
                                        <table class="am-table am-table-compact am-table-bordered am-table-centered am-margin-top-lg">
                                            <thead>
                                                <tr class="am-active">
                                                    <th class="am-text-middle" style="width: 120px;">项目</th>
                                                    <th class="am-text-middle" style="width: 440px;">服务内容</th>
                                                    <th class="am-text-middle" style="width: 300px;">服务目标</th>
                                                    <th class="am-text-middle" style="min-width: 82px;">执行类型</th>
                                                    <th class="am-text-middle" style="min-width: 120px;">开始时间</th>
                                                    <th class="am-text-middle" style="min-width: 120px;">结束时间</th>
                                                    <th class="am-text-middle" style="min-width: 82px;">负责人</th>
                                                    <th class="am-text-middle" style="min-width: 82px;">备注</th>
                                                    <th class="am-text-middle" style="min-width: 82px;">管理</th>
                                                </tr>
                                            </thead>

                                            @foreach($improve->improve_list_tems as $improve_list)
                                                @foreach($improve_list->improve_con_tems as $improve_con_tem)
                                                    @if($loop->iteration == 1 )
                                                        <tr>
                                                            <td class="am-text-middle am-text-left" rowspan="{{ count($improve_list->improve_con_tems) }}">
                                                                {{ $improve_list->name }}
                                                            </td>
                                                            <td class="am-text-middle am-text-left">{{ $improve_con_tem->content }}</td>
                                                            <td class="am-text-middle am-text-left" rowspan="{{ count($improve_list->improve_con_tems) }}">
                                                                {{ $improve_list->target }}
                                                            </td>
                                                            <td class="am-text-middle am-text-center">{{ $improve_con_tem->type }}</td>
                                                            <td class="am-text-middle am-text-center">{{ $improve_con_tem->start_date }}</td>
                                                            <td class="am-text-middle am-text-center">{{ $improve_con_tem->end_date }}</td>
                                                            <td class="am-text-middle am-text-center">{{ $improve_con_tem->master }}</td>
                                                            <td class="am-text-middle am-text-left">{{ $improve_con_tem->remark }}</td>
                                                            <td class="am-text-middle">
                                                                <a href="javascript:void(0);" class="am-btn am-btn-white am-btn-sm br5px {{ Entrust::can('task.settask')
                                                       || $is_see ? '' : 'am-hide' }}" name="{{ $improve_con_tem->id  }}" onclick="fpfun(this)">分配</a>
                                                            </td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td class="am-text-middle am-text-left">{{ $improve_con_tem->content }}</td>
                                                            <td class="am-text-middle am-text-center">{{ $improve_con_tem->type }}</td>
                                                            <td class="am-text-middle am-text-center">{{ $improve_con_tem->start_date }}</td>
                                                            <td class="am-text-middle am-text-center">{{ $improve_con_tem->end_date }}</td>
                                                            <td class="am-text-middle am-text-center">{{ $improve_con_tem->master }}</td>
                                                            <td class="am-text-middle am-text-left">{{ $improve_con_tem->remark }}</td>
                                                            <td class="am-text-middle">
                                                                <a href="javascript:void(0);" class="am-btn am-btn-white am-btn-sm br5px {{ Entrust::can('task.settask')
                                                                    || $is_see ? '' : 'am-hide' }}" name="{{ $improve_con_tem->id  }}" onclick="fpfun(this)">分配</a>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </table>
                                    </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--模态框-----------------start-->
    <!--新建改善实施计划-->
    <div class="am-modal am-modal-no-btn" id="doc-modal-1">
        <div class="am-modal-dialog modalwidth-xs">
            <div class="am-modal-hd">
                <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i><span>分配</span></span>
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <div class="am-modal-bd rights-modal am-margin-top">
                <div class="lindiv"></div>
                <div class="pro-card am-text-left">
                    <form class="am-form am-form-horizontal bgfff" id="editform">
                        <input type="hidden" value="{{ $item->id }}" id="item_id">
                        <div class="am-form-group card-box">
                            <label class="am-u-sm-3 am-form-label"><span class="colorred">* </span>请选择负责人</label>
                            <div class="am-u-sm-7">
                                <div class="am-input-group br5px widthMax">
                                    <select name="admin_user_id" datatype="selectnull" nullmsg="请选择负责人" class="br5px">
                                        <option>请选择</option>
                                        @foreach($teamers as $teamer)
                                            <option value="{{ $teamer->id }}">{{ $teamer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="am-form-group card-box">
                            <label class="am-u-sm-3 am-form-label"><span class="colorred">* </span>执行类型</label>
                            <div class="am-u-sm-7">
                                <div class="am-input-group br5px widthMax">
                                    <select name="type" datatype="selectnull" nullmsg="请选择执行类型" class="br5px">
                                        <option>请选择</option>
                                        <option value="0">下厂服务</option>
                                        <option value="1">电话服务</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="am-form-group card-box">
                            <label class="am-u-sm-3 am-form-label"><span class="colorred">* </span>任务优先度</label>
                            <div class="am-u-sm-7">
                                <div class="am-input-group br5px widthMax">
                                    <select name="level" datatype="selectnull" nullmsg="请选择任务优先度" class="br5px">
                                        {{--<option value="0">无</option>--}}
                                        <option value="1">低</option>
                                        <option value="2">中</option>
                                        <option value="3">高</option>
                                        <option value="4">加急</option>
                                        <option value="5">特急</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="am-form-group card-box">
                            <label class="am-u-sm-3 am-form-label"><span class="colorred"> </span>备注</label>
                            <div class="am-u-sm-7">
                                <input type="text" name="remark" class="br5px">
                            </div>
                        </div>

                        <div class="am-form-group card-box">
                            <label class="am-u-sm-3 am-form-label"><span class="colorred">* </span>实施时间</label>
                            <div class="am-u-sm-3 am-text-left">
                                <input id="start_date" name="start_date" type="text" class="am-form-field" datatype="*"
                                       nullmsg="请选择开始时间" placeholder="请选择开始时间" data-am-datepicker readonly required/>
                            </div>
                            <div class="am-u-sm-1 am-text-left">
                                <div class="dao">到</div>
                            </div>
                            <div class="am-u-sm-3 am-text-left">
                                <input id="end_date" name="end_date" type="text" class="am-form-field" datatype="*"
                                       nullmsg="请选择结束时间" placeholder="请选择结束时间" data-am-datepicker readonly required/>
                            </div>
                        </div>
                        <p class="am-text-center am-margin-top-lg">
                            @if(Entrust::can('task.settask'))
                                <button type="submit" id="fenpei" name="" class="am-btn am-btn-primary br5px">分配</button>
                            @endif
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--模态框------------------end-->
@endsection

@section('javascript')
    @parent
    <script src=" {{ url('js/main.js') }}" type="text/javascript" charset="utf-8"></script>
    <script>
        var item_id = $('#item_id').val();
        //选项卡
        $(document).ready(function () {
            $("#navlist li").each(function (index) {
                $(this).click(function () {
                    $("#navlist li.am-active").removeClass("am-active");
                    $(".tabCard").removeClass("active");
                    $("#containerlist .tabCard").eq(index).addClass("active");
                    $(this).addClass("am-active");
                })
            })
        });

        //分配

        function fpfun(e) {
            var url = '/admin/item/'+item_id +'/task/checktask/' + $(e).attr("name");
            AjaxJson(url,{type:'improve'},function (data) {
                if(data.status == 1){
                    layer.msg('该任务已经分配过了，确定重新分配吗？', {
                        time: 0 //不自动关闭
                        ,btn: ['确定', '取消']
                        ,yes: function(index){
                            layer.close(index);
                            $("#doc-modal-1").modal();
                            $("#fenpei").attr("name", $(e).attr("name"));
                        }
                    });
                }else {
                    $("#doc-modal-1").modal();
                    $("#fenpei").attr("name", $(e).attr("name"));
                }
            });
        }
        $("#editform").Validform({
            //btnSubmit:"#editformsub",
            tiptype: function (msgs, o, cssctl) {
                if (o.type != 2) { //只有不正确的时候才出发提示，输入正确不提示
                    layer.msg(msgs);
                }
            },
            ajaxPost: true, //true用ajax提交，false用form方式提交
            tipSweep: true, //true只在提交表单的时候开始验证，false每输入完一个输入框之后就开始验证
            beforeSubmit: function (curform) {
                var oDate1 = new Date($("#start_date").val());
                var oDate2 = new Date($("#end_date").val());
                var changl = {
                    'tasktable_type': "App\\Models\\ImproveConTem"
                };
                var postDta = JsonInsert(GetWebControls("#editform"), changl);
                if (oDate1.getTime() > oDate2.getTime()) {
                    layer.msg('结束时间必须大于开始时间');
                    return false;
                } else {
                    AjaxJson('/admin/item/'+item_id +'/task/setTask/' + $("#fenpei").attr("name"), {'taskContent': postDta}, function (data) {
                        if (data.status == 1) {
                            if (data.msg != null && data.msg != undefined) {
                                layer.msg(data.msg)
                            }
                            window.location.reload();
                        } else {
                            if (data.msg != null && data.msg != undefined) {
                                layer.msg(data.msg)
                            }
                        }
                    });
                }
                return false;
            }
        });
    </script>
@endsection
        