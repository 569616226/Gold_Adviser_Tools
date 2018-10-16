@extends('layouts.admin-app')
@section('title', '项目概况')

@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href=" {{ url('js/percircle/percircle.css') }}"/>
    <link rel="stylesheet" href="{{url('css/main.css')}}">
@endsection

@section('content')
    <div class="dh-main">
        <div class="am-g">
            <div class="am-u-sm-3 am-u-md-3 am-u-lg-2 bgfff" id="leftNav">
                @include('admin._partials.item-left-menu')
            </div>
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10" id="rightMain">
                <!--项目概况-->
                <div class="dh-main-container">
                    <p class="title fs18">项目概况  ({{ $item->hands->name }})</p>
                    <div class="am-g">
                        <ul class="ful ulbox am-text-center">
                            <li class="am-u-sm-3">
                                <div class="cell lan"><p>任务总数</p>
                                    <p>{{ $item->task_count }}</p></div>
                            </li>
                            <li class="am-u-sm-3">
                                <div class="cell hong"><p>进行中</p>
                                    <p>{{ $item->tasking }}</p></div>
                            </li>
                            <li class="am-u-sm-3">
                                <div class="cell lv"><p>已延期</p>
                                    <p>{{ $item->task_delay }}</p></div>
                            </li>
                            <li class="am-u-sm-3">
                                <div class="cell lv"><p>已完成</p>
                                    <p>{{ $item->task_complate }}</p></div>
                            </li>
                        </ul>

                        <ul class="ful ulbox am-text-center">
                            <li class="am-u-sm-2">
                                <div class="cell lv"><div class="cell-title">客户反馈</div>
                                    <p>{{  $item->suggest_counts }}</p></div>
                            </li>
                            <li class="am-u-sm-2">
                                <div class="cell lan"><div class="cell-title">非常满意</div>
                                    <p>{{  $item->suggest_counts_2 }}</p></div>
                            </li>
                            <li class="am-u-sm-2">
                                <div class="cell huang"><div class="cell-title">满意</div>
                                    <p>{{  $item->suggest_counts_1 }}</p></div>
                            </li>
                            <li class="am-u-sm-2">
                                <div class="cell hong"><div class="cell-title">不满意</div>
                                    <p>{{  $item->suggest_counts_0 }}</p></div>
                            </li>
                            <li class="am-u-sm-2">
                                <div class="cell lan"><div class="cell-title">项目运行</div>
                                    <p>{{ $item->run_days }}</p></div>
                            </li>
                            <li class="am-u-sm-2">
                                <div class="cell lan"><div class="cell-title">项目成员</div>
                                    <p>{{ $item->user_counts }}</p></div>
                            </li>
                        </ul>
                    </div>

                    <div class="am-g" style="margin-top: 20px;">
                        <div class="am-u-sm-6">
                            <p class="title fs18"><i class="iconfont fs22" style="color: #FF5722;">&#xe601;</i>项目进度</p>
                            <div class="circle">
                                <div class="c100 mainsize p100 yellow">
                                    <span>100%</span>
                                    <span>材料清单</span>
                                    <div class="slice">
                                        <div class="bar"></div>
                                        <div class="fill"></div>
                                    </div>
                                </div>
                                <div class="c100 mainsize p{{ $item->diag_per }} green">
                                    <span>{{ $item->diag_per }}%</span>
                                    <span>诊断报告</span>
                                    <div class="slice">
                                        <div class="bar"></div>
                                        <div class="fill"></div>
                                    </div>
                                </div>
                                <div class="c100 mainsize p{{ $item->improve_per }} qblue">
                                    <span>{{ $item->improve_title_per }}%</span>
                                    <span class="text6">改善实施计划</span>
                                    <div class="slice">
                                        <div class="bar"></div>
                                        <div class="fill"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="am-u-sm-6">
                            <p class="title fs18"><i class="iconfont fs22" style="color: #FF9800;">&#xe608;</i>我的待办 <a href="{{ route('task.index',[$item->id]) }}" class="">更多</a></p>
                            @foreach($item->task_unsols as $task_unsol)
                                <div class="column am-margin-top-xs" name="{{$task_unsol->id}}" onclick="seeMain(this)">
                                    <p class="fs18">{{ $task_unsol ->title }}</p>
                                    <p><a href="javascript:void(0);" class="ztspan mystate5 br5px" name="{{$task_unsol->id}}" onclick="seeMain(this)">待查看</a>
                                        <time class="am-fr marginT15px">{{ $task_unsol->created_at->toDateString() }}</time>
                                    </p>
                                </div>
                            @endforeach

                                <a class="am-btn am-btn-white widthMax br5px {{$item->task_unsols->count() == 0 ? 'am-hide' : ''}}" href="{{ route('task.index',[$item->id]) }}">查看更多</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--任务详情模态框-----------------------------start-->
    <div class="am-modal am-modal-no-btn" id="chakan-modal-1">
        <div class="am-modal-dialog chakan-modal-dialog" style="width: 980px">
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
                <div class="am-g am-margin-top-lg am-margin-bottom-lg">
                    <a href="javascript:void(0);"  id="mainbtn" class="am-btn am-btn-secondary br5px amend-btn" style="display: none;">去完成</a>
                    <a href="javascript:void(0);"  id="surebtn" class="am-btn am-btn-secondary br5px amend-btn" style="display: none;">确认完成</a>
                    {{--'/admin/item/'+item_id+'/suggest/'+task_id--}}
                    <a id="edittable" href="javascript:void(0);" class="am-btn am-btn-success am-radius" style="display: none;">填表</a>
                    {{--'/admin/item/'+item_id+'/suggest/show/'+task_id--}}
                    <a id="showtable" href="javascript:void(0);"  class="am-btn am-btn-warning am-radius" style="display: none;">查看</a>
                </div>
            </div>
        </div>
    </div>
    <!--查看客户详情模态框-----------------------------end-->
    <input type="hidden" id="item_id" value="{{$item->id}}">
@endsection

@section('javascript')
    @parent
    <script src="/../js/percircle/percircle.js" type="text/javascript" charset="utf-8"></script>
    <script src="/../js/main.js" type="text/javascript" charset="utf-8"></script>
    <script>
        //查看详情
        var tasktable_id = "";
        var tasktable_type = "";
        var task_id = "";
        function seeMain(e) {
            var idstr = $(e).attr("name");
            var urlstr = '/admin/item/task/show/' + idstr;
            AjaxJson(urlstr, {}, function (data) {
                task_id = data.task_id;
                tasktable_id = data.tasktable_id;
                tasktable_type = data.tasktable_type;
                if(tasktable_type == 'App\\Models\\ImproveConTem'){
                    if(data.suggest_no == 1){
                        $("#edittable").show();
                    }else {
                        $("#showtable").show();
                    }
                }else {
                    if(data.no == 1 || data.no == 2){
                        $("#mainbtn").show();
                        $("#surebtn").show();
                    }
                    if(data.no == 5){
                        $("#mainbtn").show();
                    }
                }
                SetWebControlshtml(data);
            });
            $("#chakan-modal-1").modal()
        }

        //点击去完成的动作
        $("#mainbtn").click(function () {
            AjaxJson('/admin/item/task/complete', {
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
            AjaxJson(url, {}, function (data) {
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

    </script>
@endsection