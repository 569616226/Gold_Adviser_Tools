
<tr class="showtable">
    <td class="am-text-middle am-text-left">{!! html_entity_decode(stripslashes($diag_subContent->content))  !!} </td>
    <td class="am-text-middle am-text-left">
        <!--查看状态，没有交互-->
        <div class="wentishow" name="describle">{{ $diag_subContent->describle }}</div>
        <!--编辑状态，点击输入内容-->
        <div class="wentiedit">
            <textarea name="describle" placeholder="请输入">{{ $diag_subContent->describle }}</textarea>
        </div>
    </td>
    <td class="am-text-middle">
        <div class="flyjshow">
            <!--查看状态，点击弹出查看模态框-->
            <div class="stcha" name="{{ $diag_subContent->id }}" onclick="flyjshowfun(this)">{{ $diag_subContent->law == '请选择' ? '暂无' : $diag_subContent->law }}</div>
        </div>
        <div class="flyjedit">
            <!--编辑状态，点击弹出编辑模态框-->
            <div class="stcha" name="{{ $diag_subContent->id }}" style="cursor: pointer;height: 100%;width: 100%" onclick="flyjeditfun(this)">{{ $diag_subContent->law }}</div>
        </div>
    </td>
    <td class="am-text-middle am-text-left">
        <div class="jianyishow">
            <!--查看状态，没有交互-->
            <div name="suggest">{{ $diag_subContent->suggest }}</div>
        </div>
        <div class="jianyiedit">
            <!--编辑状态，点击输入内容-->
            <textarea name="suggest" placeholder="请输入">{{ $diag_subContent->suggest }}</textarea>
        </div>
    </td>
    <td class="am-text-middle">
        <a onclick="goEdit(this)" href="javascript:void(0);" class="goEditbtn am-btn am-btn-primary br5px" name="{{ $diag_subContent->id }}">编辑</a>
        <a onclick="goShow(this)" href="javascript:void(0);" class="goShowbtn am-btn am-btn-warning br5px" name="{{ $diag_subContent->id }}">提交</a>
        <a onclick="godisShow(this)" href="javascript:void(0);" class="goShowbtn am-btn am-btn-white br5px" name="{{ $diag_subContent->id }}">取消</a>
    </td>
</tr>
<script>
    function godisShow(e) {
        $(e).parents("tr").removeClass('edittable').addClass('showtable');
        $(e).parents("tr").find("textarea[name='describle']").val("");
        $(e).parents("tr").find("textarea[name='suggest']").val("");
    }
</script>
