{{--@include('admin._partials.diags_content')--}}

@extends('layouts.admin-app')
@section('title', '诊断结果具体分析')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ url('css/main.css') }}">
    <link rel="stylesheet" type="text/css" href=" {{ url('js/umeditor/themes/default/css/umeditor.min.css') }} "/>
    <style type="text/css">
        .edui-container{width:100%!important}
        .edui-body-container{min-height:120px!important}
        .edui-toolbar {display: none;}
        .tabs-child .am-nav-tabs,.tabs-child .am-nav-tabs>li.am-active>a,.tabs-child .am-tabs-bd{border:none}
        table>tbody>tr.am-active>th{border-left:1px solid #ddd}
        .am-form-field[readonly]{cursor:pointer!important}
        .nav-child li.am-active a,.nav-child li.am-active a:focus,.nav-child li.am-active a:hover{background:0 0;color:#000}
        .am-form textarea{height:35px}
    </style>
@endsection
@section('content')
    <div class="dh-main">
        <div class="am-g">
            <div class="am-u-sm-3 am-u-md-3 am-u-lg-2 bgfff" id="leftNav">
                {{--左侧菜单--}}
                @include('admin._partials.item-left-menu')
            </div>
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10" id="rightMain">
                <div class="dh-main-container">
                    {{--在线预览通用--}}
                    @include('admin._partials.diag-preview')
                    <div class="pro-card" style="padding: 1rem">
                        <!--头部导航-->
                        @include('admin._partials.diag-menu')
                    </div>
                    @include('admin._partials.diags_menu')
                    <div class="pro-card am-margin-top-sm">
                        <div class="paddlr20px">
                            <div style="overflow: hidden;" class="marginT30px">
                                <i class="iconfont" style="color: #FF9800;">&#xe633;</i> 诊断结果具体分析
                                <div class="paddlr20px" style="width: 100%;">
                                    <div class="bigm-card marginT30px">
                                        <div class="am-margin-top">
                                            <h2 class="am-fl">系统化管理
                                                <a href="{{ route('diags.addmod',[$item->id,$diag_mod->id]) }}" class="am-margin-left am-btn am-btn-white br5px fs14  {{ Entrust::can('diags.addmod') ? '' : 'am-hide' }}" data-am-modal="{target: '#doc-modal-4', closeViaDimmer: 0}">
                                                    <i class="iconfont">&#xe617;</i>
                                                </a>
                                                <a href="#" name="{{ $diag_mod->id }}" class="am-btn am-btn-white br5px {{ Entrust::can('task.set_task_all')  ? '' : 'am-hide' }}" onclick="yifpfun(this)">一键分配</a>
                                            </h2>
                                            <div class="am-fr color888">
                                                <span>系统化管理负责人：</span>
                                                <span>{{ $diag_mod->master ? $diag_mod->master->name : '暂无' }}</span>
                                                <a href="#" name="{{ $diag_mod->id }}" class="am-btn am-btn-white br5px am-margin-left  {{ Entrust::can('task.settasks') && $is_see ? '' : 'am-hide' }}" onclick="zpfun(this)">指派</a>
                                            </div>
                                            <div style="clear: both;"></div>
                                            <!--小模块-->
                                            @foreach($diag_mod->diag_submods as $diag_submod)

                                                <div class="smallm-card {{ ($diag_submod->task && Auth::guard('admin')->user()->id == $diag_submod->task->admin_user_id)
                                                 || Auth::guard('admin')->user()->id == $diag_mod->fid || $is_see ? '' : 'am-hide' }}">

                                                    <div class="am-fl">{{ $diag_submod->name }}</div>
                                                    <div class="am-fr color888">
                                                        @if($diag_submod->task)
                                                            <span>子模块负责人：</span>
                                                            <span class="am-margin-right">{{ $diag_submod->adminUser ? $diag_submod->adminUser->name : '' }}</span>
                                                            {{--1.进行中,2.已延期,3.未开始,4.已完成--}}
                                                            {{--1.进行中,2.已延期,3.未开始,4.已完成--}}
                                                            @if($diag_submod->task->status == 4)
                                                                <span class="ztspan mystate4">已完成</span>
                                                            @elseif($diag_submod->task->status == 1)
                                                                <span class="ztspan mystate1">进行中</span>
                                                            @elseif($diag_submod->task->status == 2 )
                                                                <span class="ztspan mystate2">已延期</span>
                                                            @elseif($diag_submod->task->status == 5)
                                                                <span class="ztspan mystate5">待查看</span>
                                                            @elseif($diag_submod->task->status == 6)
                                                                <span class="ztspan mystate6">待验收</span>
                                                            @endif
                                                            <span class="am-margin-left">最新更新：</span>
                                                            <time>{{$diag_submod->task->updated_at->toDateString() }}</time>
                                                        @else
                                                            <span>模块负责人：</span><span class="am-margin-right">暂无</span>
                                                            <span class="ztspan mystate3">未开始</span>
                                                            <span class="am-margin-left">最新更新：暂无</span>
                                                            <time></time>
                                                        @endif

                                                        <a href="#" name="{{ $diag_submod->id }}" class="am-btn am-btn-primary br5px {{ Entrust::can('task.settask')
                                                        && Auth::guard('admin')->user()->id == $diag_mod->fid || $is_see ? '' : 'am-hide' }}" onclick="zmokuaifun(this)">分配</a>

                                                        <a href="{{ route('diags.edit',[$item->id,$diag_submod->id]) }}" class="am-btn am-btn-primary br5px{{ Entrust::can('diags.edit')
                                                        && ($diag_submod->task && Auth::guard('admin')->user()->id == $diag_submod->task->admin_user_id)
                                                        || Auth::guard('admin')->user()->id == 23 ? '' : 'am-hide' }}">编辑</a>

                                                    </div>
                                                    <div style="clear: both;"></div>
                                                    <!--表格（小项）-->
                                                    <table class="am-table am-table-bordered am-table-centered am-margin-top ">
                                                        <thead>
                                                        <tr class="am-active">
                                                            <th class="am-text-middle">
                                                                审核内容
                                                            </th>
                                                            <th class="am-text-middle" style="min-width: 130px">
                                                                问题及风险描述
                                                            </th>
                                                            <th class="am-text-middle" style="min-width: 100px">
                                                                法律依据
                                                            </th>
                                                            <th class="am-text-middle" style="min-width: 130px">
                                                                建议及改善方案
                                                            </th>
                                                            <th class="am-text-middle" style="min-width: 100px">
                                                                操作
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tfoot>
                                                        <tr class="{{ Entrust::can('diags.addcontent') ? '' : 'am-hide' }}">
                                                        <td colspan="5">
                                                            <a href="#" class="br5px " name="{{ $diag_submod->id }}" onclick="addcontent(this)">
                                                                <i class="iconfont">&#xe61e;</i>新增审核内容
                                                            </a>
                                                        </td>
                                                        </tr>
                                                        </tfoot>
                                                        <tbody>
                                                        <tr>
                                                        @foreach($diag_submod->diag_subcontents as $diag_subcontent)
                                                            <tr>
                                                                <td class="am-text-middle am-text-left" style="max-width: 500px;">{!! html_entity_decode(stripslashes($diag_subcontent->content)) !!}</td>
                                                                <td class="am-text-middle am-text-left">{{ $diag_subcontent->describle }}
                                                                </td>
                                                                <td class="am-text-middle"><div class="stcha" name="{{ $diag_subcontent->id }}" onclick="flyjshowfun(this)">{{ $diag_subcontent->law }}</div></td>
                                                                <td class="am-text-middle am-text-left" style="max-width: 500px;">{{ $diag_subcontent->suggest }}
                                                                </td>
                                                                <td class="am-text-middle">
                                                                    <a class="{{ Entrust::can('diags.editcontent')
                                                                    && Auth::guard('admin')->user()->id == $diag_mod->fid || $is_see ? '' : 'am-hide' }}"
                                                                       href="#" name="{{ $diag_subcontent->id }}" onclick="editcontent(this)"> 编辑</a>

                                                                    <a class="{{ Entrust::can('diags.delcontent')
                                                                    && Auth::guard('admin')->user()->id == $diag_mod->fid || $is_see ? '' : 'am-hide' }}"
                                                                       href="#" name="{{ $diag_subcontent->id }}" onclick="dfcontent(this)" class="colorred"> 删除</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
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
        <div class="am-modal-dialog modalwidth-md">
            <div class="am-modal-hd">
                <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i><span>分配任务</span></span>
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <div class="am-modal-bd rights-modal am-margin-top">
                <div class="lindiv"></div>
                <form class="am-form am-form-horizontal" style="padding:20px 40px;" id="zmokuaiform">
                    <input type="hidden" value="{{ $item->id }}" id="item_id">
                    <div class="am-form-group card-box">
                        <label class="am-u-sm-3 am-form-label"><span
                                    class="colorred">* </span><span>选择负责人：</span></label>
                        <div class="am-u-sm-8">
                            <div class="am-input-group bgfff br5px" style="width: 100%;">
                                <select name="admin_user_id" class="br5px" datatype="selectnull" nullmsg="请选择负责人">
                                    <option>请选择</option>
                                    @foreach($teamerLs as $teamer)
                                        <option value="{{ $teamer->id }}">{{ $teamer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="am-form-group card-box">
                        <label class="am-u-sm-3 am-form-label"><span
                                    class="colorred">* </span><span>任务优先度：</span></label>
                        <div class="am-u-sm-8">
                            <div class="am-input-group bgfff br5px" style="width: 100%;">
                                <select name="level" class="br5px" datatype="selectnull" nullmsg="请选择优先级">
                                    <option>请选择</option>
                                    <option value="0">无</option>
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
                            <input id="start_date" name="start_date" type="text" class="am-form-field" datatype="*"
                                   nullmsg="请选择开始时间" placeholder="请选择开始时间" data-am-datepicker readonly required/>
                        </div>
                        <div class="am-u-sm-2 am-text-left">
                            <div class="dao">到</div>
                        </div>
                        <div class="am-u-sm-3 am-text-left">
                            <input id="end_date" name="end_date" type="text" class="am-form-field" datatype="*"
                                   nullmsg="请选择结束时间" placeholder="请选择结束时间" data-am-datepicker readonly required/>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <div class="am-u-sm-10 am-u-sm-offset-2">
                            <button id="zfpbtn" type="submit" class="am-btn am-btn-primary br5px {{ Entrust::can('task.settask') ? '' : 'hide' }}">分配</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--指派模态框-->
    <div class="am-modal am-modal-no-btn" id="doc-modal-2">
        <div class="am-modal-dialog modalwidth-xss">
            <div class="am-modal-hd">
                <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i><span>指派</span></span>
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <div class="am-modal-bd rights-modal am-margin-top">
                <div class="lindiv"></div>
                <form class="am-form am-form-horizontal" style="padding:20px 40px;" id="zpeditform">
                    <div class="am-form-group">
                        <label class="am-u-sm-4 am-form-label"><span
                                    class="colorred">* </span><span>选择负责人：</span></label>
                        <div class="am-u-sm-8">
                            <div class="am-input-group bgfff br5px" style="width: 80%;">
                                <select name="admin_user_id" class="br5px" datatype="selectnull" nullmsg="请选择负责人">
                                    <option>请选择</option>
                                    @foreach($teamerRs as $teamer)
                                        <option value="{{ $teamer->id }}">{{ $teamer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <div class="am-u-sm-10 am-u-sm-offset-2">
                            <button id="zpbtn" type="submit" class="am-btn am-btn-primary br5px {{ Entrust::can('task.settasks') ? '' : 'am-hide'  }}">指派</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--一键分配模态框-->
    <div class="am-modal am-modal-no-btn" id="doc-modal-3">
        <div class="am-modal-dialog modalwidth-md">
            <div class="am-modal-hd">
                <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i><span>一键分配</span></span>
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <div class="am-modal-bd rights-modal am-margin-top">
                <div class="lindiv"></div>
                <form class="am-form am-form-horizontal" style="padding:20px 40px;" id="yijianfpform">
                    <div class="am-form-group card-box">
                        <label class="am-u-sm-3 am-form-label"><span
                                    class="colorred">* </span><span>选择负责人：</span></label>
                        <div class="am-u-sm-8">
                            <div class="am-input-group bgfff br5px" style="width: 100%;">
                                <select name="admin_user_id" class="br5px" datatype="selectnull" nullmsg="请选择负责人">
                                    <option>请选择</option>
                                    @foreach($teamerLs as $teamer)
                                        <option value="{{ $teamer->id }}">{{ $teamer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="am-form-group card-box">
                        <label class="am-u-sm-3 am-form-label"><span
                                    class="colorred">* </span><span>任务优先度：</span></label>
                        <div class="am-u-sm-8">
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
                            <input id="yj_start_date" name="start_date" type="text" class="am-form-field" datatype="*"
                                   nullmsg="请选择开始时间" placeholder="请选择开始时间" data-am-datepicker readonly required/>
                        </div>
                        <div class="am-u-sm-2 am-text-left">
                            <div class="dao">到</div>
                        </div>
                        <div class="am-u-sm-3 am-text-left">
                            <input id="yj_end_date" name="end_date" type="text" class="am-form-field" datatype="*"
                                   nullmsg="请选择结束时间" placeholder="请选择结束时间" data-am-datepicker readonly required/>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <div class="am-u-sm-12">
                            <button id="yjzfpbtn" type="submit" class="am-btn am-btn-primary br5px {{ Entrust::can('task.set_task_all') ? '' : 'am-hide' }}">一键分配</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--新增审核内容模态框--}}
    <div class="am-modal am-modal-no-btn" id="doc-modal-5">
        <div class="am-modal-dialog modalwidth-md">
            <div class="am-modal-hd">
                <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i><span>新增审核内容</span></span>
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <div class="am-modal-bd rights-modal am-margin-top">
                <div class="lindiv"></div>
                <form class="am-form am-form-horizontal" style="padding:20px 40px;" id="addcontentform">
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label"><span
                                    class="colorred">* </span><span>审核内容：</span></label>
                        <div class="am-u-sm-10">
                            {{--<textarea name="content" class="br5px minheight-xxs"></textarea>--}}
                            {{--<input name="content" class="br5px" type="text"/>--}}
                            <script type="text/plain" id="addcontent" class="am-text-left"></script>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <div class="am-u-sm-10 am-u-sm-offset-2">
                            @if(Entrust::can('diags.addcontent'))
                            <button id="addcontentbtn" type="submit" class="am-btn am-btn-primary br5px">提交</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--编辑审核内容模态框--}}
    <div class="am-modal am-modal-no-btn" id="editcontent-modal">
        <div class="am-modal-dialog modalwidth-md">
            <div class="am-modal-hd">
                <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i><span>编辑审核内容</span></span>
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <div class="am-modal-bd rights-modal am-margin-top">
                <div class="lindiv"></div>
                <form class="am-form am-form-horizontal" style="padding:20px 40px;" id="editcontentform">
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label"><span
                                    class="colorred">* </span><span>审核内容：</span></label>
                        <div class="am-u-sm-10">
                            {{--<textarea id="editcontentinp" class="br5px minheight-xxs"></textarea>--}}
                            {{--<input id="editcontentinp" class="br5px" type="text"/>--}}
                            <script type="text/plain" id="editcontentinp" class="am-text-left"></script>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <div class="am-u-sm-10 am-u-sm-offset-2">
                            @if(Entrust::can('diags.editcontent'))
                            <button id="editcontentbtn" type="button" class="am-btn am-btn-primary br5px">提交</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--删除部门模态框-->
    <div class="am-modal am-modal-no-btn" id="df-modal">
        <div class="am-modal-dialog modalwidth-xss">
            <div class="am-modal-hd">
                <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i><span>删除审核内容</span></span>
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <div class="am-modal-bd rights-modal am-margin-top">
                <div class="lindiv"></div>
                <p class="am-text-center">
                    确定删除此条审核内容吗？删除后，内容将无法恢复
                </p>
                <p>
                    <button class="am-btn am-btn-primary br5px" name="" id="dfsuer">确定</button>
                    <button class="am-btn br5px" data-am-modal-close>取消</button>
                </p>
            </div>
        </div>
    </div>

    <!--查看法律法规-->
    <div class="am-modal am-modal-no-btn" id="flyjshow_modal">
        <div class="am-modal-dialog modalwidth-lg">
            <div class="am-modal-hd">
                <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i><span>查看法律法规</span></span>
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <div class="am-modal-bd rights-modal am-margin-top am-padding-bottom-lg">
                <div class="lindiv"></div>
                <table class="am-table am-table-bordered am-table-bd am-margin-top-lg">
                    <thead>
                    <tr class="am-active">
                        <th class="am-text-center am-text-middle" style="min-width: 180px;">法规条例名称</th>
                        <th class="am-text-center am-text-middle" style="min-width: 180px;">法规条例文号</th>
                        <th class="am-text-center am-text-middle" style="min-width: 180px;">法规条例条号</th>
                        <th class="am-text-center am-text-middle" style="min-width: 100px;">法规条例内容</th>
                    </tr>
                    </thead>
                    <tbody id="law_content">
                    </tbody>
                </table>
                <p>
                    <a href="javascript:void(0)" class="am-btn am-btn-primary br5px" data-am-modal-close>关闭</a>
                </p>

            </div>
        </div>
    </div>
@endsection
@section('javascript')
    @parent
    <script src=" {{ url('js/umeditor/third-party/template.min.js') }}" type="text/javascript" charset="utf-8" ></script>
    <script src="{{ url('js/umeditor/umeditor.config.js')  }}" type="text/javascript" charset="utf-8"></script>
    <script src=" {{ url('js/umeditor/umeditor.min.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src=" {{ url('js/validform/js/Validform_Datatype.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src=" {{ url('js/main.js') }}" type="text/javascript" charset="utf-8"></script>
    <script>
        var umadd = UM.getEditor('addcontent');
        var umedit = UM.getEditor('editcontentinp');
        var item_id = $('#item_id').val();
        //一键分配
        function yifpfun(e) {
            $("#yjzfpbtn").attr("name", $(e).attr("name"));
            $("#doc-modal-3").modal();
        }
        var yijianfpform = $("#yijianfpform").Validform({
            //btnSubmit:"#editformsub",
            tiptype: function (msgs, o, cssctl) {
                if (o.type != 2) { //只有不正确的时候才出发提示，输入正确不提示
                    layer.msg(msgs);
                }
            },
            ajaxPost: true, //true用ajax提交，false用form方式提交
            tipSweep: true, //true只在提交表单的时候开始验证，false每输入完一个输入框之后就开始验证
            beforeSubmit: function (curform) {
                var oDate1 = new Date($("#yj_start_date").val());
                var oDate2 = new Date($("#yj_end_date").val());
                var changl = {
                    'tasktable_type': "App\\Models\\DiagSubmod"
                };
                var postDta = JsonInsert(GetWebControls("#yijianfpform"), changl);
                if (oDate1.getTime() > oDate2.getTime()) {
                    layer.msg('结束时间必须大于开始时间')
                    return false;
                } else {
                    AjaxJson('/admin/item/'+item_id +'/task/setTaskAll/' + $("#yjzfpbtn").attr("name"), {'taskContent': postDta}, function (data) {
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
        });

        //指派
        function zpfun(e) {
            $("#zpbtn").attr("name", $(e).attr("name"));
            $("#doc-modal-2").modal();
        }
        var zpeditform = $("#zpeditform").Validform({
            // btnSubmit:"#editformsub",
            tiptype: function (msgs, o, cssctl) {
                if (o.type != 2) { //只有不正确的时候才出发提示，输入正确不提示
                    layer.msg(msgs);
                }
            },
            ajaxPost: true, //true用ajax提交，false用form方式提交
            tipSweep: true, //true只在提交表单的时候开始验证，false每输入完一个输入框之后就开始验证
            beforeSubmit: function (curform) {

                var postDta = GetWebControls("#zpeditform");
                AjaxJson('/admin/item/task/tasks/' + $("#zpbtn").attr("name"), {'taskContent': postDta}, function (data) {
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
                return false;
            },
        });

        //模块分配
        function zmokuaifun(e) {
            var url = '/admin/item/'+item_id +'/task/checktask/' + $(e).attr("name");
            AjaxJson(url,{type:'diag_module'},function (data) {
                if(data.status == 1){
                    layer.msg('该任务已经分配过了，确定重新分配吗？', {
                        time: 0 //不自动关闭
                        ,btn: ['确定', '取消']
                        ,yes: function(index){
                            layer.close(index);
                            $("#zfpbtn").attr("name", $(e).attr("name"));
                            $("#doc-modal-1").modal();
                        }
                    });
                }else {
                    $("#zfpbtn").attr("name", $(e).attr("name"));
                    $("#doc-modal-1").modal();
                }
            });
//            $("#zfpbtn").attr("name", $(e).attr("name"));
//            $("#doc-modal-1").modal();
        }
        var zmokuaiform = $("#zmokuaiform").Validform({
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
                    'tasktable_type': "App\\Models\\DiagSubmod"
                }
                var postDta = JsonInsert(GetWebControls("#zmokuaiform"), changl)
                if (oDate1.getTime() > oDate2.getTime()) {
                    layer.msg('结束时间必须大于开始时间');
                    return false;
                } else {
                    AjaxJson('/admin/item/'+item_id +'/task/setTask/' + $("#zfpbtn").attr("name"), {'taskContent': postDta}, function (data) {
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
        });

        //增加审核内容
        function addcontent(e) {
            $("#addcontentbtn").attr("name", $(e).attr("name"));
            $("#doc-modal-5").modal();
        }
        var addcontentform = $("#addcontentform").Validform({
            //btnSubmit:"#editformsub",
            tiptype: function (msgs, o, cssctl) {
                if (o.type != 2) { //只有不正确的时候才出发提示，输入正确不提示
                    layer.msg(msgs);
                }
            },
            ajaxPost: true, //true用ajax提交，false用form方式提交
            tipSweep: true, //true只在提交表单的时候开始验证，false每输入完一个输入框之后就开始验证
            beforeSubmit: function (curform) {
                openLoad();
                var url = '/admin/item/diags/addcontent/' + $("#addcontentbtn").attr("name");
//                var postDta = JsonInsert(GetWebControls("#addcontentform"));
                AjaxJson(url, {'content': UM.getEditor('addcontent').getContent()}, function (data) {
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
                return false;
            },
        });

        //编辑审核内容
        function editcontent(e) {
            $("#editcontentbtn").attr("name", $(e).attr("name"));
            var bjid = $(e).attr("name");
            var url = '/admin/item/diags/editcontent/' + bjid;
            //调用接口返回审核内容填充到输入框(data.content指的是输入框的审核内容)
            AjaxJson(url, {}, function (data) {
                $("#editcontentinp").html(data.content);
                $("#editcontent-modal").modal();
            })
        }
        //        点击编辑审核内容的模态框的提交按钮提交数据。
        $("#editcontentbtn").click(function () {
            var content = UM.getEditor('editcontentinp').getContent();
            var tidi =  $("#editcontentbtn").attr("name");
            var url = '/admin/item/diags/storecontent/' + tidi;
            AjaxJson(url, {content:content}, function (data) {
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
        });

        //客户端删除
        function dfcontent(e) {
            var dfid = $(e).attr("name");
            var url = '/admin/item/diags/delcontent/' + dfid;
            layer.msg('确定删除该行吗？', {
                time: 0 //不自动关闭
                , btn: ['确定', '取消']
                , yes: function (index) {
                    //点击确定删除之后的动作
                    AjaxJson(url, {}, function (data) {
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
//                    $(e).parents("tr").remove();
//                    layer.close(index);
                }
            });
        }

        //查看状态点击查看法律法规
        function flyjshowfun(e) {
            var diag_content_id = $(e).attr("name");
            var url = '/admin/item/diags/'+ diag_content_id +'/law/see';
            AjaxJson(url,{},function(data){
                $("#law_content").html(data.html);
            });
            $("#flyjshow_modal").modal();
        }
    </script>
@endsection