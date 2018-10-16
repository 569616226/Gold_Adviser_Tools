@inject('appPresenter','App\Presenters\AppPresenter')


<div class="imgBox">
    <img src="{{ $item->images ?$item->images->url : url('images/dhproject.png') }}" alt=""/>
    <a href="{{ route('item.edit',[$item->id]) }}" class="am-fr" style="margin-top: -20px; margin-right: 0px; margin-bottom: 8px;"><i class="iconfont" style="color: #03A9F4">&#xe678;</i></a>
    <div style="clear: both"></div>
</div>
<div class="lindiv am-g"></div>
<nav class="dh-nav">
    <ul class="am-nav am-g">

        @if(Entrust::can('item.pro'))
            <li class="{{ $appPresenter->activeMenuByRoute(['item']) }}">
                <a href="{{ route('item.pro',[$item->id]) }}"><i class="iconfont">&#xe611;</i>项目概况</a>
            </li>
        @endif
        @if(Entrust::can('material.index'))
            <li class="{{ $appPresenter->activeMenuByRoute(['material']) }}">
                <a href="{{ route('material.index',[$item->id]) }}"><i class="iconfont">&#xe630;</i>材料清单</a>
            </li>
        @endif
        @if(Entrust::can('diag.index'))
            <li class="{{ $appPresenter->activeMenuByRoute(['diag','diags','user','closure','aeo','guanwu','system','wuliu']) }}">
                <a href="{{ route('diag.index',[$item->id]) }}"><i class="iconfont">&#xe66d;</i>诊断报告</a>
            </li>
        @endif
        @if(Entrust::can('improve.index'))
            <li class="{{ $appPresenter->activeMenuByRoute(['improve']) }}">
                <a href="{{ route('improve.index',[$item->id]) }}"><i class="iconfont">&#xe60e;</i>改善实施计划</a>
            </li>
        @endif
    </ul>
</nav>
<div class="lindiv am-g"></div>
<nav class="dh-nav">
    <ul class="am-nav am-g">
        @if(Entrust::can('all.task'))
            <li class="{{ $appPresenter->activeMenuByRoute(['all']) }}">
                <a href="{{ route('all.task',[$item->id]) }}"><i class="iconfont">&#xe60c;</i>全部任务</a>
            </li>
        @endif

        @if(Entrust::can('task.index'))
        <li class="{{ $appPresenter->activeMenuByRoute(['task','suggest']) }}">
            <a href="{{ route('task.index',[$item->id]) }}"><i class="iconfont">&#xe611;</i>我的任务</a>
        </li>
        @endif

        @if(Entrust::can('allot.index'))
        <li class="{{ $appPresenter->activeMenuByRoute(['allot']) }}">
            <a href="{{ route('allot.index',[$item->id]) }}"><i class="iconfont">&#xe630;</i>我分配的</a>
        </li>
        @endif
    </ul>
</nav>
<div class="lindiv am-g"></div>
