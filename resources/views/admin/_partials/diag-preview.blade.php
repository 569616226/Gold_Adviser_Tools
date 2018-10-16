<p class="title fs18">诊断报告
    @if(Entrust::can('diag.preview'))
        <a href="{{ route('diag.preview',[$item->id]) }}" target="_blank" class="am-fr am-btn am-btn-white br5px am-margin-left-xs">在线预览</a>
    @endif

    @if(Entrust::can('diag.export.word'))
    <a href="{{ route('diag.export.word',[$item->id]) }}" class="am-fr am-btn am-btn-white br5px am-margin-left-xs">导出</a>
    @endif

    @if(Entrust::can('diag.preview.active'))
    <a href="{{ route('diag.preview.active',[$item->id]) }}" class="am-fr am-btn am-btn-white br5px am-margin-left-xs">
        交付客户
    </a>
    @endif
</p>