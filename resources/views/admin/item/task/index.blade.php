@extends('layouts.admin-app')
@section('title', '我的任务')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ url('/css/main.css') }}">
    <style type="text/css">
        .am-selected.am-active, .am-selected.am-active:active, .am-selected.am-active:focus, .am-selected.am-active:hover {
            border-color: #e6e6e6 !important;
            border: 1px solid !important;
            border-radius: 5px
        }

        .am-btn-default.am-active, .am-btn-default:active, .am-btn-default:focus, .am-btn-default:hover, .am-dropdown.am-active .am-btn-default.am-dropdown-toggle {
            color: #444;
            border: 1px solid !important;
            border-color: #e6e6e6 !important
        }

        p.title button {
            margin-right: 20px
        }

        .am-dropdown-content, ul.contents > li > a {
            padding: 0;
            min-width: 100px
        }
    </style>
@endsection

@section('content')
    <div class="dh-main">
        <div class="am-g">
            <div class="am-u-sm-3 am-u-md-3 am-u-lg-2 bgfff" id="leftNav">
                <!--右侧菜单-->
                @include('admin._partials.item-left-menu')
            </div>
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10" id="rightMain">
                <!--项目概况-->
                <div class="dh-main-container">
                    <p class="title fs18">我的任务
                    </p>
                    <div class="search">
                        <form action="{{ route('task.search',[$item->id]) }}" class="am-form-inline">
                            <div class="am-form-group">
                                <div class="am-input-group bgfff br5px">
                                    <select data-am-selected name="status">
                                        <option value="0">状态：全部</option>
                                        <option {{ isset($status) && $status ==1 ? 'selected' : '' }} value="1">进行中</option>
                                        <option {{ isset($status) && $status ==2 ? 'selected' : '' }} value="2">已延期</option>
                                        <option {{ isset($status) && $status ==4 ? 'selected' : '' }} value="4">已完成</option>
                                        <option {{ isset($status) && $status ==5 ? 'selected' : '' }} value="5">待查看</option>
                                        <option {{ isset($status) && $status ==6 ? 'selected' : '' }} value="6">待验收</option>
                                    </select>
                                </div>
                                <div class="am-input-group bgfff br5px">
                                    <select data-am-selected name="level">
                                        <option  value="0">优先度：全部</option>
                                        <option {{ isset($level) && $level ==1 ? 'selected' : '' }} value="1">低</option>
                                        <option {{ isset($level) && $level ==2 ? 'selected' : '' }} value="2">中</option>
                                        <option {{ isset($level) && $level ==3 ? 'selected' : '' }} value="3">高</option>
                                        <option {{ isset($level) && $level ==4 ? 'selected' : '' }} value="4">加急</option>
                                        <option {{ isset($level) && $level ==5 ? 'selected' : '' }} value="5">特急</option>
                                    </select>
                                </div>
                            </div>
                            <div class="am-input-group">
                                <button class="am-btn am-btn-primary br5px" typeof="submit">筛选</button>
                            </div>
                        </form>
                    </div>

                    <table class="am-table bgfff marginT30px am-table-centered am-table-hovernew">
                        <thead>
                        <tr>
                            <th class="am-text-middle" style="min-width: 70px">编号</th>
                            <th class="am-text-middle">标题</th>
                            <th class="am-text-middle"  style="min-width: 80px">状态</th>
                            <th class="am-text-middle"  style="min-width: 80px">优先度</th>
                            <th class="am-text-middle" style="min-width: 100px">计划时间</th>
                            <th class="am-text-middle" style="min-width: 100px">截止时间</th>
                            <th class="am-text-middle" style="min-width: 100px">服务评价</th>
                            <th class="am-text-middle" style="min-width: 100px">指派人</th>
                            <th class="am-text-middle" style="min-width: 220px">操作</th>
                        </tr>
                        </thead>
                        <tbody class="tbpadd2rem">
                        @foreach($tasks as $task)
                            <tr>
                                <td class="am-text-middle">{{ $task->task_no }}</td>
                                <td class="am-text-middle am-text-left">{{ $task->title }}</td>
                                {{--1.进行中,2.已延期,3.未开始,4.已完成--}}
                                <td class="am-text-middle">
                                    @if($task->status == 1)
                                        <span class="ztspan mystate1">进行中</span>
                                    @elseif($task->status == 2)
                                      <span class="ztspan mystate2">已延期</span>
                                    @elseif($task->status == 3)
                                       <span class="ztspan mystate3">未开始</span>
                                    @elseif($task->status == 4)
                                       <span class="ztspan mystate4">已完成</span>
                                    @elseif($task->status == 5)
                                        <span class="ztspan mystate5">待查看</span>
                                    @elseif($task->status == 6)
                                        <span class="ztspan mystate6">待验收</span>
                                    @endif
                                </td>
                                {{--低,中,高,加急 特急--}}
                                <td class="am-text-middle">
                                    {{--低,中,高,加急 特急--}}
                                    @if($task->level == 1)
                                        <span class="ztspan you1">低</span>
                                    @elseif($task->level == 2)
                                        <span class="ztspan you2">中</span>
                                    @elseif($task->level == 3)
                                        <span class="ztspan you3">高</span>
                                    @elseif($task->level == 4)
                                        <span class="ztspan you4">加急</span>
                                    @elseif($task->level == 5)
                                        <span class="ztspan you5">特急</span>
                                    @endif
                                </td>

                                <td class="am-text-middle">
                                    <time>{{ $task->start_date->toDateString() }}</time>
                                </td>
                                <td class="am-text-middle">
                                    <time>{{ $task->end_date->toDateString() }}</time>
                                </td>
                                <td class="am-text-middle"><span>{{ $task->suggest }}</span></td>
                                <td class="am-text-middle">{{ $task->fpuser }}</td>
                                <td class="am-text-middle">
                                    <div class="am-btn-group">
                                        @if(Entrust::can('task.show'))
                                            <button type="button" name="{{$task->id}}" class="am-btn am-btn-secondary am-radius" onclick="seeMain(this)">
                                                详情
                                            </button>
                                        @endif
                                        @if($task->tasktable_type === 'App\Models\ImproveConTem')
                                            @if($task->suggests()->get()->isEmpty())
                                                <a href="{{ route('suggest.index',[$item->id,$task->id]) }}" class="am-btn am-btn-success am-radius">填表</a>
                                            @else
                                                <a href="{{ route('suggest.show',[$item->id,$task->id]) }}"  class="am-btn am-btn-warning am-radius">查看</a>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $tasks->render() }}
                </div>
            </div>
        </div>
    </div>

    <!--模态框-----------------------------strat-->

    <!--任务详情模态框-----------------------------start-->
    <div class="am-modal am-modal-no-btn" id="chakan-modal-1">
        <div class="am-modal-dialog modalwidth-md">
            <div class="am-modal-hd">
                <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i>任务详情</span>
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <div class="am-modal-bd rights-modal am-margin-top card-box">
                <div class="lindiv"></div>
                <div class="am-g">
                    <p>
                    <div class="am-u-sm-10 am-u-lg-offset-1 am-text-left fs18">
                        <span class="am-margin-right colorred fs20" style="font-weight: 600;">#<span id="id"></span></span><span id="title"></span>
                    </div>
                    </p>
                </div>


                <div class="am-g">
                    <p>
                    <div class="am-u-sm-2 color888">
                        状态:
                    </div>
                    <div class="am-u-sm-10 am-text-left">
                        <div class="am-g">
                            <div class="am-u-sm-5" id="status">

                            </div>
                            <div class="am-u-sm-2 color888">
                                优先度:
                            </div>
                            <div class="am-u-sm-5" id="level">

                            </div>
                        </div>
                    </div>
                    </p>
                </div>

                <div class="am-g">
                    <p>
                    <div class="am-u-sm-2 color888">
                        指派人:
                    </div>
                    <div class="am-u-sm-10 am-text-left">
                        <div class="am-g">
                            <div class="am-u-sm-5" id="fpuser">

                            </div>
                            <div class="am-u-sm-2 color888">
                                处理人:
                            </div>
                            <div class="am-u-sm-5" id="user">

                            </div>
                        </div>
                    </div>
                    </p>
                </div>

                <div class="am-g">
                    <p>
                    <div class="am-u-sm-2 color888">
                        计划时间:
                    </div>
                    <div class="am-u-sm-10 am-text-left">
                        <div class="am-g">
                            <div class="am-u-sm-5" id="start_date">

                            </div>
                            <div class="am-u-sm-2 color888">
                                截止时间:
                            </div>
                            <div class="am-u-sm-5" id="end_date">

                            </div>
                        </div>
                    </div>
                    </p>
                </div>
                <div class="am-g">
                    <p>
                    <div class="am-u-sm-2 color888">
                        延迟天数:
                    </div>
                    <div class="am-u-sm-10 am-text-left">
                        <div class="am-g">
                            <div class="am-u-sm-5" id="daly_date">

                            </div>
                            <div class="am-u-sm-2 color888">
                                服务评价:
                            </div>
                            <div class="am-u-sm-5" id="suggest">

                            </div>
                        </div>
                    </div>
                    </p>
                </div>
                <div class="am-g am-margin-top-lg am-margin-bottom-lg" id="edit_a_box">
                    <a href="javascript:void(0);"  id="mainbtn" class="am-btn am-btn-secondary br5px amend-btn" style="display: none;">去完成</a>
                    <a href="javascript:void(0);"  id="surebtn" class="am-btn am-btn-secondary br5px amend-btn" style="display: none;">确认完成</a>
                    <a id="edittable" href="javascript:void(0);" class="am-btn am-btn-success am-radius" style="display: none;">填表</a>
                    <a id="showtable" href="javascript:void(0);"  class="am-btn am-btn-warning am-radius" style="display: none;">查看</a>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="item_id" value="{{$item->id}}">
    <!--查看客户详情模态框-----------------------------end-->
    <!--延期---------------------------end-->
@endsection
@section('javascript')
    @parent
    <script src="{{ url('js/main.js') }}" type="text/javascript" charset="utf-8"></script>
    <script>
        //查看详情
        var tasktable_id = "";
        var tasktable_type = "";
        var task_id = "";
        var item_id = $("#item_id").val();
        function seeMain(e) {
            var idstr = $(e).attr("name");
            var urlstr = '/admin/item/task/show/' + idstr;
            AjaxJson(urlstr, {}, function (data) {
                console.log(data);
                task_id = data.task_id;
                tasktable_id = data.tasktable_id;
                tasktable_type = data.tasktable_type;
                if(tasktable_type == 'App\\Models\\ImproveConTem'){
                    $("#edit_a_box").find("a").hide();
//                    如果等于1显示什么显示填表按钮，如果不等于显示详情按钮
                    if(data.suggest_no == 1){
                        $("#edit_a_box").find("a").hide();
                        $("#edittable").show();
                    }else {
                        $("#edit_a_box").find("a").hide();
                        $("#showtable").show();
                    }

                }else {
                    if(data.no == 1 || data.no == 2){
                        $("#edit_a_box").find("a").hide();
                        $("#mainbtn").show();
                        $("#surebtn").show();
                    }
                    if(data.no == 4){
                        $("#edit_a_box").find("a").hide();
                    }
                    if(data.no == 5){
                        $("#edit_a_box").find("a").hide();
                        $("#mainbtn").show();
                    }
                }
                SetWebControlshtml(data);
            });
            $("#chakan-modal-1").modal()
        }

        //点击去完成的动作
        $("#mainbtn").click(function () {
            var url = '/admin/item/task/complete';
            AjaxJson(url, {
                'tasktable_id': tasktable_id,
                'tasktable_type': tasktable_type,
                'task_id': task_id
            }, function (data) {
                window.location.href = data.url;
            });
        });

        //点击确定完成的动作
        $("#surebtn").click(function () {
            AjaxJson('/admin/item/task/solution', {
                'task_id': task_id
            }, function (data) {
                if(data.status == 1){
                    layer.msg(data.msg);
                    window.location.reload();
                }else{
                    layer.msg(data.msg);
                }
            });
        });
        //点击去填表的动作
        $("#edittable").click(function () {
            var url = '/admin/item/'+item_id+'/suggest/'+task_id;
            AjaxJson(url,{}, function (data) {
                window.location.href = data.url;
            });
        });
        //点击查看详情的动作
        $("#showtable").click(function () {
            var url = '/admin/item/'+item_id+'/suggest/show/'+task_id;
            AjaxJson(url, {}, function (data) {
                window.location.href = data.url;
            });
        });
        //延期
        function yanqifun(e) {
            $("#yanqibtn").attr('name', $(e).attr("name"));
            $("#doc-modal-3").modal()
        }
        $("#editTime").Validform({
            tiptype: function (msgs, o, cssctl) {
                if (o.type != 2) {     //只有不正确的时候才出发提示，输入正确不提示
                    layer.msg(msgs);
                }
            },
            ajaxPost: true,//true用ajax提交，false用form方式提交
            tipSweep: true,//true只在提交表单的时候开始验证，false每输入完一个输入框之后就开始验证
            beforeSubmit: function (curform) {
                //延期提交
                var postData = {
//                    id: $("#yanqibtn").attr('name'),
                    time: $("#yqtime").val()
                };
                var task_id = $("#yanqibtn").attr('name');
                var url = '/admin/item/task/' + task_id + '/delay';
                AjaxJson(url, {content: postData}, function (data) {
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
                })
            }
        });
    </script>
@endsection