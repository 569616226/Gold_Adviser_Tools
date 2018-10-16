@extends('layouts.app')
@section('title', '首页')

@section('content')
<main class="">
    <div class="Customeer-main">
        <img class="am-center am-margin-top-lg" src="{{ url('images/kuayitong.png') }} "/>
        <p class="am-text-center">尊敬的{{ Auth::user()->name }}，欢迎登录东华国际项目管理系统，您可以使用以下服务</p>
        <div class="am-padding-top">
            <a target="_blank" href="{{isset($item) && $item->material_active == 1 ? route('guest.material.preview',[$item->id]) : 'javascript:void(0);' }}" >
                {{--禁止的时候只要加上class  ‘ disable ’ 就可以了--}}
            <div class="server-card am-padding-top lan {{isset($item) && $item->material_active == 1 ? '' : 'disable' }}">
                <i class="iconfont fs44 colorw">&#xe630;</i>

                    <p class="colorw fs14">查看材料清单</p>

                <div class="colorw fs12">最近更新
                    @if(isset($item) && $item->material_active == 1)
                        <time>{{ $item->material_active_time->year }}年{{ $item->material_active_time->month }}月{{ $item->material_active_time->day }}日</time>
                    @else
                        <time >暂无报告</time>
                    @endif
                </div>
            </div>
            </a>

            <a target="_blank" href="{{isset($item) && $item->diag_active == 1 ? route('guest.diag.preview',[$item->id]) : 'javascript:void(0);' }}" >
            <div class="server-card am-padding-top huang {{isset($item) && $item->diag_active == 1 ? '' : 'disable' }}">
                <i class="iconfont fs44 colorw">&#xe66d;</i>
                <p class="colorw fs14">查看诊断报告</p>
                <div class="colorw fs12">最近更新
                    @if(isset($item) && $item->diag_active == 1)
                        <time>{{ $item->diag_active_time->year }}年{{ $item->diag_active_time->month }}月{{ $item->diag_active_time->day }}日</time>
                    @else
                        <time >暂无报告</time>
                    @endif
                </div>
            </div>
            </a>

            <a target="_blank" href="{{isset($item) && $item->improve_active == 1 ? route('guest.improve.preview',[$item->id]) : 'javascript:void(0);' }}" >
            <div class="server-card am-padding-top zi {{isset($item) && $item->improve_active == 1 ? '' : 'disable' }}">
                <i class="iconfont fs44 colorw">&#xe60e;</i>
                <p class="colorw fs14">查看实施计划</p>
                <div class="colorw fs12">最近更新
                    @if(isset($item) && $item->improve_active == 1)
                        <time>{{ $item->improve_active_time->year }}年{{ $item->improve_active_time->month }}月{{ $item->improve_active_time->day }}日</time>
                    @else
                        <time >暂无报告</time>
                    @endif
                </div>
            </div>
            </a>

            <a  href="{{isset($item) ?  route('guest.suggest.index',[$item->id]) : 'javascript:void(0);' }}" >
            <div class="server-card am-padding-top feng">
                <i class="iconfont fs44 colorw">&#xe612;</i>
                <p class="colorw fs14">服务评价</p>
                <div class="colorw fs12">
                    <time>您还有{{isset($item) && $item->suggestCount ? $item->suggestCount : 0 }}条服务未评价</time>
                </div>
                <span class="huizhang am-badge am-badge-danger am-round">{{isset($item) && $item->suggestCount ? $item->suggestCount : 0 }}</span>
            </div>
            </a>
        </div>
    </div>
</main>
@endsection