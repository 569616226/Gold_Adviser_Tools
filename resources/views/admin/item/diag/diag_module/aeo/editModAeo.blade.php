@extends('layouts.admin-app')
@section('title', '编辑模块管理')

@section('css')
	@parent
	<link rel="stylesheet" href="{{ url('css/main.css') }}">
		<style type="text/css">
			.tabs-child .am-nav-tabs,
			.tabs-child .am-tabs-bd,
			.tabs-child .am-nav-tabs>li.am-active>a {
				border: none;
			}
			
			table>tbody>tr.am-active>th {
				border-left: 1px solid #ddd;
			}
			
			.nav-child li.am-active a,
			.nav-child li.am-active a:hover,
			.nav-child li.am-active a:focus {
				background: none;
				color: #000;
			}
			
			.am-modal-bd {
				padding: 15px;
			}
		</style>
@endsection

@section('content')
<div class="dh-main">
	<div class="am-g">
		<div class="am-u-sm-3 am-u-md-3 am-u-lg-2 bgfff" id="leftNav">
					{{--左侧菜单--}}
					@include('admin._partials.item-left-menu')
				</div>
			<div class="am-u-sm-9 am-u-md-9 am-u-lg-10" id="rightMain">
					<div class="dh-main-container">
						{{--在线预览通用--}}
						@include('admin._partials.diag-preview')
						<div class="pro-card" style="padding: 1rem">
							<!--头部导航-->
							@include('admin._partials.diag-menu')
						</div>
						<div class="pro-card nav-child" style="background: #F7F7F7;padding: 1rem;position: relative; top: -14px;">
							<ul class="am-nav am-nav-pills fs14">
								@if(Entrust::can('guanwu.diags'))
									<li>
										<a href="{{ route('diags.edit',[$item->id,'guanwu']) }}">关务风险管理</a>
									</li>
								@endif
								@if(Entrust::can('aeo.diags'))
									<li class="am-active">
										<a href="{{ route('diags.edit',[$item->id,'aeo']) }}">AEO管理</a>
									</li>
								@endif
								@if(Entrust::can('wuliu.diags'))
									<li>
										<a href="{{ route('diags.edit',[$item->id,'wuliu']) }}">物流风险管理</a>
									</li>
								@endif
								@if(Entrust::can('system.diags'))
									<li>
										<a href="{{ route('diags.edit',[$item->id,'system']) }}">系统化管理</a>
									</li>
								@endif
							</ul>
						</div>
						<div class="pro-card am-margin-top-sm">
							<div style="overflow: hidden;" class="marginT30px">
								<i class="iconfont" style="color: #FF9800;">&#xe633;</i> 诊断结果具体分析
								<div>
									<!--关务风险-->
									<div class="paddlr20px" style="width: 100%;">
										<div class="am-tab-panel am-fade am-in am-active">
											<!--大模块-->
											<div class="bigm-card">
												<div class="am-margin-top">
													<h2 class="am-fl">AEO管理</h2>
													<div class="am-fr color888">
														<span>AEO管理负责人：</span>
														<span>{{ $diag_mod->master ? $diag_mod->master->name : '暂无' }}</span>
													</div>
													<div style="clear: both;"></div>
													<!--小模块-->
                                                    @include('admin._partials.submod')
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

@section('javascript')
@parent
    <script src="{{ url('js/main.js') }}" type="text/javascript" charset="utf-8"></script>
    <script>
        var all_diag_content_id = "";
        var conobj = ";"
        //查看状态点击查看法律法规
        function flyjshowfun(e) {
            var diag_content_id = $(e).attr("name");
            var url = '/admin/item/diags/'+ diag_content_id +'/law/see';
            AjaxJson(url,{},function(data){
                $("#law_content").html(data.html);
            });
            $("#flyjshow_modal").modal();
        }

        //可编辑状态点击选择法律法规
        function flyjeditfun(e) {
            all_diag_content_id = $(e).attr("name")
            var diag_content_id = $(e).attr("name");
            $("#editsub").attr("name",diag_content_id);
            var url = '/admin/item/diags/'+ diag_content_id +'/law';
            AjaxJson(url,{},function (data) {
                $("#selectchoose1").html("<option value=''>请选择</option>");
                $("#selectchoose1").append(data.namehtml);
                $("#selectchoose2").html("<option value=''>请选择</option>");
                $("#selectchoose2").append(data.title);
                $("#fgcheck_box").html(data.contenthtml);
                var checkstr = "";
                $('input[name="TTcheck"]:checked').each(function(){
                    checkstr += $(this).attr("data-val") + "、";
                });
                checkstr = checkstr.substr(0, checkstr.length - 1);
                $("#fgcontentinp").val(checkstr);
            });
            $("#flyjedit_modal").modal();
        }
        //点击编辑按钮
        function goEdit(e) {
            conobj = $(e).parents("tr");
            $(e).parents("tr").removeClass('showtable').addClass('edittable');
        }
        //点击提交按钮
        function goShow(e) {
            var diag_content_id = $(e).attr("name");
            var url = '/admin/item/diags/'+ diag_content_id +'/law/store';
            $(e).parents("tr").removeClass('edittable').addClass('showtable');
            var describle = $(e).parents("tr").find("select[name='describle']").val();
            var suggest = $(e).parents("tr").find("textarea[name='suggest']").val();
            AjaxJson(url,{'describle':describle,'suggest':suggest},function (data) {
                if(data.status == 1) {
                    var describelhtml = "";
                    if(data.describel == 0){
                        describelhtml = "达标"
                    };
                    if(data.describel == 1){
                        describelhtml = "不达标"
                    };
                    if(data.describel == 2){
                        describelhtml = "部分达标"
                    };
                    if(data.describel == 3){
                        describelhtml = "不适用"
                    };
                    $(e).parents("tr").find("div[name='describle']").html(describelhtml);
                    $(e).parents("tr").find("div[name='suggest']").html(data.suggest);
                    layer.msg(data.msg)
                } else {
                    layer.msg(data.msg)
                }
            });
        }

        //选择完法律法规（第一个选项框）之后的动作
        function selectchoose1fun(e){
            if($(e).val() != ""){
                var url = '/admin/item/diags/law/relatename';
                AjaxJson(url,{'name':$(e).val()},function(data){
                    console.log(data)
                    $("#selectchoose2").html("<option value=''>请选择</option>");
                    $("#selectchoose2").append(data.html);
    //						if(data.status == 1){
    //							//调用成功之后将返回来的数据循环到第二个选项框去
    //							//看接口返回数据，如果是返回html代码，就直接渲染进去，如果只返回数据，就循环后再插入
    //							//data.html----从后台返回来的第二个选框内容集
    //							$("#selectchoose2").html("<option value=''>请选择</option>");
    //                            $("#selectchoose2").append(data.html);
    //						}
                });
            }else {
                $("#selectchoose2").html("<option value=''>请选择</option>");
            }
        };
        //选择完法规条例文号（第二个选项框）之后的动作
        function selectchoose2fun(e){
            var url = '/admin/item/diags/law/relatetitle';
            if($(e).val() != ""){
                AjaxJson(url,{'title':$(e).val()},function(data){
                    console.log(data)
                    $("#fgcheck_box").html(data.html)
                })
            }else {
                $("#fgcheck_box").html("");
            }
        };


        $("#fgcheck_box").click(function () {
            var chk_value =[];
            //定义一个变量用来填充已经选择后的法规内容的输入框
            var checkstr = "";
            $('input[name="TTcheck"]:checked').each(function(){
                chk_value.push($(this).val());
                checkstr += $(this).attr("data-val") + "、";
            });
            checkstr = checkstr.substr(0, checkstr.length - 1);
            $("#fgcontentinp").val(checkstr);
        })


        $("#flyjedit_form").Validform({
            btnSubmit:'#editsub',
            tiptype: function (msgs, o, cssctl) {
                if (o.type != 2) {     //只有不正确的时候才出发提示，输入正确不提示
                    layer.msg(msgs);
                }
            },
            ajaxPost: false,//true用ajax提交，false用form方式提交
            tipSweep: true,//true只在提交表单的时候开始验证，false每输入完一个输入框之后就开始验证
            //点击提交按钮之后的动作
            beforeSubmit: function (curform) {
                var chk_values =[];
                //定义一个变量用来填充已经选择后的法规内容的输入框
                $('input[name="TTcheck"]:checked').each(function(){
                    chk_values.push($(this).val());
                });
                var diag_content_id =  $("#editsub").attr("name");
                var url = '/admin/item/diags/'+ diag_content_id +'/law/edit';
    //	                提交编辑的内容，然后从后台返回表格内的html代码动态插入
                if(chk_values==""){
                    layer.msg("请选择法规内容");
                    return false;
                };
                AjaxJson(url,{'law_ids':chk_values},function(data){
                    if(data.status == 1){
                        layer.msg(data.msg);
    //						    提交完之后更新法律依据内容
                        conobj.find(".stcha").html(data.laws)
                        $("#flyjedit_modal").modal('close');
                    }else {
                        layer.msg(data.msg)
                    }
                })
                return false;
            }
        });

    </script>
@endsection