@extends('layouts.app')
@section('title', '服务反馈')

@section('content')
	<div class="bgfff" style="margin: 30px 70px;">
		<p class="fs28 am-text-center am-padding-top-lg">客户服务反馈表</p>
		<div style="padding: 50px 10%;">
			<div class="kyfgjy">
				@if($suggest->score == 0)
					<img class="rightTip" src="{{ url('images/bumanyi.png') }}"/>
				@elseif($suggest->score == 1)
					<img class="rightTip" src="{{ url('images/manyi.png') }}"/>
				@elseif($suggest->score == 2)
					<img class="rightTip" src="{{ url('images/feichangmanyi.png') }}"/>
				@endif
				<p class="title">客户反馈:</p>
				<div class="content">
					{{ $suggest->content }}
				</div>
			</div>
			<div class="lindiv"></div>
			<div class="am-g am-margin-top card-box">
				<div class="am-u-sm-6">
					<div class="am-u-sm-3 color888">
						服务日期：
					</div>
					<div class="am-u-sm-8 am-text-left">
						<span class="am-margin-right">{{ $suggest->tasks->start_date->toDateString() }}</span>到
						<span class="am-margin-left">{{ $suggest->tasks->end_date->toDateString() }}</span>
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
						<th class="am-text-middle" style="min-width: 70px;">序号</th>
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
						<th class="am-text-middle" style="min-width: 70px;">序号</th>
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
									<time>{{ $advise->plan_date->toDateString() }}</time>
								</td>
							</tr>
						@endforeach
					@endif
					</tbody>
					<tfoot>
					<tr>
						<td width="80px;" class="am-text-center am-text-middle">
							备注：
						</td>
						<td class="am-text-middle am-text-left" colspan="3">
							<span>{{ $suggest->service_remark }}</span>
						</td>
					</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<footer class="am-topbar-fixed-bottom bgfff pa1010">
		<div style="padding-top: 8px;">
			<div class="am-fr">
				@if(
                Entrust::can('handover.edit') && Entrust::can('handover.index') && Entrust::can('user.index'))
					{{--<a href="{{ route('handover.edit',[$user->id]) }}" class="am-btn am-btn-primary br5px">修改交接单</a>--}}
				@endif
				<a href="/" class="am-btn am-btn-white br5px">返回上一页</a>
			</div>
		</div>
	</footer>
@endsection