@extends('layouts.admin-app')
@section('title', '服务反馈表')
@section('css')
@parent
<link rel="stylesheet" type="text/css" href="{{ url('js/percircle/percircle.css') }}"/>
<link rel="stylesheet" href="{{ url('css/main.css') }}">
<style type="text/css">
 		.sreceiptCard0 .am-form-group {
 			margin-left: -20px;
 		}
 		a.colorred:hover, a.colorred:focus{
 			color: red;
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
		<div class="am-u-sm-9 am-u-md-9 am-u-lg-10">
				<!--项目概况-->
				<div class="dh-main-container">
				 <form id="subform">
					<p class="title fs18"><a href="{{ route('task.index',[$item->id]) }}"><i class="iconfont">&#xe604;</i></a>服务反馈表
						@if(!isset($suggest) || $suggest->score == -1)
							<a href="javascript:void(0);" name="{{ $task->id }}" id="falshBtn" class="am-fr am-btn am-btn-secondary br5px">预览并保存</a>
							@if(isset($suggest) && $suggest->active == 0)
								<a href="{{ route('suggest.active',[$suggest->id]) }}" class="am-fr am-btn am-btn-white br5px am-margin-right">提交客户</a>
							@endif
						@endif
					</p>
				 	
				 	<div class="pro-card">
				 		<div class="fs20 am-margin-left-lg">表单信息</div>
				 		<div style="padding-left: 10%;" class="am-margin-top">
				 			<p>
					 			<span class="color888">服务日期：</span>
					 			<span class="am-margin-right">{{ $task->start_date->toDateString() }}</span>到
					 			<span class="am-margin-left">{{ $task->end_date->toDateString() }}</span>
					 		</p>
					 		<p>
					 			<span class="color888">客户名称：</span>
					 			<span>{{ $task->items->hands->name }}</span>
					 		</p>
					 		<p>
					 			<span class="color888">服务人员：</span>
					 			<span>{{ $task->admin_users->name }}</span>
					 		</p>
				 		</div>
				 	</div>
					<div class="pro-card am-margin-top-lg">
				 		<div class="fs20 am-margin-left-lg">本次服务内容</div>
						<table class="am-table am-table-bordered am-table-centered am-margin-top">
				 		 		<thead>
				 		 			<tr class="am-active">
					 		 			{{--<th class="am-text-middle" style="min-width: 70px;">序号</th>--}}
					 		 			<th class="am-text-middle">重点服务项目及内容</th>
					 		 			<th class="am-text-middle">备注</th>
					 		 		</tr>
				 		 		</thead>
				 		 		<tbody id="content">
				 		 			<tr>
					 		 			{{--<td class="am-text-middle">1</td>--}}
										<td class="am-text-middle am-text-left">{{ $task->title }}</td>
					 		 			<td class="am-text-middle">
					 		 				<textarea name="remark" id="remark" class="widthMax minheight-xxs" style="border: none;" placeholder="请输入备注">{{ isset($suggest) ? $suggest->remark : '' }}</textarea>
					 		 			</td>
					 		 		</tr>
				 		 		</tbody>
				 		 	</table>
				 	</div>
				 	
				 	<div class="pro-card am-margin-top-lg">
				 		<div class="fs20 am-margin-left-lg">服务问题改善建议书</div>
				 		 	<table class="am-table am-table-bordered am-table-centered am-margin-top">
				 		 		<thead>
				 		 			<tr class="am-active">
					 		 			<th class="am-text-middle" style="min-width: 300px; width: 38%;">问题</th>
					 		 			<th class="am-text-middle" style="min-width: 200px; width: 42%;" >改善建议</th>
					 		 			<th class="am-text-middle" style="width: 120px; width: 10%;">计划完成时间</th>
					 		 			<th class="am-text-middle" style="width:100px; width: 10%;">操作</th>
					 		 		</tr>
				 		 		</thead>
				 		 		<tbody id="contacts">
								@if(isset($suggest) && !$suggest->advises->isEmpty())
									@foreach($suggest->advises as $advise)
									<tr>
										<td class="am-text-middle"><textarea name="title" datatype="*" nullmsg="请填写服务问题" class="widthMax heightMax" style="border: none;" placeholder="请输入服务问题">{{ $advise->title }}</textarea></td>
										<td class="am-text-middle"><textarea name="content" class="widthMax heightMax" datatype="*" nullmsg="请填写改善建议" style="border: none;" placeholder="请输入改善建议">{{ $advise->content }}</textarea></td>
										<td class="am-text-middle"  style="width: 150px;">
											<input name="advise_id" type="hidden" value="{{ $advise->id }}">
											<input name="plan_date" datatype="*" nullmsg="请选择计划时间" value="{{ $advise->plan_date }}" type="text" class="am-form-field amTime" data-am-datepicker readonly required />
										</td>
										<td class="am-text-middle"><a href="javascript:void(0);" onclick="dfrow(this)" class="colorred">删除</a></td>
									</tr>
									@endforeach
								@endif
				 		 		</tbody>
				 		 		<tfoot>
				 		 			<tr>
				 		 				<td class="am-text-middle" colspan="4">
				 		 					<a href="javascript:void(0);" id="addrowbtn"><i class="iconfont" style="position: relative; top: 2px;">&#xe622;</i> 添加新的内容</a>
				 		 				</td>
				 		 			</tr>
				 		 			<tr>
										<td width="80px;" class="am-text-center am-text-middle">
											备注：
										</td>
				 		 				<td class="am-text-middle am-text-left" colspan="3">
				 		 					<textarea id="service_remark" name="service_remark" class="widthMax minheight-xxs" style="border: none;">{{ isset($suggest) ? $suggest->service_remark : '' }}</textarea>
				 		 				</td>
				 		 			</tr>
				 		 		</tfoot>
				 		 	</table>
					</div>
				 </form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('javascript')
@parent
<script src="{{ url('js/searchableSelect/jquery.searchableSelect.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ url('js/main.js') }}" type="text/javascript" charset="utf-8"></script>
<script>
 //增加一行
        $("#addrowbtn").click(function () {
            var strVar = "";
          	strVar +='<tr><td class="am-text-middle"><textarea name="title" class="widthMax heightMax" datatype="*" nullmsg="请填写服务问题" style="border: none;" placeholder="请输入服务问题"></textarea></td>'
          	strVar +='<td class="am-text-middle"><textarea name="content" class="widthMax heightMax" datatype="*" nullmsg="请填写改善建议" style="border: none;" placeholder="请输入改善建议"></textarea></td>'
          	strVar +='<td class="am-text-middle" style="width: 120px;"> <input name="plan_date" datatype="*" nullmsg="请选择时间" type="text" placeholder="请选择时间" class="am-form-field amTime" data-am-datepicker readonly required /></td>'
          	strVar +='<td class="am-text-middle"><a href="javascript:void(0);" onclick="dfrow(this)" class="colorred">删除</a></td></tr>'
            $("#contacts").append(strVar);
            $('.amTime').datepicker();
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

 		$("#subform").Validform({
            tiptype: function (msgs, o, cssctl) {
                if (o.type != 2) {     //只有不正确的时候才出发提示，输入正确不提示
                    layer.msg(msgs);
                }
            },
            btnSubmit: "#falshBtn",
            ajaxPost: true,//true用ajax提交，false用form方式提交
            tipSweep: true,//true只在提交表单的时候开始验证，false每输入完一个输入框之后就开始验证
            beforeSubmit: function (curform) {

            	//本次服务内容的备注（数组形式）
            	//需要在每个输入框添加对应的name值，才能取到（目前留空）
              var content = $("#remark").val();
//            服务问题改善建议书（数组形式）
                var contacs = [];
                $("#contacts tr").each(function (e) {
                    var $this = $(this);
                    contacs.push(GetWebControls($this))
                });
                if(contacs == "") {
                    layer.msg("服务问题改善建议书还没有添加");
                    return false;
				}
               var task_id = $("#falshBtn").attr("name");
                openLoad();
                var url = '/admin/item/suggest/' + task_id;
                console.log(content)
                console.log(contacs)
                console.log($("#service_remark").val())
                AjaxJson(url, {
                    'remark':content,
                    'contacs':contacs,
                    'service_remark':$("#service_remark").val()
				}, function (data) {
                    if (data.status == 1) {
                        layer.msg(data.msg);
                        window.location.href = data.onurl;
                    } else {
                        layer.msg(data.msg);
                    }
                });
                return false;
            }
        });
</script>
@endsection