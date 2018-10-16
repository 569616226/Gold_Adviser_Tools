<?php
/*
 *
 * 改善实施计划
 * */

namespace App\Http\Controllers;

use App\Helpers\Functions;
use App\Models\AdminUser;
use App\Models\ImproveTitleTem;
use App\Models\Item;
use App\Models\UserDepart;
use Illuminate\Http\Request;

class ImproveController extends BaseController
{
    /**
     * CustomerController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /*实施计划在线预览*/
    public function preview($item_id)
    {
       $item = Item::find($item_id);

        return view('improve.preview.preview',compact('item'));
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

            return view('improve.preview.preview1',compact('item','fuser','improves'));
        }else{
            return view('improve.preview.preview1',compact('item','fuser'));

        }
    }

}
