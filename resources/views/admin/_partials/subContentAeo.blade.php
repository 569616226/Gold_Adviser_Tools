
<tr class="showtable">
    <td class="am-text-middle am-text-left">{!! html_entity_decode(stripslashes($diag_subContent->content))  !!}</td>
    <td class="am-text-middle">
        <!--查看状态，没有交互-->
        <div class="wentishow"  name="describle">
            @if($diag_subContent->describle == 0)
                达标
            @elseif($diag_subContent->describle == 1)
                不达标
            @elseif($diag_subContent->describle == 2)
                部分达标
            @elseif($diag_subContent->describle == 3)
                不适用
            @endif
        </div>
        <!--编辑状态，点击输入内容-->
        <div class="wentiedit">
            <select name="describle" class="br5px">
                @if($diag_subContent->describle == 0)
                    <option selected value="0">达标</option>
                    <option value="1">不达标</option>
                    <option value="2">部分达标</option>
                    <option value="3">不适用</option>
                @elseif($diag_subContent->describle == 1)
                    <option value="0">达标</option>
                    <option selected value="1">不达标</option>
                    <option value="2">部分达标</option>
                    <option value="3">不适用</option>
                @elseif($diag_subContent->describle == 2)
                    <option value="0">达标</option>
                    <option value="1">不达标</option>
                    <option selected value="2">部分达标</option>
                    <option value="3">不适用</option>
                @elseif($diag_subContent->describle == 3)
                    <option value="0">达标</option>
                    <option value="1">不达标</option>
                    <option value="2">部分达标</option>
                    <option selected value="3">不适用</option>
                @endif
            </select>
        </div>
    </td>
    <td class="am-text-middle">
        <div class="flyjshow">
            <!--查看状态，点击弹出查看模态框-->
            <div class="stcha" name="{{ $diag_subContent->id }}" onclick="flyjshowfun(this)">{{ $diag_subContent->law == '请选择' ? '暂无' : $diag_subContent->law }}</div>
        </div>
        <div class="flyjedit">
            <!--编辑状态，点击弹出编辑模态框-->
            <div class="stcha" name="{{ $diag_subContent->id }}" style="cursor: pointer;height: 100%;width: 100%" onclick="flyjeditfun(this)">&nbsp;{{ $diag_subContent->law }}</div>
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