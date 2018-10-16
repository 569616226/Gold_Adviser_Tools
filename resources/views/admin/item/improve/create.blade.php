@extends('layouts.admin-app')
@section('title', '新建实施计划')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ url('css/main.css') }}">
@endsection
@section('content')
    <div class="dh-main">
        <div class="am-g">
            <div class="am-u-sm-3 am-u-md-3 am-u-lg-2 bgfff" id="leftNav">
                @include('admin._partials.item-left-menu')
            </div>
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10" id="rightMain">
                <div class="dh-main-container">
                    <p class="title fs18">供应链定制化服务实施计划</p>
                    <div class="pro-card marginT30px">
                        <div class="am-g">
                            <div class="am-u-sm-10">
                                <p>
                                    <span class="color888">实施辅导单位：</span>
                                    <span>{{ $item->hands->name }}</span>
                                </p>
                                <p>
                                    <span class="color888">顾问总负责人：</span>
                                    <span>{{ $creater->name }}</span>
                                </p>
                                <p>
                                    <span class="color888">项目执行负责人：</span>
                                    <span>{{ isset($fuser) ? $fuser->name : '无' }}</span>
                                </p>
                                <p>
                                    <span class="color888">实施时间：</span>
                                    <time></time>
                                </p>
                            </div>
                            <div class="am-u-sm-2 am-text-center">

                                <a href="#" class="am-btn am-btn-primary br5px am-btn-sm  {{ $item->diag_active == 0 ? 'am-hide' : ''}}" data-am-modal="{target: '#doc-modal-1'}">新建计划</a>
                                <a href="#" class="am-btn am-btn-primary br5px am-btn-sm {{ $item->diag_active == 0 ? '' : 'am-hide'}}" onclick="layer.msg('诊断报告未交付，不能新建实施计划')">新建计划</a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <!--模态框-----------------start-->
    <!--分配模态框-->
    <div class="am-modal am-modal-no-btn" id="doc-modal-1">
        <div class="am-modal-dialog modalwidth-lg">
            <div class="am-modal-hd">
                <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i><span>新建改善实施计划</span></span>
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <div class="am-modal-bd rights-modal am-margin-top">
                <div class="lindiv"></div>
                <div class="pro-card am-text-left">
                    <div class="am-form-group am-g card-box">
                        <div class="color888 am-u-sm-2 am-u-sm-offset-2">实施辅导单位：</div>
                        <div class="am-u-sm-3">{{ $item->hands->name }}</div>
                    </div>
                    <div class="am-form-group am-g card-box">
                        <div class="color888 am-u-sm-2 am-u-sm-offset-2">顾问总负责人：</div>
                        <div class="am-u-sm-3">{{ $creater->name }}</div>
                    </div>
                    <div class="am-form-group am-g card-box">
                        <div class="color888 am-u-sm-2 am-u-sm-offset-2">项目执行负责人：</div>
                        <div class="am-u-sm-3">{{ isset($fuser) ? $fuser->name : '无' }}</div>
                    </div>

                    <div class="am-form-group card-box">
                        <span class="am-u-sm-2 am-u-sm-offset-2 color888"><span class="colorred">* </span>实施时间：</span>
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
                    <div class="am-text-center am-padding-top-lg">
                        @if(Entrust::can('improve.index'))
                            <a href="javascript: void(0)" class="am-btn am-btn-primary br5px am-margin-top-lg" id="newTask">新建计划</a>
                        @endif
                    </div>
                </div>
                <input type="hidden" value="{{ $item->id }}" id="item_id">
            </div>
        </div>
    </div>
    <!--模态框------------------end-->
@endsection

@section('javascript')
    @parent
    <script src=" {{ url('js/main.js') }}" type="text/javascript" charset="utf-8"></script>
    <script>
        $("#newTask").click(function () {
            var oDate1 = new Date($("#start_date").val());
            var oDate2 = new Date($("#end_date").val());
            var item_id = $('#item_id').val();
            var url = '/admin/item/'+ item_id +'/improve/store';
            var postData = {
                startDate: $("#start_date").val(), //开始时间
                endDate: $("#end_date").val()		//结束时间
            };
            if (oDate1.getTime() > oDate2.getTime()) {
                layer.msg('结束时间必须大于开始时间');
                return false;
            } else {
                AjaxJson(url, postData, function (data) {
                    if (data.status == 1) {
                        layer.msg(data.msg);
                        window.location.href = data.url;
                    } else if (data.status == 0) {
                        layer.msg(data.msg);
                    }
                });
            }
        })
    </script>
@endsection