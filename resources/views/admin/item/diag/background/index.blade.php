@extends('layouts.admin-app')
@section('title', '企业背景')
@section('css')
    @parent
    <link rel="stylesheet" href=" {{ url('/css/main.css') }}">
    <style type="text/css">
        .title *{margin-right:10px}
        .displayflex{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex}
        .am-list li{padding-top:20px}
        .am-nav-tabs>li{margin-bottom:0;-webkit-box-flex:1;-webkit-flex:1;-ms-flex:1;flex:1;text-align:center}
        .am-list li:first-child{border:none}
        .am-selected.am-active,.am-selected.am-active:active,.am-selected.am-active:focus,.am-selected.am-active:hover{border-color:#e6e6e6!important;border:1px solid!important;border-radius:5px}
        .am-btn-default.am-active,.am-btn-default:active,.am-btn-default:focus,.am-btn-default:hover,.am-dropdown.am-active .am-btn-default.am-dropdown-toggle{color:#444;border:1px solid!important;border-color:#e6e6e6!important}
        .tabs-child .am-nav-tabs>li.am-active>a{background:0 0;border:none}
        .tabs-child .am-nav-tabs{border:none}
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
                    {{--在线预览通用--}}
                    @include('admin._partials.diag-preview')
                    <div class="pro-card marginT30px" style="padding: 1rem">
                        <div class="paddlr20px">
                            <!--头部导航-->
                            @include('admin._partials.diag-menu')
                            <div>
                                <div class="marginT30px">
                                    <p class="title am-fl">企业基本情况</p>
                                    <div class="am-fr color888">
                                        @if(isset($user->task))
                                            <span>模块负责人：</span><span
                                                    class="am-margin-right">{{ isset($user->adminUser) ?$user->adminUser->name :'暂无' }}</span>
                                            {{--1.进行中,2.已延期,3.未开始,4.已完成--}}
                                            @if($user->task->status == 4)
                                                <span class="ztspan mystate4">已完成</span>
                                            @elseif($user->task->status == 1)
                                                <span class="ztspan mystate1">进行中</span>
                                            @elseif($user->task->status == 2 )
                                                <span class="ztspan mystate2">已延期</span>
                                            @elseif($user->task->status == 5)
                                                <span class="ztspan mystate5">待查看</span>
                                            @endif
                                            <span class="am-margin-left">最新更新：</span>
                                            <time>{{$user->task->updated_at }}</time>
                                        @else
                                            <span>模块负责人：</span><span class="am-margin-right">暂无</span>
                                            <span class="ztspan mystate3">未开始</span>
                                            <span class="am-margin-left">最新更新：暂无</span>
                                            <time></time>
                                        @endif

                                        @if(Auth::guard('admin')->user()->id == $item->fid
                                            || Auth::guard('admin')->user()->id == $item->create_id
                                            || Auth::guard('admin')->user()->id == 23)

                                            @if(Entrust::can('task.settask'))
                                                <a href="javascript:void(0);" name="{{ $user->id }}" class="am-btn am-btn-white br5px" onclick="fpfun(this)">分配</a>
                                            @endif
                                        @endif

                                        @if(($user->task && Auth::guard('admin')->user()->id == $user->task->admin_user_id) || Auth::guard('admin')->user()->id == 23)
                                            @if(Entrust::can('user.background.edit'))
                                                <a href="{{ route('user.background.edit',[$item->id,$user->id]) }}" class="am-btn am-btn-primary br5px">编辑</a>
                                            @endif
                                        @endif
                                    </div>
                                    <div style="clear: both;"></div>
                                </div>
                                <div class="am-g marginT15px">
                                    <div class="am-u-sm-2 am-text-right color888">
                                        注册名称：
                                    </div>
                                    <div class="am-u-sm-10">
                                        {{ $user->name }}
                                    </div>
                                </div>
                                <div class="am-g marginT15px">
                                    <div class="am-u-sm-2 am-text-right color888">
                                        注册地址：
                                    </div>
                                    <div class="am-u-sm-10">
                                        {{ $user->address }}
                                    </div>
                                </div>
                                <div class="am-g marginT15px">
                                    <div class="am-u-sm-2 am-text-right color888">
                                        成立日期/营业期限：
                                    </div>
                                    <div class="am-u-sm-10">
                                        {{ $user->end_date  }}
                                    </div>
                                </div>

                                <div class="am-g marginT15px">
                                    <div class="am-u-sm-2 am-text-right color888">
                                        注册资本：
                                    </div>
                                    <div class="am-u-sm-10">
                                        {{ $user->capital }}
                                    </div>
                                </div>
                                <div class="am-g marginT15px">
                                    <div class="am-u-sm-2 am-text-right color888">
                                        海关注册登记编码：
                                    </div>
                                    <div class="am-u-sm-10">
                                        {{ $user->code }}
                                    </div>
                                </div>
                                <div class="am-g marginT15px">
                                    <div class="am-u-sm-2 am-text-right color888">
                                        管理类型：
                                    </div>
                                    <div class="am-u-sm-10">
                                        @if($user->aeo==0)
                                            一般认证企业
                                        @elseif($user->aeo==1)
                                            高级认证企业
                                        @endif
                                    </div>
                                </div>
                                <div class="am-g marginT15px">
                                    <div class="am-u-sm-2 am-text-right color888">
                                        贸易方式：
                                    </div>
                                    <div class="am-u-sm-10">
                                        @if($user->trade==0)
                                            加工贸易
                                        @elseif($user->trade==1)
                                            一般贸易
                                        @elseif($user->trade==2)
                                            以上都有
                                        @endif
                                    </div>
                                </div>
                                <div class="am-g marginT15px">
                                    <div class="am-u-sm-2 am-text-right color888">
                                        加工贸易手册监管方式：
                                    </div>
                                    <div class="am-u-sm-10">
                                        @if($user->trade_manual==0)
                                            电子化手册
                                        @elseif($user->trade_manual==1)
                                            电子账册
                                        @endif
                                    </div>
                                </div>
                                <div class="am-g marginT15px">
                                    <div class="am-u-sm-2 am-text-right color888">
                                        生产项目类别：
                                    </div>
                                    <div class="am-u-sm-10">
                                        {{ $user->pro_item_type }}
                                    </div>
                                </div>
                                <div class="am-g marginT15px">
                                    <div class="am-u-sm-2 am-text-right color888">
                                        主要进出口贸易方式：
                                    </div>
                                    <div class="am-u-sm-10">
                                        {{ $user->main_trade }}
                                    </div>
                                </div>
                            </div>
                            <div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" value="{{ $item->id }}" id="item_id">
    </div>
    <!--模态框-----------------start-->
    <!--分配模态框-->
    <div class="am-modal am-modal-no-btn" id="doc-modal-1">
        <div class="am-modal-dialog modalwidth-sm">
            <div class="am-modal-hd">
                <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i><span>分配任务</span></span>
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <div class="am-modal-bd rights-modal am-margin-top">
                <div class="lindiv"></div>
                <form class="am-form am-form-horizontal" id="editform" style="padding:20px 40px;">
                    <div class="am-form-group card-box">
                        <label class="am-u-sm-3 am-form-label"><span
                                    class="colorred">* </span><span>选择负责人：</span></label>
                        <div class="am-u-sm-7">
                            <div class="am-input-group bgfff br5px" style="width: 100%;">
                                <select name="admin_user_id" class="br5px" datatype="selectnull" nullmsg="请选择负责人">
                                    <option>请选择</option>
                                    @foreach($teamers as $teamer)
                                        <option value="{{ $teamer->id }}">{{ $teamer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="am-form-group card-box">
                        <label class="am-u-sm-3 am-form-label"><span
                                    class="colorred">* </span><span>任务优先度：</span></label>
                        <div class="am-u-sm-7">
                            <div class="am-input-group bgfff br5px" style="width: 100%;">
                                <select name="level" class="br5px" datatype="selectnull" nullmsg="请选择优先级">
                                    <option>请选择</option>
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
                        <label class="am-u-sm-3 am-form-label"><span class="colorred">* </span>实施时间：</label>
                        <div class="am-u-sm-3 am-text-left">
                            <input id="start_date" name="start_date" type="text" class="am-form-field" datatype="*" nullmsg="请选择开始时间" placeholder="请选择开始时间" data-am-datepicker readonly required/>
                        </div>
                        <div class="am-u-sm-1 am-text-left">
                            <div class="dao">到</div>
                        </div>
                        <div class="am-u-sm-3 am-text-left">
                            <input id="end_date" name="end_date" type="text" class="am-form-field" datatype="*" nullmsg="请选择结束时间" placeholder="请选择结束时间" data-am-datepicker readonly required/>
                        </div>
                    </div>
                    <div class="am-form-group am-margin-top-lg">
                            @if(Entrust::can('task.settask'))
                                <button type="submit" id="fenpei" name="" class="am-btn am-btn-primary br5px">分配</button>
                            @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    @parent
    <script src=" {{ url('js/validform/js/Validform_Datatype.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src=" {{ url('js/main.js') }}" type="text/javascript" charset="utf-8"></script>
    <script>
        var item_id = $('#item_id').val();
        function fpfun(e) {
            var url = '/admin/item/'+item_id+'/task/checktask/' + $(e).attr("name");
            AjaxJson(url,{type:'background'},function (data) {
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
        var editygformobj = $("#editform").Validform({
//            btnSubmit:"#editformsub",
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
                    'tasktable_type': "App\\User"
                }
                var postDta = JsonInsert(GetWebControls("#editform"), changl);
                if (oDate1.getTime() > oDate2.getTime()) {
                    layer.msg('结束时间必须大于开始时间');
                    return false;
                } else {
                    AjaxJson('/admin/item/'+item_id+'/task/setTask/' + $("#fenpei").attr("name"), {'taskContent': postDta}, function (data) {
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
            },
            //ajax提交完之后的回调函数
            callback: function (rq) {
            }
        });
    </script>
@endsection