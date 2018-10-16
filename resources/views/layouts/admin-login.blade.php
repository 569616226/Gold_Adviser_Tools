<html>
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <title>东华国际项目管理系统</title>
    <link rel="stylesheet" type="text/css" href="/../css/amazeui.min.css"/>
    <link rel="stylesheet" type="text/css" href="/../css/main.css"/>
    <link rel="stylesheet" type="text/css" href="/../js/icheck/skins/icheck-all.css"/>
</head>
<body>
@yield('content')



@section('javascript')
</body>
<script src="/../js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/../js/amazeui.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/../js/icheck/icheck.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/../js/layer/layer.js" type="text/javascript" charset="utf-8"></script>
<script src="/../js/validform/js/Validform_v5.3.2_min.js" type="text/javascript" charset="utf-8"></script>
<script src="/../js/main.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat'
        });
    });
    $("#loginform").Validform({
        tiptype: function (msgs, o, cssctl) {
            if (o.type != 2) {     //只有不正确的时候才出发提示，输入正确不提示
                layer.msg(msgs);
            }
        },
        ajaxPost: false,//true用ajax提交，false用form方式提交
        tipSweep: true,//true只在提交表单的时候开始验证，false每输入完一个输入框之后就开始验证
        //ajax提交完之后的回调函数
        callback: function (rq) {

        }
    });
</script>
{!! Toastr::render() !!}
@show

</html>
