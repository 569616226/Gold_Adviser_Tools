<?php

namespace App\Helpers;

use App\Models\AdminUser;
use App\Models\ImproveTitleTem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Functions {

    /*
     * 判断数据更新
     *
     * $update 更新时间
     * $now 现在的时间
     *
     * return bool
     *
     * */
    public static function  isUpdate($updated_at)
    {
        $update = $updated_at->timestamp;
        $now = Carbon::now()->timestamp;

        if(!$update && $update < $now )
        {
            return false;
        }else
        {
            return true;
        }
    }

    /*
     * 判断数据新增
     *
     * $objs 所有数据对象集合
     * $id 新增数据Id
     *
     * return bool
     * */

    public static function isCreate($objs,$id)
    {
        /*判断是否新增成功*/
        $ids = Functions::getIds($objs);
        $isSave = in_array($id, $ids);

        return $isSave;
    }

    /*
     * 获取id集合
     * $objs对象集合
     *
     * return array
    */
    public static function getIds($objs)
    {
        $Ids = $objs->pluck('id')->toArray();

        return $Ids;
    }

    /*获取登陆员工的ID*/
    public static function getALId()
    {
        return Auth::guard('admin')->user()->id;
    }

    /*获取登陆员工的ID*/
    public static function getALUser()
    {
        return Auth::guard('admin')->user();
    }


    /*获取登陆客户的ID*/
    public static function getGLUser()
    {
        return Auth::user();
    }

    /*获取除admin以外的所有员工*/
    public static function getAdminUsers()
    {
       return  AdminUser::where('username', '!=', 'admin');
    }

    /*
     * 删除相关数据
     * $datas 相关数据对象
     * $is_task,是否有关联任务
     * $is_one,是否是一对一关系
     * */
    public static function delRelDate($datas, $is_task = false, $is_one = false)
    {

        if( $is_one && $datas )
        {
            //删除任务
            if( $is_task )
            {
                /*是否有任务*/
                $istask = Functions::isTure($datas, 'tasks');
                if( $istask )
                {

                    $tasks = $datas->tasks;

                    foreach( $tasks as $task )
                    {
                        $task->delete();
                    }
                }
            }

            $datas->delete();
        }else
        {
            if( count($datas) !== 0 )
            {
                foreach( $datas as $data )
                {
                    //删除任务
                    if( $is_task )
                    {
                        /*是否有任务*/
                        $istask = Functions::isTure($data, 'tasks');
                        if( $istask )
                        {

                            $tasks = $data->tasks;

                            foreach( $tasks as $task )
                            {
                                $task->delete();
                            }
                        }
                    }

                    $data->delete();
                }
            }
        }
    }

    /*
* 关联关系是否存在
*判断 $model和$tmodel(关系方法名)是否在关联关系
*
* return object $isTrue
* */
    public static function isTure($model, $Tmodel,$type='many')
    {
        if($type === 'many'){
            $bool = $model->$Tmodel->isEmpty();
        }else{
            $bool = $model->$Tmodel()->get()->isEmpty();
        }

        return   $bool;
    }

    /*
 * $obj 对象
 * return $display_name 角色名
 * 获取角色名
 * */
    public static function getRoleName($obj)
    {

        $display_names = [];
        $roles = $obj->roles;
        foreach( $roles as $role )
        {
            array_push($display_names, $role->display_name);
        }
        $display_name = implode('|', $display_names);

        return $display_name;
    }


    /*
     * 排序按角色是否是经理排序
      * right 经理在前
      * left 经理在后
      * return 成员集合 $teamers
      * */
    public static function orderAdminUsers($item, $direction)
    {
        $teamers = [];
        if( $direction === 'left' )
        {
            /*排序把经理排在后面*/
            $admin_users = $item->admin_users;

            foreach( $admin_users as $admin_user )
            {
                $roleNames = implode("",Functions::getIds($admin_user->roles));
                if( strspn($roleNames, '经理') )
                {
                    array_unshift($teamers, $admin_user);
                }else
                {
                    array_push($teamers, $admin_user);
                }
            }
        }elseif( $direction === 'right' )
        {
            /*排序把经理排在前面*/
            $admin_users = $item->admin_users;

            foreach( $admin_users as $admin_user )
            {
                $roleNames = implode("", Functions::getIds($admin_user->roles));
                if( strspn($roleNames, '经理') )
                {
                    array_push($teamers, $admin_user);
                }else
                {
                    array_unshift($teamers, $admin_user);
                }
            }
        }

        return $teamers;
    }

    /*诊断报告任务完成百分度*/
    public static function getDiagComplate($item)
    {
        /*诊断报告%度*/
        $diag_mods = $item->diag_mods;
        $diag_count = $item->diags->count();

        $diag_submods = 0;
        foreach( $diag_mods as $diag_mod )
        {
            $diagSubmodCounts = $diag_mod->diag_submods->count();
            $diag_submods += $diagSubmodCounts;
        }

        /*诊断报告任务完成百分度*/
        $diag_submod_task_complate = $item->tasks()->where('tasktable_type','App\Models\DiagSubmod')->where('status',4)->get()->count();
        $diag_task_complate = $item->tasks()->where('tasktable_type','App\Models\Diag')->where('status',4)->get()->count();
        $user_task_complate = $item->tasks()->where('tasktable_type','App\User')->where('status',4)->get()->count();
        $item_data_task_complate = $item->tasks()->where('tasktable_type','App\Models\ItemData')->where('status',4)->get()->count();

        $diag_per = ($diag_submod_task_complate + $diag_task_complate + $user_task_complate + $item_data_task_complate) / ($diag_submods + $diag_count+2) * 100;

        return floor($diag_per);
    }


    /*项目实施计划100%*/
    public static function getImproveComplate($item)
    {
        /*实施计划任务数量*/
        $improveCount = 0;
        /*客户建议数量*/
        $suggest_counts_0 = 0;
        $suggest_counts_1 = 0;
        $suggest_counts_2 = 0;

        $improveTasks = $item->tasks()->where('tasktable_type','App\Models\ImproveConTem')->get();
        $improve_title_tems = ImproveTitleTem::with('improve_list_tems.improve_con_tems')->get();

        foreach( $improve_title_tems as $improve_title_tem )
        {
            foreach( $improve_title_tem->improve_list_tems as $improve_list_tem )
            {
                $improveCount += $improve_list_tem->improve_con_tems->count();
            }
        }

        foreach($improveTasks as $improveTask){
            $is_suggest = Functions::isTure($improveTask,'suggests','one');

            if(!$is_suggest){
                $suggest = $improveTask->suggests;
                $is_advise = Functions::isTure($suggest,'advises','one');
                if(!$is_advise){
                    $score = $suggest->score;
                    if($score == 0){
                        $suggest_counts_0++;
                    }elseif($score == 1){
                        $suggest_counts_1++;
                    }else{
                        $suggest_counts_2++;
                    }
                }
            }
        }


        /*改善实施计划任务完成百分度*/
        $improve_title_per = $item->suggest_counts / $improveCount * 100;

        return [
            'improve_title_per' => floor($improve_title_per),
            'suggest_counts_0' => $suggest_counts_0,
            'suggest_counts_1' => $suggest_counts_1,
            'suggest_counts_2' => $suggest_counts_2,
        ];

    }

    /*改善实施计划任务分派百分度*/
    public static function getImproveSetTask($item)
    {
        /*实施计划数量*/
        $improveCount = 0;

        /*实施计划任务数量*/
        $improveTasks = $item->tasks()->where('tasktable_type','App\Models\ImproveConTem')->get();

        $improve_title_tems = ImproveTitleTem::with('improve_list_tems.improve_con_tems')->get();

        foreach( $improve_title_tems as $improve_title_tem )
        {
            foreach( $improve_title_tem->improve_list_tems as $improve_list_tem )
            {
                $improveCount += $improve_list_tem->improve_con_tems->count();
            }
        }
        /*改善实施计划任务完成百分度*/
        $improve_title_per = $item->suggest_counts / $improveCount * 100;

        return $improve_title_per;
    }

    /*生成服务建议序号*/
    public static function getAdviseNo($suggest)
    {
        $is_advise = Functions::isTure($suggest,'advises');
        if($is_advise){
            return $suggest;
        }else{
            $advises = $suggest->advises;
            foreach($advises as $advise){
                for($x = 1; $x<= $advises->count(); $x++){

                    $advise->no = $x;
                }
            }
            return $suggest;
        }
    }
}