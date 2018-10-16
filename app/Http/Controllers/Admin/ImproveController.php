<?php
/*
 * 改善实施计划
 * */

namespace App\Http\Controllers\Admin;

use App\Helpers\Functions;
use App\Models\AdminUser;
use App\Models\ImproveTitle;
use App\Models\ImproveTitleTem;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yuansir\Toastr\Facades\Toastr;

class ImproveController extends BaseController
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
    public function index($item_id)
    {
        $item = Item::find($item_id);
        $fuser = AdminUser::find($item->fid);
        $creater = AdminUser::find($item->create_id);//项目创建者
        $creater->office = Functions::getRoleName($creater);

        /** 排序按角色是否是经理排序* */
        $teamers = Functions::orderAdminUsers($item, 'left');

        /*用户是否有查看此功能的权限*/
        $is_see = $this->getIsSee($item);

        if($item->improve_startDate)
        {
            $improves = ImproveTitleTem::all();
            foreach($improves as $improve_title_tem){
                foreach($improve_title_tem->improve_list_tems as $improve_list_tem){
                    foreach($improve_list_tem->improve_con_tems as $improve_con_tem){
                        $is_task = $improve_con_tem->tasks->where('item_id',$item_id)->isEmpty();
                        if(!$is_task){
                            $improve_con_tem->start_date = $improve_con_tem->tasks->where('item_id',$item_id)->first()->start_date->toDateString();
                            $improve_con_tem->end_date = $improve_con_tem->tasks->where('item_id',$item_id)->first()->end_date->toDateString();
                            $improve_con_tem->master = AdminUser::find($improve_con_tem->tasks->where('item_id',$item_id)->first()->admin_user_id)->name;
                            $improve_con_tem->remark = $improve_con_tem->tasks->where('item_id',$item_id)->first()->remark;
                            if($improve_con_tem->tasks->where('item_id',$item_id)->first()->type == 1){
                                $improve_con_tem->type = '电话服务';
                            }elseif($improve_con_tem->tasks->where('item_id',$item_id)->first()->type == 0){
                                $improve_con_tem->type = '下厂服务';
                            }
                        }else{
                            $improve_con_tem->start_date = '';
                            $improve_con_tem->end_date = '';
                            $improve_con_tem->master = '';
                            $improve_con_tem->type = '';
                            $improve_con_tem->remark = '';
                        }
                    }
                }
            }

            return view('admin.item.improve.index', compact('item', 'fuser', 'creater', 'improves','teamers','is_see'));
        }else{
            return view('admin.item.improve.create', compact('item', 'fuser', 'creater','teamers','is_see'));

        }
    }

    /*用户是否有查看此功能的权限*/
    public function getIsSee($item)
    {
        $is_see = false;
        if(Functions::getALId() == $item->fid || Functions::getALId() == 23 || Functions::getALId() == $item->create_id){
            $is_see = true;
        }

        return $is_see;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function taskEdit($item_id,$id)
    {
        $item = Item::find($item_id);
        $improve = ImproveTitle::find($id);

        return view('admin.item.improve.task.edit', compact('item', 'improve'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$item_id)
    {

        $item = Item::find($item_id);
        if($item->diag_active == 1){
            $startDate = $request->get('startDate');
            $endDate = $request->get('endDate');

            $item->improve_startDate = $startDate;
            $item->improve_endDate = $endDate;
            $item->update();

            $is_save = Functions::isUpdate($item->updated_at);

            return response()->json($is_save ? [ 'status' => 1,'url' => '/admin/item/'.$item->id.'/improve', 'msg' => '新增成功' ] : [ 'status' => 0, 'msg' => '新增失败' ]);
        }else{
            return response()->json([ 'status' => 0, 'msg' => '诊断报告未交付，不能新建实施计划' ]);
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($item_id)
    {
        $item = Item::find($item_id);

        $fuser = AdminUser::find($item->fid);
        $improve = $item->improve_titles()->first();

        $creater = AdminUser::find($item->create_id);//项目创建者
        $creater->office = Functions::getRoleName($creater);

        return view('admin.item.improve.edit', compact('item', 'fuser', 'creater', 'improve'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$item_id)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $item = Item::find($item_id);

        if($item->diag_active == 1){

            $item->improve_startDate = $startDate;
            $item->improve_endDate = $endDate;
            $item->update();

            $is_update = Functions::isUpdate($item->updated_at);

            if($is_update){
                Toastr::success('更新成功');
                return redirect(route('improve.index',[$item->id]));
            }else{
                Toastr::error('更新失败');
            }
        }else{
            return response()->json([ 'status' => 0, 'msg' => '诊断报告未交付，不能操作实施计划' ]);
        }

    }

    /*实施计划在线预览*/
    public function preview($item_id)
    {
        $item = Item::find($item_id);
        return view('admin.item.improve.preview.preview',compact('item'));
    }

    /*实施计划安排在线预览*/
    public function previewMsg($item_id)
    {
        $item = Item::find($item_id);
        $fuser = AdminUser::find($item->fid);
        $creater = AdminUser::find($item->create_id);//项目创建者
        $creater->office = Functions::getRoleName($creater);


        if($item->improve_startDate)
        {
            $improves = ImproveTitleTem::all();
            foreach($improves as $improve_title_tem){
                foreach($improve_title_tem->improve_list_tems as $improve_list_tem){
                    foreach($improve_list_tem->improve_con_tems as $improve_con_tem){
                        $is_task = Functions::isTure($improve_con_tem,'tasks');
                        if(!$is_task){
                            $improve_con_tem->start_date = $improve_con_tem->tasks->first()->start_date->toDateString();
                            $improve_con_tem->end_date = $improve_con_tem->tasks->first()->end_date->toDateString();
                            $improve_con_tem->master = AdminUser::find($improve_con_tem->tasks->first()->admin_user_id)->name;
                            $improve_con_tem->remark = $improve_con_tem->tasks->first()->remark;
                            if($improve_con_tem->tasks->first()->type == 1){
                                $improve_con_tem->type = '电话服务';
                            }elseif($improve_con_tem->tasks->first()->type == 0){
                                $improve_con_tem->type = '下厂服务';
                            }
                        }else{
                            $improve_con_tem->start_date = '';
                            $improve_con_tem->end_date = '';
                            $improve_con_tem->master = '';
                            $improve_con_tem->type = '';
                            $improve_con_tem->remark = '';
                        }
                    }
                }
            }

            return view('admin.item.improve.preview.preview1',compact('item','fuser','improves'));
        }else{
            return view('admin.item.improve.preview.preview1',compact('item','fuser'));

        }

    }

    /*交付客户*/
    public function active($item_id)
    {
        $item = Item::find($item_id);

        if($item->diag_active == 1){
            if(Functions::getImproveSetTask($item) == 100){
                $item->improve_active = 1;
                $item->improve_active_time = Carbon::now();
                $item->update();

                if($item->improve_active == 1){
                    Toastr::success('交付成功');
                }else{
                    Toastr::error('交付失败');
                }
            }else{
                Toastr::error('实施计划没有全部分派，不能交付实施计划');
            }

        }else{
            Toastr::error('诊断报告未交付，不能交付实施计划');
        }
        return redirect(route('improve.index',[$item->id]));
    }
}
