@foreach($diag_mod->diag_submods as $diag_submod)
    @if(($diag_submod->adminUser &&  Auth::guard('admin')->user()->id == $diag_submod->adminUser->id) || Auth::guard('admin')->user()->id == 23)
        <div class="smallm-card">
    <div class="am-fl">{{ $diag_submod->name }}</div>
    <div class="am-fr color888">
        @if($diag_submod->task)
            <span>子模块负责人：</span>
            <span class="am-margin-right">
                {{ $diag_submod->adminUser ? $diag_submod->adminUser->name : '' }}
            </span>
            {{--1.进行中,2.已延期,3.未开始,4.已完成--}}
            @if($diag_submod->task->status == 4)
                <span class="ztspan mystate4">已完成</span>
            @elseif($diag_submod->task->status == 1)
                <span class="ztspan mystate1">进行中</span>
            @elseif($diag_submod->task->status == 2 )
                <span class="ztspan mystate2">已延期</span>
            @elseif($diag_submod->task->status == 5)
                <span class="ztspan mystate5">待查看</span>
            @endif
            <span class="am-margin-left">最新更新：</span>
            <time>{{$diag_submod->task->updated_at->toDateString() }}</time>
        @else
            <span>模块负责人：</span><span class="am-margin-right">暂无</span>
            <span class="ztspan mystate3">未开始</span>
            <span class="am-margin-left">最新更新：暂无</span>
            <time></time>
        @endif

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
            <th class="am-text-middle" style="min-width: 320px">
                建议及改善方案
            </th>
            <th class="am-text-middle" style="min-width: 100px">
                操作
            </th>
        </tr>
        </thead>
        <tbody>
            @if($diag_submod->diag_mods->name == '2')
                @each('admin._partials.subContentAeo',$diag_submod->diag_subcontents,'diag_subContent')
            @else
                @each('admin._partials.subContent',$diag_submod->diag_subcontents,'diag_subContent')
            @endif
        </tbody>
    </table>
</div>
    @endif
@endforeach

{{--模态框--}}
<div class="am-modal am-modal-no-btn" id="flyjedit_modal">
    <div class="am-modal-dialog modalwidth-lg">
        <div class="am-modal-hd">
            <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i><span>编辑法律法规</span></span>
            <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
        </div>
        <div class="am-modal-bd rights-modal am-margin-top am-padding-bottom-lg">
            <div class="lindiv"></div>
            <form class="am-form am-form-horizontal am-margin-top-lg" id="flyjedit_form">
                <div class="am-form-group card-box">
                    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label"><span class="colorred">*</span> 选择法律法规:</label>
                    <div class="am-u-sm-6">
                        <select class="br5px" datatype="selectnull" nullmsg="请选择法律法规" id="selectchoose1" onchange="selectchoose1fun(this)">
                            <option value="">请选择</option>

                        </select>
                    </div>
                </div>
                <div class="am-form-group card-box">
                    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label"><span class="colorred">*</span> 法规条例文号:</label>
                    <div class="am-u-sm-6">
                        <select name="" class="br5px" datatype="selectnull" nullmsg="请选择法规条例文号" id="selectchoose2" onchange="selectchoose2fun(this)">
                            <option value="">请选择</option>

                        </select>
                    </div>
                </div>
                <div class="am-form-group card-box">
                    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">法规内容:</label>
                    <div class="am-u-sm-6">
                        <input id="fgcontentinp" type="text" class="br5px" readonly="readonly" />
                    </div>
                </div>
                <div class="am-form-group card-box">
                    <div class="am-u-sm-9 am-u-sm-offset-2 fgcheck-box" id="fgcheck_box">


                    </div>
                </div>
                <a href="javascript:void(0)" id="editsub" class="am-btn am-btn-primary br5px">确认</a>
            </form>
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
            <a href="javascript:void(0)" class="am-btn am-btn-primary br5px" data-am-modal-close>关闭</a>
        </div>
    </div>
</div>