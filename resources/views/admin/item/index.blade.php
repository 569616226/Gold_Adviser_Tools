@extends('layouts.admin-app')
@section('title', '项目管理')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ url('css/main.css') }}">
    <style type="text/css">
        #taba{position:relative}
        .ceng{position:absolute;width:100%;height:70px;z-index:100;top:0}
        .searchable-select-items{max-height: 190px;}
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
                    <p class="title fs18">项目管理
                        @if(Entrust::can('item.create'))
                            <button class="am-fr am-btn am-btn-secondary br5px"
                                    data-am-modal="{target: '#doc-modal-1', closeViaDimmer: 0}">新建项目
                            </button>
                        @endif
                    </p>
                    @if(isset($items))
                        @if(count($items) !== 0)
                            <div class="search">
                                <form id="search-form" action="{{ route('item.search') }}" method="POST" class="am-form-inline am-form am-form-horizontal">
                                    <div class="am-form-group">
                                        @if(Entrust::can('item.search'))
                                            <div class="am-input-group">
                                                <input style="width: 200px" type="text" name="searchStr" value="" placeholder="可输入项目名称"/>
                                                {{ csrf_field() }}
                                            </div>
                                            <div class="am-input-group">
                                                <a href="javascript:void(0);" class="bgql colorw am-btn am-btn-secondary" onclick="event.preventDefault();document.getElementById('search-form').submit();"><i class="am-icon-search"></i> 搜索</a>
                                            </div>
                                        @endif
                                    </div>
                                </form>
                            </div>
                            <div class="card-box am-g">
                                @foreach($items as $item)
                                    <div class="am-u-lg-3 am-u-md-4">
                                        <div class="card">
                                            <a href="javascript:void(0);" name="{{ $item->id }}" onclick="carddf(this)" class="defbtn"
                                               data-am-modal="{target: '#df-modal', closeViaDimmer: 0}"><i class="iconfont">&#xe606;</i></a>
                                            {{--<input type="hidden" value="{{ $item->id }}" id="item_id"/>--}}
                                            <p class="title fs16 textfir">{{ $item->hands->name }}</p>
                                            <p class="color888"><span class="am-badge am-badge-danger am-round">{{ $item->task_count }}</span>我的待办
                                            </p>
                                            <img   src="{{ $item->images ?$item->images->url :url('/images/dhproject.png') }}"/>
                                            <div class="gzbox">
                                                @if(Entrust::can('item.pro'))
                                                    <a href="{{ route('item.pro',[$item->id]) }}" class="color888"><p><span
                                                                    class="iconfont">&#xe661;</span></p>
                                                        <p>工作台</p>
                                                    </a>
                                                @endif
                                                @if(Entrust::can('item.edit'))
                                                    <a href="{{ route('item.edit',[$item->id]) }}" class="color888"><p><span
                                                                    class="iconfont">&#xe678;</span></p>
                                                        <p>配置</p>
                                                    </a>
                                                @endif
                                                @if(Entrust::can('handover.show'))
                                                    <a href="{{ route('handover.show',[$item->hands->users->id])  }}"
                                                       class="color888"><p><span class="iconfont">&#xe65c;</span></p>
                                                        <p>交接单</p>
                                                    </a>
                                                @endif
                                            </div>
                                            <div class="color888 fs14 timep"><span>{{ $item->creator->name }}</span> 于
                                                <time>{{ $item->created_at->toDateString() }}</time>
                                                创建
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="am-text-center">
                                <img class="am-margin-top" src="{{ url('/images/noproject2.png') }}" alt="">
                                <div class="fs24">一大波项目正在朝你奔来...</div>
                            </div>
                        @endif
                    @else
                        <div class="search">
                            <form id="search-form" action="{{ route('item.search') }}" method="POST" class="am-form-inline">
                                <div class="am-form-group">
                                    @if(Entrust::can('item.search'))
                                        <div class="am-input-group">
                                            <input class="am-form-field paddlr20px" type="text" name="searchStr" id=""
                                                   value=""
                                                   placeholder="可输入项目名称"/>
                                            {{ csrf_field() }}

                                            <div class="am-input-group-label bgql am-btn am-btn-secondary" onclick="event.preventDefault();
                                                        document.getElementById('search-form').submit();">
                                                <a href="" class="colorw"><i class="am-icon-search"></i> 搜索</a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                        <div class="am-text-center">
                            <img class="am-margin-top" src="{{ url('/images/noproject2.png') }}" alt="">
                            <div class="fs24">没有发现任何项目...</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <!--模态框-----------------------------strat-->

    <!--新建项目模态框---------------------------strat-->
    <div class="am-modal am-modal-no-btn" id="doc-modal-1">
        <div class="am-modal-dialog modalwidth-sm">
            <div class="am-modal-hd">
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <div class="am-modal-bd porject-modal">
                <img src="{{ url('images/dhproject.png') }}" />
                <div class="am-tabs" data-am-tabs>
                    <ul class="am-tabs-nav am-nav am-nav-tabs" id="taba">
                        <li class="am-active"><a href="#tab1">项目信息</a></li>
                        <li><a href="#tab2" id="tab2a">成员管理</a></li>
                        <div class="ceng"></div>
                    </ul>
                    <div class="am-tabs-bd">
                        <div class="am-tab-panel am-fade am-in am-active" id="tab1">
                            <form class="am-form am-form-horizontal">
                                {{ csrf_field() }}
                                <fieldset>
                                    <div class="am-form-group">
                                        <label for="doc-ipt-3" class="am-u-sm-3 am-form-label"><span
                                                    class="colorred">* </span>请选择客户:</label>
                                        <div class="am-u-sm-9">
                                            <select class="br5px" name="handid" id="handid" >
                                                <option value="">请选择</option>
                                                @foreach($users as $user)
                                                    @if(count($user->hands) && !count($user->hands->items))
                                                        <option value="{{ $user->hands->id }}">{{ $user->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <p class="am-text-left am-u-sm-10 am-u-sm-offset-2">
                                        <a href="javascript:void(0);" id="subCreateItem" class="am-btn am-btn-secondary br5px">下一步</a>
                                    </p>
                                </fieldset>
                            </form>
                        </div>
                        <div class="am-tab-panel am-fade" id="tab2" style="min-height: 360px">
                            <div>
                                <p class="addp-title">添加成员</p>
                                <form>
                                    <div class="am-u-sm-10">
                                        <select class="addcy" id="addcy">
                                            @foreach($admin_users as $admin_user)
                                                <option value="{{ $admin_user->id }}">{{ $admin_user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="am-u-sm-2">

                                        {{--@if($item->fid == Auth::guard('admin')->user()->id || $item->create_id == Auth::guard('admin')->user()->id )--}}
                                            <input id="addcybtn" type="button" class="am-btn am-btn-secondary br5px" value="添加"/>
                                        {{--@endif--}}

                                    </div>
                                </form>
                            </div>
                            <div style="clear: both;"></div>
                            <p class="addp-title">成员列表</p>
                            <div class="paddlr20px">
                                <div class="am-fl am-text-left" id="creater">

                                </div>
                                <div class="am-fr paddt10px"><span>项目创建者</span></div>
                                <div style="clear: both;"></div>
                            </div>
                            <ul class="list-box" id="listBox">
                            </ul>
                            <p class="color888 am-text-left fs14 paddlr20px">把鼠标放到列表上显示更多操作</p>
                            <p class="am-text-center"><a href="javascript:void(0);" id="onloct" class="am-btn am-btn-secondary br5px">完成</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--新建项目模态框---------------------------end-->
    <!--删除---------------------------start-->
    <div class="am-modal am-modal-no-btn" id="df-modal">
        <div class="am-modal-dialog modalwidth-xxs">
            <div class="am-modal-hd">
                <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i><span>删除项目</span></span>
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <div class="am-modal-bd rights-modal am-margin-top">
                <div class="lindiv"></div>
                <p class="am-text-center">
                    确定删除该项目吗？
                </p>
                <p>
                    <button id="dfbtnid" name="" class="am-btn am-btn-primary br5px">确定</button>
                    <button class="am-btn br5px" data-am-modal-close>取消</button>
                </p>
            </div>
        </div>
    </div>
    <!--删除---------------------------end-->
@endsection

@section('javascript')
    @parent
    <script src=" {{ url('js/searchableSelect/jquery.searchableSelect.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src=" {{ url('js/main.js') }}" type="text/javascript" charset="utf-8"></script>
    <script>
        $(".addcy").searchableSelect();

        $.ajaxSetup({
            async: false
        });
        var closeTT = false;
        var itemIdM = "";
        $("#subCreateItem").click(function () {
            var handid = $("#handid").val();
            if(handid == "") {
                layer.msg('请选择客户');
            }else {
                openLoad();
                AjaxJson('/admin/item', {'handid': handid}, function (data) {
                    if (data.status == 1) {
                        closeLoad()
                        layer.msg(data.msg);
                        $("#tab2a").click();
                        $("#creater").html(data.creater);
                        itemIdM = data.item_id;
                        closeTT = true;
                    } else {
                        layer.msg(data.msg);
                    }
                });
            }

        });

        //添加成员到项目里
        $("#addcybtn").click(function () {
            var handid = $("#handid").val();
            var url = '/admin/item/addTeamer/' + handid;
            var admin_user_id = $("#addcy").val();
            AjaxJson(url, {'admin_user_id': admin_user_id}, function (data) {
                if (data.status == 1) {
                    //插入html代码到添加成员的列表
                    $(".searchable-select-holder").html("");
                    $("#listBox").html(data.listhtml);
                    //添加成员之后，要刷新被选成员下拉框内的成员列表
                    console.log(data);
                    $("#addcy").html(data.optionhtml);
//				移除原有节点
                    $(".searchable-select").remove()
//				重新实例化
                    $(".addcy").searchableSelect();
                    layer.msg(data.msg);
                }
            });
        });
        //新增模态框完成按钮逻辑（#onloct）
        $("#onloct").click(function () {
            window.location.reload()
        });

        //删除项目
        function carddf(e) {
            $("#dfbtnid").attr("name",$(e).attr("name"));
        }

        $("#dfbtnid").click(function () {
            var item_id = $("#dfbtnid").attr("name");
            var url = '/admin/item/' + item_id;
            openLoad()
            $.ajax({
                url: url,
                type: "DELETE",
                data: '',
                dataType: "json",
                async: true,
                success: function (data) {
                    if (data.status == 1) {
                        closeLoad()
                        layer.msg(data.msg);
                        window.location.reload();
                    }else {
                        layer.msg(data.msg);
                    }
                },
                error: function (data) {
                    console.log(data);
                    console.log('跳入了error');
                }
            });
        });

        //关闭新增项目模态框的时候刷新页面
        $("#doc-modal-1 .am-close").click(function (e) {
            if(closeTT){
                window.location.reload();
                closeTT = false;
            }
        });

        //设置总负责人
        //    onclick="setz(this)"    需要在循环出来的span上加上  name  和onclick属性
        function setz(e) {
            var id = $(e).attr("name");
            var url = '/admin/item/'+ itemIdM +'/add/admin_user/' + id;
            AjaxJson(url, {}, function (data) {
                if (data.status == 1) {
                    //设置完之后刷新成员列表
                    $("#listBox").html(data.listhtml);
                    layer.msg(data.msg);
                }
            });
        }
        //移除成员
        //    onclick="setdf(this)"
        function setdf(e) {
            var id = $(e).attr("name");
            var url = '/admin/item/'+ itemIdM +'/delete/admin_user/' + id;

            AjaxJson(url, {}, function (data) {
                if (data.status == 1) {
                    // 移除后在下拉框里要重新刷新可添加的成员
                    $("#addcy").html(data.optionhtml);
                    //移除后舒心成员的列表
                    $("#listBox").html(data.listhtml);
                    //移除原有节点
                    $(".searchable-select").remove();
                    //重新实例化
                    $(".addcy").searchableSelect();
                    layer.msg(data.msg);
                }
            });
        }
    </script>
@endsection