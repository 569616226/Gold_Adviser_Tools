@inject('appPresenter','App\Presenters\AppPresenter')
<nav class="dh-nav">
    <ul class="am-nav am-g">
        <li class="{{ $appPresenter->activeMenuByRoute(['home']) }} {{ Entrust::can('home.index') ? '' : 'am-hide'}}">
            <a href="{{ route('home.index') }}"><i class="iconfont">&#xe627;</i>主页</a>
        </li>

        <li class="{{ $appPresenter->activeMenuByRoute(['user','depart','handover']) }} {{ Entrust::can('user.index') ? '' : 'am-hide'}}">
            <a href="{{ route('user.index') }}"><i class="iconfont">&#xe68f;</i>客户管理</a>
        </li>

        <li class="{{ $appPresenter->activeMenuByRoute(['item']) }} {{ Entrust::can('item.index') ? '' : 'am-hide'}}">
            <a href="{{ route('item.index') }}"><i class="iconfont">&#xe611;</i>项目管理</a>
        </li>

        <li class="{{ $appPresenter->activeMenuByRoute(['role']) }} {{ Entrust::can('role.index') ? '' : 'am-hide'}}">
            <a href="{{ route('role.index') }}"><i class="iconfont">&#xe91c;</i>角色管理</a>
        </li>

        <li class="{{ $appPresenter->activeMenuByRoute(['admin_user']) }} {{ Entrust::can('admin_user.index') ? '' : 'am-hide'}}">
            <a href="{{ route('admin_user.index') }}"><i class="iconfont">&#xe605;</i>员工管理</a>
        </li>

        <li class="{{ $appPresenter->activeMenuByRoute(['permission']) }} {{ Entrust::can('permission.index') ? '' : 'am-hide'}}">
            <a href="{{ route('permission.index') }}"><i class="iconfont">&#xe60f;</i>权限管理</a>
        </li>

        <li class="{{ $appPresenter->activeMenuByRoute(['mech']) }} {{ Entrust::can('mech.index') ? '' : 'am-hide'}}">
            <a href="{{ route('mech.index') }}"><i class="iconfont">&#xe626;</i>审核机构</a>
        </li>

        <li class="{{ $appPresenter->activeMenuByRoute(['law']) }} {{ Entrust::can('law.index') ? '' : 'am-hide'}}">
            <a href="{{ route('law.index') }}"><i class="iconfont">&#xe8b2;</i>法律法规管理</a>
        </li>

        <li class="{{ $appPresenter->activeMenuByRoute(['template']) }} {{ Entrust::can('template.index') ? '' : 'am-hide'}}">
            <a href="{{ route('template.index') }}"><i class="iconfont">&#xe680;</i>模板管理</a>
        </li>
    </ul>
</nav>

