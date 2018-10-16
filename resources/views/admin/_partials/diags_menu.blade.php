@inject('appPresenter','App\Presenters\AppPresenter')
<style>
    .new-tabs-box li.am-active a:after {
        bottom: -1px;
    }
</style>
<div class="pro-card nav-child" style="background: #F7F7F7;padding: 1rem;position: relative; top: -14px;">
<ul class="am-nav am-nav-pills fs14">
    @if(Entrust::can('guanwu.diags'))
        <li class="{{ $appPresenter->activeMenuByRoute(['guanwu']) }}">
            <a href="{{ route('guanwu.diags',[$item->id]) }}">关务风险管理</a>
        </li>
    @endif

    <li class="{{ $appPresenter->activeMenuByRoute(['aeo']) }} {{ Entrust::can('guanwu.diags') &&  $item->hands->users->aeo != -1 ? '' : 'am-hide' }}">
        <a href="{{ route('aeo.diags',[$item->id]) }}">AEO管理</a>
    </li>

    @if(Entrust::can('wuliu.diags'))
        <li class="{{ $appPresenter->activeMenuByRoute(['wuliu']) }}">
            <a href="{{ route('wuliu.diags',[$item->id]) }}">物流风险管理</a>
        </li>
    @endif
    @if(Entrust::can('system.diags'))
        <li class="{{ $appPresenter->activeMenuByRoute(['system']) }}">
            <a href="{{ route('system.diags',[$item->id]) }}">系统化管理</a>
        </li>
    @endif
</ul>
</div>