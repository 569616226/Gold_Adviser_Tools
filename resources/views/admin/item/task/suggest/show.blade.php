<!doctype html>
<html class="no-js">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="">
		<meta name="keywords" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>客户服务反馈表</title>
		<!-- Set render engine for 360 browser -->
		<meta name="renderer" content="webkit">
		<!-- No Baidu Siteapp-->
		<meta http-equiv="Cache-Control" content="no-siteapp" />
		<!-- <link rel="icon" type="image/png" href="assets/i/favicon.png"> -->

		<!-- Add to homescreen for Safari on iOS -->
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="apple-mobile-web-app-title" content="" />
		<link rel="stylesheet" href="{{ url('css/amazeui.min.css') }}"/>
		<link rel="stylesheet" type="text/css" href="{{ url('js/icheck/skins/icheck-all.css') }}"/>
		<link rel="stylesheet" href="{{ url('css/main.css') }}"/>
	</head>
 
	<body>
		<div class="bgfff" style="margin: 30px 70px;">
			 <p class="fs28 am-text-center am-padding-top-lg">客户服务反馈表</p>
			 <div style="padding: 50px 10%;">
			 	<div class="kyfgjy">
					@if($task->suggests->score == 0)
			 			<img class="rightTip" src="{{ url('images/bumanyi.png') }}"/>
					@elseif($task->suggests->score == 1)
						<img class="rightTip" src="{{ url('images/manyi.png') }}"/>
					@elseif($task->suggests->score == 2)
						<img class="rightTip" src="{{ url('images/feichangmanyi.png') }}"/>
					@endif
			 		<p class="title">客户反馈:</p>
			 		<div class="content">
			 			{{ $task->suggests->content }}
			 		</div>
			 	</div>
			 	<div class="lindiv"></div>
			 	<div class="am-g am-margin-top card-box">
			 		<div class="am-u-sm-6">
			 			<div class="am-u-sm-3 color888">
			 				服务日期：
			 			</div>
			 			<div class="am-u-sm-8 am-text-left">
							<span class="am-margin-right">{{ $task->start_date->toDateString() }}</span>到
							<span class="am-margin-left">{{ $task->end_date->toDateString() }}</span>
			 			</div>
			 		</div>
			 		<div class="am-u-sm-6">
			 			<div class="am-u-sm-3 color888">
			 				客户名称：
			 			</div>
			 			<div class="am-u-sm-8 am-text-left">
							<span>{{ $task->items->hands->users->name }}</span>
			 			</div>
			 		</div>
			 	</div>
			 	<div class="am-g am-margin-top card-box am-margin-bottom">
			 		<div class="am-u-sm-6">
			 			<div class="am-u-sm-3 color888">
			 				服务人员：
			 			</div>
			 			<div class="am-u-sm-8 am-text-left">
							<span>{{ $task->admin_users->name }}</span>
			 			</div>
			 		</div>
			 	</div>
			 	<div class="lindiv"></div>
			 	
			 	<div class="fk-box">
			 		<p class="fs20">1、本次服务内容：</p>
			 		<table class="am-table am-table-bordered am-table-centered">
			 			<thead>
			 				<tr class="am-active">
				 				{{--<th class="am-text-middle" style="min-width: 70px;">序号</th>--}}
				 				<th class="am-text-middle">重点服务项目及内容</th>
				 				<th class="am-text-middle">备注</th>
				 			</tr>
			 			</thead>
			 			<tbody>
			 				<tr>
				 				{{--<td class="am-text-middle">{{ $task->id }}</td>--}}
				 				<td class="am-text-middle am-text-left">{{ $task->title }}</td>
				 				<td class="am-text-middle">{{count($task->suggests) ? $task->suggests->remark : '暂无'}}</td>
				 			</tr>
			 			</tbody>
			 		</table>
			 	</div>

			 	<div class="fk-box">
			 		<p class="fs20">2、服务问题改善建议书：</p>
			 		<p class="color888"> 根据本次服务情况对如下项目提出建议，并在计划时间内努力改善，以便共同推动服务进程。</p>
			 		<table class="am-table am-table-bordered am-table-centered">
			 			<thead>
			 				<tr class="am-active">
				 				<th class="am-text-middle" style="width: 70px;">序号</th>
				 				<th class="am-text-middle">问题</th>
				 				<th class="am-text-middle">改善建议</th>
				 				<th class="am-text-middle" style="width: 120px;">计划完成时间</th>
				 			</tr>
			 			</thead>
			 			<tbody>
						@if(isset($task->suggests->advises))
							@foreach($task->suggests->advises as $advise)
								<tr>
									<td class="am-text-middle am-text-center">{{ $advise->no }}</td>
									<td class="am-text-middle am-text-left">{{ $advise->title }}</td>
									<td class="am-text-middle">{{ $advise->content }}</td>
									<td class="am-text-middle">
										<time>{{ $advise->plan_date->toDateString() }}</time>
									</td>
								</tr>
							@endforeach
						@endif
			 			</tbody>
						@if($task->suggests->service_remark !== '')
			 			<tfoot>
			 				<tr>
								<td width="80px;" class="am-text-center am-text-middle">
									备注：
								</td>
			 					<td class="am-text-middle am-text-left" colspan="3">
			 						<span>{{ $task->suggests->service_remark }}</span>
			 					</td>
			 				</tr>
			 			</tfoot>
						@endif
			 		</table>
			 	</div>
			 </div>
		</div>
		<footer class="am-topbar-fixed-bottom bgfff pa1010">
			<div style="padding-top: 8px;">
				</p>
				<div class="am-fr">
					<a href="{{ isset($suggest) && $suggest->score != -1 ? route('task.index',[$suggest->tasks->items->id]) : route('suggest.index',[$suggest->tasks->items->id,$suggest->tasks->id]) }}" class="am-fr am-btn am-btn-white br5px">返回上一页</a>
					@if(Entrust::can('suggest.active') && $suggest->score == -1)
						<a href="{{ route('suggest.active',[$suggest->id]) }}" class="am-fr am-btn am-btn-primary br5px am-margin-right">提交客户</a>
					@endif
				</div>
			</div>
		</footer>
<!--[if (gte IE 9)|!(IE)]><!-->
<script src="{{ url('js/jquery.min.js') }}"></script>
<!--<![endif]-->
		<!--[if lte IE 8 ]>
<script src="http://libs.baidu.com/jquery/1.11.3/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="{{ url('assets/js/amazeui.ie8polyfill.min.js') }}"></script>
<![endif]-->
<script src="{{ url('js/amazeui.min.js') }}"></script>
<script src="{{ url('js/icheck/icheck.min.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ url('js/main.js') }}" type="text/javascript" charset="utf-8"></script>
</body>
</html>