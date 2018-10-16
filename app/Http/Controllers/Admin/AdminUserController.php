<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Functions;
use App\Models\AdminUser;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Repositories\AdminUserRepositoryEloquent;
use App\Http\Requests\Admin\AdminUser\CreateRequest;
use App\Http\Requests\Admin\AdminUser\UpdateRequest;
use Breadcrumbs, Toastr, Auth;
use Illuminate\Support\Facades\Hash;


class AdminUserController extends BaseController
{
    protected $adminUser;

    protected $adminUserRole;

    public function __construct(AdminUserRepositoryEloquent $adminUser)
    {
        parent::__construct();
        $this->adminUser = $adminUser;

        //        Breadcrumbs::setView('admin._partials.breadcrumbs');
        //
        //        Breadcrumbs::register('admin-user', function ($breadcrumbs) {
        //            $breadcrumbs->parent('dashboard');
        //            $breadcrumbs->push('用户管理', route('admin_user.index'));
        //        });

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $admin_users = AdminUser::where('id', '<>', Functions::getALId())->where('id','!=', 23)->latest()->paginate(15);
        $roles = Role::all();

        return view('admin.rbac.admin_users.index', compact('admin_users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.rbac.admin_users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $result = $this->adminUser->store($request->all());

        if( $result[ 'status' ] === false )
        {
            Toastr::error($result[ 'msg' ]);

        }else
        {
            Toastr::success('添加成功!');
        }

        return redirect('admin/admin_user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //        $users = AdminUser::where('id', '<>', $id)->latest()->paginate(15);
        //
        //        return view('admin.user.index',compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->adminUser->find($id);
        $roles = Role::all();

        return view('admin.rbac.admin_users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $result = $this->adminUser->update($request->all(), $id);
        if( $result[ 'status' ] === false )
        {
            Toastr::error($result[ 'msg' ]);
        }else
        {
            Toastr::success('更新成功');
        }

        return redirect(route('admin_user.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->adminUser->delete($id);

        $adminUserIds = $this->getDelAdminUserIds();
        $is_delete = in_array($id, $adminUserIds);

        if( $is_delete )
        {
            Toastr::success('删除成功');

        }else
        {
            Toastr::error('删除失败');
        }

        return redirect(route('admin_user.index'));
    }


    /**
     * Delete multi users
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyAll(Request $request)
    {


        if( !( $ids = $request->get('ids') ) )
        {
            return response()->json([ 'status' => 0, 'msg' => '请求参数错误' ]);
        }

        foreach( $ids as $id )
        {
            $this->adminUser->delete($id);
        }

        $adminUserIds = $this->getDelAdminUserIds();

        $is_delete = true;
        foreach( $ids as $id )
        {
            $is_delete = in_array($id, $adminUserIds);

            if( $is_delete )
            {//如果有账号没有删除，返回false
                continue;
            }else
            {
                $is_delete = false;
            }
        }

        return response()->json($is_delete ? [ 'status' => 1, 'msg' => '成功删除' ] : [ 'status' => 0, 'msg' => '删除失败' ]);
    }

    /*获取删除员工id集合*/
    public function getDelAdminUserIds()
    {
        $adminUserIds = Functions::getIds(AdminUser::withTrashed());

        return $adminUserIds;
    }


    /*重置密码*/
    public function resetPassword(Request $request)
    {
        $postData = $request->get('postdata');
        $password_old = $postData['password_old'];
        $password = $postData['password'];
        $password_confirmation = $postData['password_confirmation'];
        $admin_user = AdminUser::find(Functions::getALId());

        if(Hash::check($password_old, $admin_user->password)){

            if($password === $password_confirmation){

                $admin_user->password = bcrypt($password);
                $admin_user->update();

                $is_update = Functions::isUpdate($admin_user->updated_at);
                return response()->json($is_update ? ['status' => 1 ,'msg' => '密码修改成功' ] : ['status' => 0 ,'msg' => '密码修改' ]);
            }else{
                return response()->json(['status' => 0 , 'msg' => '两次输入的密码不一致，请重新输入' ]);
            }
        }else{
            return response()->json(['status' => 0 , 'msg' => '旧密码输入有误，请重新输入' ]);
        }
    }

    /*
     * 员工搜索
     *
     * */
    public function search(Request $request)
    {
        $str = $request->input('searchStr');

        $admin_users = AdminUser::where(function($query) use ($str)
        {
            $query->where('id', '<>', Functions::getALId())->where('id','!=',23)->where('name', 'like', '%'.$str.'%');
        })->orWhere(function($query) use ($str)
            {
                $query->where('id', '<>',Functions::getALId())->where('id','!=',23)->where('username', 'like', '%'.$str.'%');
            })->latest()->paginate(15);

        $roles = Role::all();

        return view('admin.rbac.admin_users.index', compact('admin_users', 'roles'));
    }

    /*
     * 检查员工用户名
     *
     * */
    public function checkAdminUser(Request $request)
    {
        $username = $request->get('username');

        $admin_user = AdminUser::where('username', $username)->get();

        return response()->json(count($admin_user) ? [ 'status' => 1 ] : [ 'status' => 0 ]);
    }

    /*冻结员工账号*/
    public function frozen($admin_user_id)
    {
        $admin_user = AdminUser::find($admin_user_id);
        $admin_user->active = 0;//active=0,冻结账号
        $admin_user->update();


        if( $admin_user->active == 0 )
        {
            Toastr::success('冻结成功');
        }else
        {
            Toastr::error('冻结失败');
        }

        return redirect(route('admin_user.index'));
    }

    /*冻结员工账号*/
    public function refrozen($admin_user_id)
    {

        $admin_user = AdminUser::find($admin_user_id);
        $admin_user->active = 1;//active = 1,解冻结账号
        $admin_user->update();

        if( $admin_user->active == 1 )
        {
            Toastr::success('解冻成功');
        }else
        {
            Toastr::error('解冻失败');
        }

        return redirect(route('admin_user.index'));
    }
}
