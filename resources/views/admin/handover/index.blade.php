@extends('layouts.admin-handover')
@section('title', '交接单')

@section('content')
    <style>
        .advice-text p{
            margin: 0;
            padding: 0;
        }
    </style>
    <div class="bgfff" style="margin: 30px 70px;">
        <p class="am-text-center fs28 paddt30px paddb20px">{{ $hand->name }} 项目交接单</p>
        <div class="lindiv pa1010"></div>
        <table class="am-table pa1010 tablejichu">
            <p class="am-text-right fs20" style="width: 25%;">项目基本信息</p>
            <tr>
                <td width="20%" class="am-text-right color888">项目负责人:</td>
                <td width="30%">{{ $hand->meches->master }}</td>
                <td width="20%" class="am-text-right color888">合同编号:</td>
                <td width="30%">{{ $hand->handover_no }}</td>
            </tr>
            <tr>
                <td class="am-text-right color888">项目名称:</td>
                <td >{{ $hand->name }}</td>
                <td class="am-text-right color888">项目服务部门:</td>
                <td>{{ $hand->meches->verify_team }}</td>
            </tr>
            <tr>
                <td class="am-text-right color888">项目有效期:</td>
                <td>{{ $hand->end_time }}</td>
            </tr>
            <tr>
                <td class="am-text-right color888">客户公司名称:</td>
                <td>{{ $hand->users->name }}</td>
                <td class="am-text-right color888">负责人电话:</td>
                <td>{{ $hand->users->tel }}</td>
            </tr>
            <tr>
                <td class="am-text-right color888">客户公司地址:</td>
                <td colspan="3">{{ $hand->users->address }}</td>
            </tr>
            <tr>
                <td class="am-text-right color888">项目描述:</td>
                <td colspan="3">
                    <div class="advice-text" style="margin-left: 0;">{!! html_entity_decode(stripslashes($hand->description)) !!}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="bgfff paddt30px pa1010 paddb30px" style="margin: 30px 70px 80px 70px;">
        <table class="am-table am-table-bordered am-table-centered tablekh" style="margin-left: 10%;width: 90%">
            <p class="am-text-right fs20" style="width: 18%;">客户联系资料</p>
            <tr class="trhe">
                <td>负责人</td>
                <td>职务</td>
                <td>电话</td>
                <td>固话</td>
                <td>邮件</td>
            </tr>
            @foreach($hand->contacts as $contact)
                <tr>
                    <td>{{ $contact->contacter}}</td>
                    <td>{{ $contact->business}}</td>
                    <td>{{ $contact->phone}}</td>
                    <td>{{ $contact->wechat}}</td>
                    <td>{{ $contact->email}}</td>
                </tr>
            @endforeach
        </table>
        <p class="am-text-right fs20" style="width: 18%;">营销中心建议：</p>
        <div class="advice-text {{isset($hand->suggest) && $hand->suggest == '' ? 'am-hide' :'a' }}">{{ $hand->suggest }}</div>
    </div>

    <footer class="am-topbar-fixed-bottom bgfff pa1010">
        <div style="padding-top: 8px;">
            <p class="am-fl pad" style="position: relative; top: 4px;"><span>{{ $hand->name }}</span><span>项目交接单</span>
            </p>
            <div class="am-fr">
                <a href="{{ route('handover.edit',[$user->id]) }}" class="am-btn am-btn-primary br5px {{ Entrust::can('handover.edit') ? : 'am-hide' }}">修改交接单</a>

                <a href="{{Entrust::can('user.index') ? route('user.index') : route('item.index') }}" class="am-btn am-btn-white br5px ">返回</a>
            </div>
        </div>
    </footer>
@endsection

@section('javascript')
    @parent
@endsection
