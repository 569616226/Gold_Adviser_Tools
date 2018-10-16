@extends('layouts.app')
@section('title', '服务反馈')

@section('content')
		<div class="bgfff" style="margin: 30px 70px;">
			 <p class="fs28 am-text-center am-padding-top-lg">客户服务反馈表</p>
			 <div style="padding: 50px 10%;">
			 	
			 	<div class="lindiv"></div>
			 	<div class="am-g am-margin-top card-box">
			 		<div class="am-u-sm-6">
			 			<div class="am-u-sm-3 color888">
			 				服务日期：
			 			</div>
			 			<div class="am-u-sm-8 am-text-left">
							<span class="am-margin-right">{{   $suggest->tasks->start_date->toDateString() }}</span>到
							<span class="am-margin-left">{{   $suggest->tasks->start_date->toDateString() }}</span>
			 			</div>
			 		</div>
			 		<div class="am-u-sm-6">
			 			<div class="am-u-sm-3 color888">
			 				客户名称：
			 			</div>
			 			<div class="am-u-sm-8 am-text-left">
							<span>{{ $suggest->tasks->items->hands->users->name }}</span>
			 			</div>
			 		</div>
			 	</div>
			 	<div class="am-g am-margin-top card-box am-margin-bottom">
			 		<div class="am-u-sm-6">
			 			<div class="am-u-sm-3 color888">
			 				服务人员：
			 			</div>
			 			<div class="am-u-sm-8 am-text-left">
							<span>{{ $suggest->tasks->admin_users->name }}</span>
			 			</div>
			 		</div>
			 	</div>
			 	<div class="lindiv"></div>
			 	
			 	<div class="fk-box">
			 		<p class="fs20">1、本次服务内容：</p>
			 		<table class="am-table am-table-bordered am-table-centered">
			 			<thead>
			 				<tr class="am-active">
				 				<th class="am-text-middle" style="width: 100px">序号</th>
				 				<th class="am-text-middle">重点服务项目及内容</th>
				 				<th class="am-text-middle">备注</th>
				 			</tr>
			 			</thead>
			 			<tbody>
			 				<tr>
								<td class="am-text-middle">{{ $suggest->tasks->id }}</td>
								<td class="am-text-middle am-text-left">{{ $suggest->tasks->title }}</td>
								<td class="am-text-middle">{{count($suggest) ? $suggest->remark : '暂无'}}</td>
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
				 				<th class="am-text-middle" style="width: 100px;">序号</th>
				 				<th class="am-text-middle">问题</th>
				 				<th class="am-text-middle">改善建议</th>
				 				<th class="am-text-middle" style="width: 120px;">计划完成时间</th>
				 			</tr>
			 			</thead>
			 			<tbody>
						@if(count($suggest->advises))
							@foreach($suggest->advises as $advise)
								<tr>
									<td class="am-text-middle am-text-center">{{ $advise->no }}</td>
									<td class="am-text-middle am-text-left">{{ $advise->title }}</td>
									<td class="am-text-middle">{{ $advise->content }}</td>
									<td class="am-text-middle">
										<time>{{ $advise->plan_date }}</time>
									</td>
								</tr>
							@endforeach
						@endif
			 			</tbody>
			 			<tfoot>
			 				<tr>
			 					<td class="am-text-middle am-text-left" colspan="4">
									<span>{{ $suggest->service_remark }}</span>
			 					</td>
			 				</tr>
			 			</tfoot>
			 		</table>
			 	</div>
			 	
			 	<div class="fk-box">
			 		<p class="fs20">3、客户本次服务客户反馈：</p>
			 		<p class="color888"> 真诚感谢您在本次服务中及予我们的配合与支持！为了进一步提升我们的服务水平和质量，请您对我们的服务提出宝贵意见或建议。</p>
			 		<form action="{{ route('guest.suggest.store',[$suggest->id]) }}" method="post">
						{{ csrf_field() }}
			 			<div class="fs18">
				 		 	<span class="colorred">* </span>
				 		 	<span class="color888">请对本次服务进行打分：</span>
				 		 	<input type="radio" name="score" value="2" checked="checked" />
				 		 	<span class="am-margin-right-lg">非常满意</span>
				 		 	<input type="radio" name="score" value="1" />
				 		 	<span class="am-margin-right-lg">满意</span>
				 		 	<input type="radio" name="score" value="0" />
				 		 	<span>不满意</span>
				 		 </div>
				 		 <div class="am-margin-top">
				 		 	<textarea name="content" class="widthMax br10px" style="min-height: 180px !important; border-color: #d8d8d8;" placeholder="请给我们的服务质量及客户意见，提点建议吧"></textarea>
				 		 </div>
				 		 <div class="am-text-center am-margin-top-lg">
				 		 	<input type="submit"  value="提交" class="am-btn am-btn-primary br5px" />
							 <a type="a" href="{{ route('guest.suggest.index',[$suggest->tasks->items->id]) }}" class="am-btn am-btn-white br5px am-margin-left" >取消</a>
				 		 </div>
			 		</form>
			 	</div>
			 </div>
		</div>
@endsection

@section('javascript')
@parent

<script>
	$(document).ready(function(){
		$("input").iCheck({
			radioClass:'iradio_square-blue'
		})
	})
</script>
@endsection