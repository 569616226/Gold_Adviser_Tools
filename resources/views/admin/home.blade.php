@extends('layouts.admin-app')
@section('title', '首页')

@section('css')
	@parent
	<link rel="stylesheet" href=" {{ url('/css/main.css') }}">
  <style type="text/css">
	.am-selected.am-active,.am-selected.am-active:hover,.am-selected.am-active:active,.am-selected.am-active:focus{
			border-color: #e6e6e6 !important;
			border: 1px solid !important;
			border-radius: 5px;
		}
		.am-btn-default:hover,
		.am-btn-default:focus,
		.am-btn-default:active,
		.am-btn-default.am-active,
		.am-dropdown.am-active .am-btn-default.am-dropdown-toggle {
		  color: #444;
		  border: 1px solid !important;
		  border-color: #e6e6e6 !important;
		}
		.chakan-modal-dialog {
			width: 1060px;
		}
		.chakan-modal-dialog.am-modal-dialog [class*=am-u-]{
			padding-left: 1rem !important;
		}
		.chakan-modal-dialog.am-modal-dialog .am-u-sm-2 {
			text-align: right;
		}
		p.title button{
			margin-right: 20px;
		}
		.am-dropdown-content, ul.contents>li>a{
			padding: 0;
			min-width: 100px;
		}
  </style>
@endsection

@section('content')
<div class="dh-main">
	<div class="am-g">
		<div class="am-u-sm-3 am-u-md-3 am-u-lg-2 bgfff" id="leftNav">
			<!--右侧菜单-->
			@include('admin._partials.rbac-left-menu')
		</div>
		<div class="am-u-sm-9 am-u-md-9 am-u-lg-10" id="rightMain">
				<!--项目概况-->
				<div class="dh-main-container">
					 <div class="pro-card am-text-center index-main">
					 	<p class="fs20">尊敬的 <span>{{ $username }}</span>，欢迎使用金牌顾问项目管理系统！</p>
					 	<img class="am-margin-top-lg" src=" {{ url('images/index.png') }}" alt="" />
					 	<div class="href-box">
					 		<p>内部系统连接</p>
					 		<div>
					 			<a target="_blank" class="am-margin-right color888" href="http://www.elinkport.com/ ">东华国际官网</a>
					 			|
					 			<a target="_blank" class="am-margin-right am-margin-left color888" href="https://mail.elinkport.com/mail/">东华国际邮件系统</a>
					 			|
					 			<a target="_blank" class="am-margin-right am-margin-left color888" href="http://ent.elinkport.com/Login/Index">跨易通供应链管理系统-企业版</a>
					 			|
					 			<a target="_blank" class="am-margin-left color888" href="http://vip.elinkport.com/login">东华国际项目管理系统-客户版</a>
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
@endsection