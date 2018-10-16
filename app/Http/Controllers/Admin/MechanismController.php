<?php
/*
 * 审核机构
 * */

namespace App\Http\Controllers\Admin;

use App\Helpers\Functions;
use App\Http\Requests\Admin\Mech\CreateRequest;
use App\Http\Requests\Admin\Mech\UpdateRequest;
use App\Models\Mech;
use Illuminate\Http\Request;
use Yuansir\Toastr\Facades\Toastr;

class MechanismController extends BaseController
{
    /**
     * CustomerController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mechs = Mech::latest()->paginate(15);

        return view('admin.mech.index', compact('mechs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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

        $name = $request->input('name');
        $address = $request->input('address');
        $zip_code = $request->input('zip_code');
        $master = $request->input('master');
        $master_tel = $request->input('master_tel');
        $master_fax = $request->input('master_fax');
        $super = $request->input('super');
        $super_tel = $request->input('super_tel');
        $super_fax = $request->input('super_fax');
        $email = $request->input('email');
        $verify_team = $request->input('verify_team');

        $mech = new Mech();
        $mech->name = $name;
        $mech->address = $address;
        $mech->zip_code = $zip_code;
        $mech->master = $master;
        $mech->master_tel = $master_tel;
        $mech->master_fax = $master_fax;
        $mech->super = $super;
        $mech->super_tel = $super_tel;
        $mech->super_fax = $super_fax;
        $mech->email = $email;
        $mech->verify_team = $verify_team;
        $mech->save();

        /*判断是否存在成功*/
        $isSave =  Functions::isCreate(Mech::all(),$mech->id);

        if( $isSave )
        {
            Toastr::success('新增成功');
        }else
        {
            Toastr::error('新增失败');
        }

        return redirect(route('mech.index'));

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
        $mech = Mech::find($id);

        return view('admin.mech.edit', compact('mech'));
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
        $name = $request->input('name');
        $address = $request->input('address');
        $zip_code = $request->input('zip_code');
        $master = $request->input('master');
        $master_tel = $request->input('master_tel');
        $master_fax = $request->input('master_fax');
        $super = $request->input('super');
        $super_tel = $request->input('super_tel');
        $super_fax = $request->input('super_fax');
        $email = $request->input('email');
        $verify_team = $request->input('verify_team');

        $mech = Mech::find($id);
        $mech->name = $name;
        $mech->address = $address;
        $mech->zip_code = $zip_code;
        $mech->master = $master;
        $mech->master_tel = $master_tel;
        $mech->master_fax = $master_fax;
        $mech->super = $super;
        $mech->super_tel = $super_tel;
        $mech->super_fax = $super_fax;
        $mech->email = $email;
        $mech->verify_team = $verify_team;
        $mech->update();

        /*判断是更新在成功*/
        $is_update = Functions::isUpdate($mech->updated_at);

        if( $is_update )
        {
            Toastr::success('更新成功');
        }else
        {
            Toastr::warning('更新失败');
        }

        return redirect(route('mech.index'));
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
        Mech::find($id)->delete();

        /*删除机构id集合*/
        $is_delete = Functions::isCreate(Mech::withTrashed(),$id);

        if( $is_delete )
        {
            Toastr::success('删除成功');
        }else
        {
            Toastr::error('删除失败');
        }

        return redirect(route('mech.index'));
    }

    /*
     * 审核机构搜索
     *
     * */
    public function search(Request $request)
    {
        $str = $request->input('searchStr');

        $mechs = Mech::where('name', 'like', '%'.$str.'%')
            ->orWhere('master', 'like', '%'.$str.'%')
            ->orWhere('verify_team', 'like', '%'.$str.'%')
            ->latest()
            ->paginate(15);

        return view('admin.mech.index', compact('mechs'));
    }

    /*
    * 审核机构名检查
    *
    * */
    public function checkMechs(Request $request)
    {
        $name = $request->get('name');
        $mechs = Mech::where('name', $name)->get();

        return response()->json(count($mechs) ? [ 'status' => 1, 'msg' => '机构名称已经存在' ] : [ 'status' => 0 ]);
    }


}
