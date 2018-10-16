@inject('appPresenter','App\Presenters\AppPresenter')

<ul class="am-nav am-nav-tabs new-tabs-box">
    @if(Entrust::can('diag.index'))
        <li class="{{ $appPresenter->activeMenuByRoute(['diag']) }}">
            <a href="{{ route('diag.index',[$item->id]) }}">诊断结果概述</a>
        </li>
    @endif
    @if(Entrust::can('guanwu.diags'))
        <li class="{{ $appPresenter->activeMenuByRoute(['guanwu','aeo','system','wuliu','diags']) }}">
            <a href="{{ route('guanwu.diags',[$item->id]) }}">诊断结果具体分析</a>
        </li>
    @endif
    @if(Entrust::can('user.background'))
        <li class="{{ $appPresenter->activeMenuByRoute(['user']) }}">
            <a href="{{ route('user.background',[$item->id]) }}">企业背景描述</a>
        </li>
    @endif
    @if(Entrust::can('closure.index'))
        <li class="{{ $appPresenter->activeMenuByRoute(['closure']) }}">
            <a href="{{ route('closure.index',[$item->id]) }}">附录</a>
        </li>
    @endif
</ul>
