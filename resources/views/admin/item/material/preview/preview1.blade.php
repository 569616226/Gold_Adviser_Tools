@extends('layouts.admin-preview')
@section('title', '材料清单预览')

@section('content')
    <body>
    <header class="am-topbar dh-header bgfff" style="margin-bottom: 0;">
        <div class="am-g">
            <div class="am-u-sm-3 am-u-md-3 am-u-lg-2 dh-header-left bgkynav">
                <img src=" {{ url('images/donghua.png') }}"/>
            </div>
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10 dh-header-right bgfff box-shadow-black">
                <p style="line-height: 50px;"><i class="iconfont color639">&#xe613;</i><span class="am-margin-left-lg">{{ $item->hands->users->name }}
                        诊断前需提前准备的材料清单</span></p>
            </div>
        </div>
    </header>

    <div class="dh-main bgfff">
        <div class="am-g heightMax">
            <div class="am-u-sm-3 am-u-md-3 am-u-lg-2 bgkynav" id="leftNav">
                <nav class="dh-nav dhkh-nav">
                    <ul class="am-nav am-g">
                        <div class="lindiv" style="background: #292E47;"></div>
                        <li class=" am-padding-left-lg">
                            <a href="{{ route('material.preview',[$item->id]) }}">清单封面</a>
                        </li>
                        <li class="am-active am-padding-left-lg">
                            <a href="{{ route('material.preview.msg',[$item->id])}}">清单信息</a>
                        </li>
                        <li class="am-padding-left-lg">
                            <a href="{{ route('material.preview.data',[$item->id]) }}">审核所涉及的资料</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10 heightMax am-padding-0" id="rightMain">
                <div class="dh-main-container heightMax">
                    <div class="am-margin-top-lg">
                        <h2 class="am-padding-left-lg">{{ $item->hands->users->name }} 供应链定制化服务风险诊断审核清单</h2>
                        <table class="am-table">
                            <tr>
                                <td width="120px" class="am-text-right color888">审核项目：</td>
                                <td>{{ $item->hands->name }}</td>
                            </tr>
                            <tr>
                                <td width="120px" class="am-text-right color888">审核地点：</td>
                                <td>{{ $item->hands->users->address }}</td>
                            </tr>

                        </table>
                    </div>
                    <div class="am-margin-top-lg">
                        <p class="am-padding-left-lg fs20 lanbefore">审核机构</p>
                        <table class="am-table">
                            <tr>
                                <td width="120px" class="am-text-right color888">机构名称：</td>
                                <td>{{ $item->hands->meches->name }}</td>
                                <td width="120px" class="am-text-right color888">通讯地址：</td>
                                <td>{{ $item->hands->meches->address }}</td>
                                <td width="120px" class="am-text-right color888">邮政编码：</td>
                                <td>{{ $item->hands->meches->zip_code }}</td>
                            </tr>
                            <tr>
                                <td width="120px" class="am-text-right color888">负责人：</td>
                                <td>{{ $item->hands->meches->master }}</td>
                                <td width="120px" class="am-text-right color888">负责人电话：</td>
                                <td>{{ $item->hands->meches->master_tel }}</td>
                                <td width="120px" class="am-text-right color888">负责人传真：</td>
                                <td>{{ $item->hands->meches->master_fax }}</td>
                            </tr>
                            <tr>
                                <td width="120px" class="am-text-right color888">项目督导：</td>
                                <td>{{ $item->hands->meches->super }}</td>
                                <td width="min-120px" class="am-text-right color888">项目督导电话：</td>
                                <td>{{ $item->hands->meches->super_tel }}</td>
                                <td width="min-120px" class="am-text-right color888">项目督导传真：</td>
                                <td>{{ $item->hands->meches->super_fax }}</td>
                            </tr>
                            <tr>
                                <td width="120px" class="am-text-right color888">审核团队：</td>
                                <td>{{ $item->hands->meches->verify_team }}</td>
                                <td width="120px" class="am-text-right color888">电子邮箱：</td>
                                <td colspan="3">{{ $item->hands->meches->email }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection