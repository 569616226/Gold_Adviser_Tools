@extends('layouts.app')
@section('title', '服务反馈')

@section('content')
<main class="">
	 <div class="am-g">
		<div class="am-u-sm-10 am-u-sm-centered">
			<p>
				<a class="am-margin-right" href="{{ url('/') }}"><i class="iconfont">&#xe604;</i></a>{{ $item->hands->users->name }}  服务反馈
				<span class="am-fr color888">您还有<span>{{ $TaskCount }}</span>条服务未评价！！</span>
			</p>
			<div class="bgfff">
				<table class="am-table am-table-centered">
					<tr>
						<th class="am-text-middle" style="width: 100px;">编号</th>
						<th class="am-text-left am-text-middle" style="max-width: 700px;">标题</th>
						<th class="am-text-middle" style="min-width: 120px;">状态</th>
						<th class="am-text-middle" style="min-width: 120px;">服务开始日期</th>
						<th class="am-text-middle" style="min-width: 120px;">服务结束日期</th>
						<th class="am-text-middle">服务评价</th>
						<th class="am-text-middle">服务顾问</th>
						<th class="am-text-middle">服务反馈</th>
					</tr>
					@if(isset($tasks))
						@foreach($tasks as $task)
							@if(count($task->suggests))
							<tr>
							<td class="am-text-middle">{{ $task->id }}</td>
							<td class="am-text-left am-text-middle" style="max-width: 700px;">{{ $task->title }}</td>
							<td class="am-text-middle">
								@if($task->suggests->score == -1)
									<span class="ztspan mystate1">未评价</span>
								@else
									<span class="ztspan mystate2">已评价</span>
								@endif
							</td>
							<td class="am-text-middle">
								<time>{{ $task->start_date->toDateString() }}</time>
							</td>
							<td class="am-text-middle">
								<time>{{ $task->end_date->toDateString() }}</time>
							</td>
							<td class="am-text-middle">
								<span>
									@if($task->suggests->score == 0)
										不满意
									@elseif($task->suggests->score == 1)
										满意
									@elseif($task->suggests->score == 2)
										非常满意
									@endif
								</span>
							</td>
							<td class="am-text-middle">
								<span>{{ $task->admin_users->name}}</span>
							</td>
							<td class="am-text-middle">
								@if($task->suggests->score == -1)
									<a href="{{ route('guest.suggest.edit',[$task->suggests->id]) }}" class="am-btn am-btn-primary br5px">评价</a>
								@else
									<a href="{{ route('guest.suggest.show',[$task->suggests->id]) }}" class="am-btn am-btn-white br5px">查看</a>
								@endif
							</td>
						</tr>
							@endif
						@endforeach
					@endif
				</table>
			</div>
		</div>
	 </div>
</main>
@endsection
