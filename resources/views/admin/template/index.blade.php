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
    {{--<div class="dh-main">--}}
       {{--<ul>--}}
           {{--@foreach($maters as $mater)--}}
           {{--<li><a href="{{route('template.material',[$mater->id])}}">{{ $mater->material_template_name }}</a></li>--}}
           {{--@endforeach--}}
           {{--<li><a href="{{ route('template.guanwu') }}">诊断报告模板管理</a></li>--}}
       {{--</ul>--}}
    {{--</div>--}}
    <div class="dh-main">
        <div class="am-g">
            <div class="am-u-sm-3 am-u-md-3 am-u-lg-2 bgfff" id="leftNav">
                @include('admin._partials.rbac-left-menu')
            </div>
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10" id="rightMain">
                <!--项目概况-->
                <div class="dh-main-container">
                    <p class="title fs18">模板管理</p>
                    <div class="pro-card am-text-center br5px" style="min-height: 530px">
                        <p class="am-text-center am-text-lg am-margin-top-lg">请选择你要管理的模板</p>
                        @foreach($maters as $mater)
                        <a href="{{route('template.material',[$mater->id])}}">
                            <div class="tpl-card lan">
                                <i class="iconfont">&#xe630;</i>
                                <p class="colorw">{{ $mater->name }}</p>

                            </div>
                        </a>
                        @endforeach
                        <a href="{{ route('template.guanwu') }}">
                            <div class="tpl-card hong">
                                <i class="iconfont">&#xe66d;</i>
                                <p class="colorw">诊断报告模板管理</p>
                            </div>
                        </a>
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