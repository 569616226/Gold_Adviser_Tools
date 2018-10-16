@inject('appPresenter','App\Presenters\AppPresenter')
<style>
    .new-tabs-box li.am-active a:after {
        bottom: -1px;
    }
</style>
<p class="title" style="margin-top: -10px"><a href="{{ route('template.index') }}"><i class="iconfont">&#xe604;</i></a> 诊断报告模板管理</p>
<div class="pro-card nav-child" style="background: #F7F7F7;padding: 1rem;position: relative; top: -14px;">
<ul class="am-nav am-nav-pills fs14">
    @if(Entrust::can('guanwu.diags'))
        <li class="{{ $appPresenter->activeMenuByRoute(['guanwu']) }}">
            <a href="{{ route('template.guanwu') }}">关务风险管理</a>
        </li>
    @endif
    @if(Entrust::can('aeo.diags'))
        <li class="{{ $appPresenter->activeMenuByRoute(['aeo']) }}">
            <a href="{{ route('template.aeo') }}">AEO管理</a>
        </li>
    @endif
    @if(Entrust::can('wuliu.diags'))
        <li class="{{ $appPresenter->activeMenuByRoute(['wuliu']) }}">
            <a href="{{ route('template.wuliu') }}">物流风险管理</a>
        </li>
    @endif
    @if(Entrust::can('system.diags'))
        <li class="{{ $appPresenter->activeMenuByRoute(['system']) }}">
            <a href="{{ route('template.system') }}">系统化管理</a>
        </li>
    @endif
</ul>
</div>