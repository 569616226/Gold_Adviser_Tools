$(function() {
    // 返回顶部，绑定gotop1图标和gotop2文字事件
    $("#gotop1,#gotop2").click(function(e) {
        TweenMax.to(window, 1.5, {scrollTo:0, ease: Expo.easeInOut});  //1.5是返回顶部所花的时间
        var huojian = new TimelineLite();
        huojian.to("#gotop1", 1, {rotationY:720, scale:0.6, y:"+=40", ease:  Power4.easeOut})
            .to("#gotop1", 1, {y:-1000, opacity:0, ease:  Power4.easeOut}, 0.6)
            .to("#gotop1", 1, {y:0, rotationY:0, opacity:1, scale:1, ease: Expo.easeOut, clearProps: "all"}, "1.4");
    });
});
$(window).scroll(function(){
// 滚动条距离顶部的距离 大于 200px时
    if($(window).scrollTop() >= 100){
        $("#gotop1").fadeIn(1000); // 开始淡入
    } else{
        $("#gotop1").stop(true,true).fadeOut(1000); // 如果小于等于 200 淡出
    }
});
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
//请求Ajax 带返回值
function AjaxText(url, postData, callBack) {
    $.ajax({
        type: 'post',
        dataType: "text",
        url:url,
        data: postData,
        cache: false,
        async: true,
        success: function (data) {
            callBack(data);
        },
        error: function (data) {
            console.log(data);
            console.log('跳入了error');
        }
    });
}

function AjaxJson(url, postData, callBack) {
    $.ajax({
        url:url,
        type: "post",
        data: postData,
        dataType: "json",
        async: true,
        success: function (data) {
            callBack(data);
        },
        error: function (data) {
            console.log(data);
            console.log('跳入了error');
        }
    });
}


//获取已经勾选上的复选框的值  name: 复选框的name值   返回一段以数组
function CheckboxValshu(name) {
    var reVal = [];
    $("input[name =" + name + "]:checked").each(function () {
        reVal.push($(this).val())
    });
    return reVal;
}
function hiddenboxValshu(name) {
    var reVal = [];
    $("input[name =" + name + "]").each(function () {
        reVal.push($(this).val())
    });
    return reVal;
}

//获取已经勾选上的复选框的值  name: 复选框的name值   返回一段以","隔开的字符串
function CheckboxVal(name) {
    var reVal = '';
    $("input[name =" + name + "]:checked").each(function () {
        reVal += $(this).val() + ",";
    });
    reVal = reVal.substr(0, reVal.length - 1);
    return reVal;
}

// 自动获取页面控件值
function GetWebControls(element) {
    var reVal = "";
    $(element).find('input,textarea,select').each(function (r) {
        var name = $(this).attr('name');
        var value = iGetInnerText($(this).val());
        reVal += '"' + name + '"' + ':' + '"' + $.trim(value) + '",'
    });
    reVal = reVal.substr(0, reVal.length - 1);
    return jQuery.parseJSON('{' + reVal + '}');
}
// 自动给控件赋值
function SetWebControlshtml(data) {
    for (var key in data) {
        var id = $('#' + key);
        var value = $.trim(data[key]);
        id.html(value =='' ? value='&nbsp': value = value);
    }}
//Json拼接
function JsonInsert(json1, json2) {
    var a = json1;
    var b = json2;
    for (var tem in b) {
        a[tem] = b[tem];
    }
    return a;
}
//去掉换行符，空格，回车
function iGetInnerText(testStr) {
    // var resultStr = testStr.replace(/\ +/g, ""); //去掉空格
    resultStr = testStr.replace(/[ ]/g, "");    //去掉空格
    resultStr = testStr.replace(/[\r\n]/g, ""); //去掉回车换行
    return resultStr;
}
//输入框禁止输入特殊字符
$("input").each(function (index) {
    $(this).keyup(function (e) {
        replaceAndSetPos(this, ':', '：')
    })
});
$("textarea").each(function (index) {
    $(this).keyup(function (e) {
        replaceAndSetPos(this, ':', '：');
    })
});
//解决使用replace光标跳动的方法----------------定位光标和替换待优化
/*获取光标位置*/
function getCursorPos(obj) {
    var CaretPos = 0;
    // IE Support
    if (document.selection) {
        obj.focus(); //获取光标位置函数
        var Sel = document.selection.createRange();
        Sel.moveStart('character', -obj.value.length);
        CaretPos = Sel.text.length;
    }
    // Firefox/Safari/Chrome/Opera support
    else if (obj.selectionStart || obj.selectionStart == '0')
        CaretPos = obj.selectionEnd;
    return (CaretPos);
}
/*
 定位光标
 */
function setCursorPos(obj, pos) {
    if (obj.setSelectionRange) { //Firefox/Safari/Chrome/Opera
        obj.focus(); //
        obj.setSelectionRange(pos, pos);
    } else if (obj.createTextRange) { // IE
        var range = obj.createTextRange();
        range.collapse(true);
        range.moveEnd('character', pos);
        range.moveStart('character', pos);
        range.select();
    }
}

/*
 替换后定位光标在原处,可以这样调用onkeyup=replaceAndSetPos(this,/[^/d]/g,'');
 */
function replaceAndSetPos(obj, pattern, text) {
    /*if(event.shiftKey||event.altKey||event.ctrlKey||event.keyCode==16||event.keyCode==17||event.keyCode==18||(event.shiftKey&&event.keyCode==36))
     return; */
    var pos = getCursorPos(obj); //保存原始光标位置
    var temp = obj.value; //保存原始值
    obj.value = temp.replace(pattern, text); //替换掉非法值
    //截掉超过长度限制的字串（此方法要求已设定元素的maxlength属性值）
    var max_length = obj.getAttribute ? parseInt(obj.getAttribute("maxlength")) : "";
    if (obj.value.length > max_length) {
        //法一：obj.value = obj.value.substring( 0,max_length);若用户在中间进行输入，此方法则达不到效果
        //法二：可以满足任何情况（当超过输入了，去掉新输入的字符）
        var str1 = obj.value.substring(0, pos - 1);
        var str2 = obj.value.substring(pos, max_length + 1);
        obj.value = str1 + str2;
        /*法三：在支持keycode等一系列的情况下使用
         var e=e||event;
         currKey=e.keyCode||e.which||e.charCode;
         currKey = 0;
         或
         window.onkeydown=function(){
         if( event.keyCode!=37 && event.keyCode!=39 && event.keyCode!=8 )// 左、右、删除
         { return false; }
         }*/
    }
    pos = pos - (temp.length - obj.value.length); //当前光标位置
    setCursorPos(obj, pos); //设置光标
}



//设置最大高度，最小高度
(function($){
    $.fn.autoTextarea = function(options) {
        var defaults={
            maxHeight:null,
            minHeight:$(this).height()
        };
        var opts = $.extend({},defaults,options);
        return $(this).each(function() {
            $(this).bind("paste cut keydown keyup focus blur",function(){
                var height,style=this.style;
                this.style.height = opts.minHeight + 'px';
                if (this.scrollHeight > opts.minHeight) {
                    if (opts.maxHeight && this.scrollHeight > opts.maxHeight) {
                        height = opts.maxHeight;
                        style.overflowY = 'scroll';
                    } else {
                        height = this.scrollHeight;
                        style.overflowY = 'hidden';
                    }
                    style.height = height + 'px';
                }
            });
        });
    };
})(jQuery);
$("textarea").autoTextarea({
    maxHeight:400,
    minHeight:35
});
var indexlayerLoad;
// 隐藏
function Todisable(e) {
    $(e).css("display","none");
}
//显示
function Toable(e) {
    $(e).attr("display","inline-block");
}

function openLoad(e) {
    // indexlayerLoad = layer.load(1, {
    //     shade: [0.4,'#000'] //0.1透明度的白色背景
    // });
    indexlayerLoad = layer.open({
        type: 3,
        content: '<div id="preloader_2"> <span></span> <span></span> <span></span> <span></span></div>',
        shade: [0.4,'#000']
    });
}
function closeLoad (e) {
    layer.close(indexlayerLoad);
}

$('#leftNav').niceScroll({
    cursorcolor: "#ccc",//#CC0071 光标颜色
    cursoropacitymax: 0, //改变不透明度非常光标处于活动状态（scrollabar“可见”状态），范围从1到0
    touchbehavior: false, //使光标拖动滚动像在台式电脑触摸设备
    cursorwidth: "1px", //像素光标的宽度
    cursorborder: "0", // 游标边框css定义
    cursorborderradius: "5px",//以像素为光标边界半径
    autohidemode: false //是否隐藏滚动条
});
//
// $('html').niceScroll({
//     cursorcolor: "#ccc",//#CC0071 光标颜色
//     cursoropacitymax: 0.6, //改变不透明度非常光标处于活动状态（scrollabar“可见”状态），范围从1到0
//     touchbehavior: false, //使光标拖动滚动像在台式电脑触摸设备
//     cursorwidth: "10px", //像素光标的宽度
//     cursorborder: "0", // 游标边框css定义
//     cursorborderradius: "5px",//以像素为光标边界半径
//     autohidemode: false //是否隐藏滚动条
// });
