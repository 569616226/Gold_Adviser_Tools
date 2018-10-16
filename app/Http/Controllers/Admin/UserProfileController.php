<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Functions;
use App\Http\Requests\Admin\User\Depart\CreateRequest;
use App\Http\Requests\Admin\User\Depart\UpdateRequest;
use App\Models\Role;
use App\Models\UserDepart;
use App\User;
use Illuminate\Http\Request;
use Yuansir\Toastr\Facades\Toastr;

class UserProfileController extends BaseController
{
    /**
     * CustomerController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $user_id)
    {
        $username = $request->get('username');
        $name = $request->get('name');
        $password = bcrypt($request->get('password'));
        $roles = $request->get('roles');

        $de = new UserDepart();
        $de->username = $username;
        $de->name = $name;
        $de->password = $password;
        $de->user_id = $user_id;
        $de->save();

        /*判断是否新增成功*/
        $isSave = Functions::isCreate(UserDepart::all(),$de->id);

        if( $roles && $isSave )
        {
            $de->attachRoles($roles);
        }

        if( $isSave )
        {
            Toastr::success('新增成功');
        }else
        {
            Toastr::error('新增失败');
        }

        return redirect(route('depart.show', [ $user_id ]));
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
        $user = User::find($id);
        $roles = Role::where('display_name','like', '%客户%')->get();
        $departs = $user->user_departs()->latest()->paginate(15);


        return view('admin.user.depart.index', compact('departs', 'user', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $user_id)
    {
        $user = User::find($user_id);
        $roles = Role::where('display_name','like', '%客户%')->get();
        $depart = UserDepart::find($id);

        return view('admin.user.depart.edit', compact('depart', 'user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $user_id)
    {
        $name = $request->get('name');
        $password = bcrypt($request->get('password'));
        $roles = $request->get('roles');

        $de = UserDepart::find($id);
        $de->name = $name;
        $de->password = $password;
        $de->user_id = $user_id;
        $de->update();

        /*判断是更新在成功*/
        $is_update = Functions::isUpdate($de->updated_at);

        if( $is_update )
        {
            Toastr::success('更新成功');
        }else
        {
            Toastr::warning('更新失败');
        }

        $de->croles()->detach();

        if( count($roles) )
        {
            $de->attachRoles($roles);
        }

        return redirect(route('depart.show', [$user_id ]));
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $user_id)
    {
        UserDepart::find($id)->delete();

        $is_delete = Functions::isCreate(UserDepart::withTrashed(),$id);

        if( $is_delete )
        {
            Toastr::success('删除成功');
        }else
        {
            Toastr::error('删除失败');
        }

        return redirect(route('depart.show', [ $user_id ]));
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

        if( !count( $ids = $request->get('ids') ) )
        {
            return response()->json([ 'status' => 0, 'msg' => '请求参数错误' ]);
        }

        foreach( $ids as $id )
        {
            UserDepart::find($id)->delete();
        }

        $UserDepartIds = Functions::getIds(UserDepart::withTrashed());
        $delUserDepartCounts = array_intersect($UserDepartIds,$ids);

        return response()->json([ 'status' => 1, 'msg' => '成功删除'.count($delUserDepartCounts).'个账号']);
    }


    /*
    * 客户搜索
    *
    * */
    public function search(Request $request, $user_id)
    {
        $str = $request->input('searchStr');

        $departs = UserDepart::Where(function($query) use ($str, $user_id)
        {
            $query->where('id', '<>', Functions::getGLUser()->users->id)
                ->where('user_id', $user_id)
                ->where('username', 'like', '%'.$str.'%');
        })->latest()->paginate(15);

        $roles = Role::where('desplay_name','like', '%客户%')->get();
        $user = User::find($user_id);

        return view('admin.user.depart.index', compact('departs', 'user', 'roles'));
    }

    /*冻结客户子账号*/
    public function frozen($depart_id, $user_id)
    {
        $user = UserDepart::find($depart_id);
        $user->active = 0;//is_super=3,冻结账号
        $user->update();

        if( $user->active == 0 )
        {
            Toastr::success('冻结成功');
        }else
        {
            Toastr::error('冻结失败');
        }

        return redirect(route('depart.show', compact('user_id')));
    }

    /*解冻客户子账号*/
    public function refrozen($depart_id, $user_id)
    {

        $user = UserDepart::find($depart_id);
        $user->active = 1;//is_super=0,解冻结账号
        $user->update();

        if( $user->active == 1 )
        {
            Toastr::success('解冻成功');
        }else
        {
            Toastr::error('解冻失败');
        }

        return redirect(route('depart.show', compact('user_id')));
    }


}
