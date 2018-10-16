<?php
/*
 *任务
 *  * */

namespace App\Http\Controllers\Admin;

use App\Helpers\Functions;
use App\Models\AdminUser;
use App\Models\Diag;
use App\Models\DiagMod;
use App\Models\DiagSubmod;
use App\Models\DiagSubmodTem;
use App\Models\ImproveConTem;
use App\Models\Item;
use App\Models\ItemData;
use App\Models\Task;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends BaseController
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

        if(Functions::getALId() == 23){
            $tasks = $item->tasks()->paginate(15);
        }else{
            $tasks = $item->tasks()->where('admin_user_id',Functions::getALId())->paginate(15);
        }

        foreach( $tasks as $task )
        {
            $fpuser = AdminUser::find($task->fpid)->name;
            $user = AdminUser::find($task->admin_user_id)->name;
            /*服务满意度*/
            $suggest = '暂无';
            if( $task->suggests )
            {
                switch( $task->suggests->score )
                {
                    case 0:
                        $suggest = '不满意';
                        break;

                    case 1:
                        $suggest = '满意';
                        break;

                    default:
                        $suggest = '非常满意';
                }
            }
            $task->fpuser = $fpuser;
            $task->user = $user;
            $task->suggest = $suggest;

        }

        return view('admin.item.task.index', compact('item', 'tasks'));
    }

    /*我的分配任务*/
    public function allot($item_id)
    {
        $item = Item::find($item_id);
        if(Functions::getALId() == 23){
            $tasks = $item->tasks()->paginate(15);
        }else{
            $tasks = $item->tasks()->where('fpid',Functions::getALId())->paginate(15);
        }

        foreach( $tasks as $task )
        {
            $fpuser = AdminUser::find($task->fpid)->name;
            $user = AdminUser::find($task->admin_user_id)->name;
            /*服务满意度*/
            $suggest = '暂无';
            if( $task->suggests )
            {
                switch( $task->suggests->score )
                {
                    case 0:
                        $suggest = '不满意';
                        break;

                    case 1:
                        $suggest = '满意';
                        break;

                    default:
                        $suggest = '非常满意';
                }
            }
            $task->fpuser = $fpuser;
            $task->user = $user;
            $task->suggest = $suggest;
        }

        return view('admin.item.task.allot', compact('item', 'tasks'));

    }

    /*全部任务*/
    public function all($item_id)
    {
        $item = Item::find($item_id);

        if(Functions::getALId() == 23 || Functions::getALId() == $item->fid ||Functions::getALId() == $item->create_id){
            $tasks = $item->tasks()->paginate(15);
        }else{
            $tasks = $item->tasks()->where('admin_user_id',Functions::getALId())
                ->orWhere('fpid',Functions::getALId())->paginate(15);
        }

        foreach( $tasks as $task )
        {
            $fpuser = AdminUser::find($task->fpid)->name;
            $user = AdminUser::find($task->admin_user_id)->name;
            /*服务满意度*/
            $suggest = '暂无';
            if( $task->suggests )
            {
                switch( $task->suggests->score )
                {
                    case 0:
                        $suggest = '不满意';
                        break;

                    case 1:
                        $suggest = '满意';
                        break;

                    default:
                        $suggest = '非常满意';
                }
            }
            $task->fpuser = $fpuser;
            $task->user = $user;
            $task->suggest = $suggest;

        }

        return view('admin.item.task.all', compact('item', 'tasks'));
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
        $task = Task::find($id);
        /*任务状态*/
        switch( $task->status )
        {
            case 1:
                $status = '<span class="ztspan mystate1">进行中</span>';
                break;

            case 2:
                $status = '<span class="ztspan mystate2">已延期</span>';
                break;

            case 3:
                $status = '<span class="ztspan mystate3">未开始</span>';
                break;

            case 4:
                $status = '<span class="ztspan mystate4">已完成</span>';
                break;

            case 6:
                $status = '<span class="ztspan mystate6">待验收</span>';
                break;

            default:
                $status = '<span class="ztspan mystate5">待查看</span>';

        }

        /*优先级*/
        switch( $task->level )
        {

            case 1:
                $level = '<span class="ztspan you1">低</span></td>';
                break;

            case 2:
                $level = '<span class="ztspan you2">中</span></td>';
                break;

            case 3:
                $level = '<span class="ztspan you3">高</span></td>';
                break;

            case 4:
                $level = '<span class="ztspan you4">加急</span></td>';
                break;

            default:
                $level = '<span class="ztspan you5">特急</span></td>';

        }

        $fpuser = AdminUser::find($task->fpid)->name;
        $user = AdminUser::find($task->admin_user_id)->name;
        /*服务满意度*/
        $suggest = '暂无';
        if( $task->suggests )
        {
            switch( $task->suggests->score )
            {
                case 0:
                    $suggest = '不满意';
                    break;

                case 1:
                    $suggest = '满意';
                    break;

                default:
                    $suggest = '非常满意';
            }
        }

        /*任务延期天数*/

        $daly_date = floor(( Carbon::now()->timestamp  - $task->end_date->timestamp ) / 86400);
        $daly_days = $daly_date > 0 ? $daly_date.'天' : '暂无';

        $suggest_no = $task->suggests()->get()->isEmpty() ? 1 : 0;//实施计划是否填表

        return response()->json([
            'id' => $task->task_no,//序号
            'task_id' => $task->id,//id
            'title' => $task->title,//任务标题
            'status' => $status,//任务状态
            'suggest_no' => $suggest_no,//实施计划是否填表
            'no' => $task->status,//任务状态
            'start_date' => $task->start_date->toDateString(),//计划开始时间
            'end_date' => $task->end_date->toDateString(),//完成时间
            'daly_date' => $daly_days,//延期时间
            'level' => $level,//优先度
            'fpuser' => $fpuser,//分配人
            'user' => $user,//处理人
            'suggest' => $suggest,//服务评价
            'tasktable_id' => $task->tasktable_id,
            'tasktable_type' => $task->tasktable_type
        ]);
    }

    /*去完成任务*/
    public function complete(Request $request)
    {
        $task_id = $request->get('task_id');
        $tasktable_id = $request->get('tasktable_id');
        $tasktable_type = $request->get('tasktable_type');

        $task = Task::find($task_id);
        $task->status = 1;
        $task->update();

        $item_id = $task->items->id;

        if( Task::find($task_id)->status == 1 )
        {
            switch( $tasktable_type )
            {
                case 'App\Models\Diag'://诊断结果概述
                    return response()->json([ 'url' => '/admin/item/'.$item_id.'/diag/edit/'.$tasktable_id ]);

                case 'App\Models\DiagSubmod'://诊断结果具体分析
                    return response()->json([ 'url' => '/admin/item/'.$item_id.'/diags/edit/'.$tasktable_id ]);

                case 'App\User'://企业背景
                    return response()->json([ 'url' => '/admin/item/'.$item_id.'/diag/background/edit/'.$tasktable_id ]);

                case 'App\Models\Improve'://实施计划
                    return response()->json([ 'url' => '/admin/item/'.$item_id.'/suggest/'.$task->id ]);

                default://附录
                    return response()->json([ 'url' => '/admin/item/'.$item_id.'/diag/closure/edit/' ]);
            }
        }
    }

    /*确认完成任务*/
    public function solution(Request $request)
    {
        $task_id = $request->get('task_id');

        $task = Task::find($task_id);
        $task->status = 6;
        $task->update();

    return response()->json(Task::find($task_id)->status == 6 ? ['status' => 1,'msg' => '确认成功'] : ['status' => 0, 'msg' => '操作失败'] );
    }

    /*指派模块给相关负责人*/
    public function setTasks(Request $request, $id)
    {
        $taskContent = $request->get('taskContent');
        $diagmod = DiagMod::find($id);
        $diagmod->fid = $taskContent[ 'admin_user_id' ];
        $diagmod->update();

        /*判断是否指派成功*/
        $is_update = Functions::isUpdate($diagmod->updated_at);

        return response()->json($is_update ? [ 'status' => 1, 'msg' => '指派成功' ] : [ 'status' => 0, 'msg' => '指派失败' ]);
    }

    /*分配任务*/
    public function setTask(Request $request,$item_id,$id)
    {
        $taskContent = $request->get('taskContent');

        $start_date = $taskContent[ 'start_date' ];
        $end_date = $taskContent[ 'end_date' ];
        $level = $taskContent[ 'level' ];
        $admin_user_id = $taskContent[ 'admin_user_id' ];
        $tasktable_type = $taskContent[ 'tasktable_type' ];
        $type = '';
        $remark = '';
        $title = '';

        $item = Item::find($item_id);

        if( $tasktable_type === 'App\Models\Diag' )
        {//诊断报告
            $diag = Diag::find($id);
            $diag_title = $diag->title;
            switch( $diag_title )
            {
                case 1:
                    $name = '关务风险管理';
                    break;

                case 2:
                    $name = 'AEO风险管理';
                    break;

                case 3:
                    $name = '物流风险管理';
                    break;

                case 4:
                    $name = '系统化管理';
                    break;

                case 5:
                    $name = '预归类';
                    break;

                default:
                    $name = '预估价';
            }

            $title = '诊断报告-诊断结果概述-'.$name.'诊断';

        }elseif( $tasktable_type === 'App\User' ){//企业背景

            $title = '诊断报告-企业背景描述-企业基本情况';
        }elseif( $tasktable_type === 'App\Models\ItemData' ){//审核资料清单，附录

            $title = '诊断报告-附录-审核资料清单';
        }elseif( $tasktable_type === 'App\Models\DiagSubmod' )
        {//诊断结果具体分析
            $diag_submod = DiagSubmodTem::find($id);//诊断报告模板
            if($diag_submod){
                $diag_mods = $diag_submod->diag_mod_tems;
            }

            if(!$diag_submod){//自定义
                $diag_submod = DiagSubmod::find($id);
                if($diag_submod){
                    $diag_mods = $diag_submod->diag_mods;
                }
            }

            $subname = $diag_submod->name;
            $name ='';
            switch( $diag_mods->name )
            {
                case 1:
                    $name = '关务风险管理';
                    break;

                case 2:
                    $name = 'AEO管理';
                    break;

                case 3:
                    $name = '物流风险管理';
                    break;

                case 4:
                    $name = '系统化管理';
                    break;
            }

            $title = '诊断报告-诊断结果具体分析-'.$name.'-'.$subname;
        }elseif( $tasktable_type === 'App\Models\ImproveConTem' ){//实施计划

            $improve_con_tem = ImproveConTem::with('improve_list_tems')->where('id',$id)->first();
            $name = $improve_con_tem->improve_list_tems->name;
            $subname = $improve_con_tem->content;

            $type = $taskContent[ 'type' ];
            $remark = $taskContent[ 'remark' ];

            $title = '改善实施计划-'.$name.'-'.$subname;
        }

        $tasks = $item->tasks->where('tasktable_type',$tasktable_type)->where('tasktable_id',$id)->isEmpty();
        if(!$tasks){
            $task = $item->tasks->where('tasktable_type',$tasktable_type)->where('tasktable_id',$id)->first();
            $task->start_date = $start_date;
            $task->end_date = $end_date;
            $task->level = $level;
            $task->status = 5;//待查看
            $task->admin_user_id = $admin_user_id;
            $task->fpid = Functions::getALId();
            $task->update();

            $is_save = Functions::isUpdate($task->updated_at);

            return response()->json($is_save ? [ 'status' => 1, 'msg' => '分配成功' ] : [ 'status' => 0, 'msg' => '分配失败' ]);
        }

        $task = new Task();
        $task->title = $title;
        $task->start_date = $start_date;
        $task->end_date = $end_date;
        $task->level = $level;
        $task->type = $type;
        $task->remark = $remark;
        $task->status = 5;//待查看
        $task->admin_user_id = $admin_user_id;
        $task->item_id = $item->id;
        $task->tasktable_id = $id;
        $task->tasktable_type = $tasktable_type;
        $task->fpid = Functions::getALId();
        $task->task_no = $item->tasks->count()+1;
        $task->save();

        $is_save = Functions::isCreate(Task::all(),$task->id);

        return response()->json($is_save ? [ 'status' => 1, 'msg' => '分配成功' ] : [ 'status' => 0, 'msg' => '分配失败' ]);

    }

    /*一键分配任务*/
    public function setTaskAll(Request $request,$item_id,$id)
    {
        $taskContent = $request->get('taskContent');
        $start_date = $taskContent[ 'start_date' ];
        $end_date = $taskContent[ 'end_date' ];
        $level = $taskContent[ 'level' ];
        $admin_user_id = $taskContent[ 'admin_user_id' ];

        $diag_mod = DiagMod::with('diag_submods')->where('id',$id)->first();
        $ids = Functions::getIds($diag_mod->diag_submods);

        $task_ids = [];
        foreach( $ids as $id )
        {
            $tasks = Task::where('tasktable_type','App\Models\DiagSubmod')->where('tasktable_id',$id)->where('item_id',$item_id)->get();

            if(count($tasks)){
                $task = Task::where('tasktable_type','App\Models\DiagSubmod')->where('tasktable_id',$id)->where('item_id',$item_id)->first();
                $task->start_date = $start_date;
                $task->end_date = $end_date;
                $task->level = $level;
                $task->status = 5;//待查看
                $task->admin_user_id = $admin_user_id;
                $task->fpid = Functions::getALId();
                $task->update();
                array_push($task_ids, $task->id);
            }else{

                $name = DiagSubmod::find($id)->name;
                switch( $name )
                {
                    case 1:
                        $name = '关务风险管理';
                        break;

                    case 2:
                        $name = 'AEO管理';
                        break;

                    case 3:
                        $name = '物流风险管理';
                        break;

                    case 4:
                        $name = '系统化管理';
                        break;
                }

                $title = '诊断报告-诊断结果具体分析-'.$name;

                $task = new Task();
                $task->title = $title;
                $task->start_date = $start_date;
                $task->end_date = $end_date;
                $task->level = $level;
                $task->status = 5;//待查看
                $task->tasktable_id = $id;
                $task->tasktable_type = 'App\Models\DiagSubmod';
                $task->admin_user_id = $admin_user_id;
                $task->fpid = Functions::getALId();
                $task->item_id = $item_id;
                $task->task_no = Item::find($item_id)->tasks->count()+1;
                $task->save();

                array_push($task_ids, $task->id);
            }

            $taskIds = Functions::getIds(Task::all());
            $taskCounts = count(array_intersect($task_ids,$taskIds));
        }
        return response()->json([ 'status' => 1, 'msg' => '成功分配'.$taskCounts.'条任务' ]);
    }

    /*验收任务*/
    public function appcet(Request $request)
    {
        $task_id = $request->get('task_id');

        $task = Task::find($task_id);
        $task->status = 4;//完成任务
        $task->update();

        return response()->json(Task::find($task_id)->status == 4 ? ['status' => 1,'msg' => '验收成功'] : ['status' => 0, 'msg' => '操作失败'] );
    }

    /*
     * 检查任务
     * $id 子模块id
     *
     * return 1:任务已经存在，0：任务不存在
    */
    public function checkTask(Request $request,$item_id,$id)
    {
        $type = $request->get('type');
        if($type == 'diag'){
            $diag = Diag::find($id);
            //是否有分配任务
            $isTask = Functions::isTure($diag, 'tasks');
        }elseif($type == 'background'){
            $background = User::find($id);
            //是否有分配任务
            $isTask = Functions::isTure($background, 'tasks');
        }elseif($type == 'closure'){
            $closure = ItemData::find($id);
            //是否有分配任务
            $isTask = Functions::isTure($closure, 'tasks');
        }elseif($type == 'improve'){
            $improve_con_tem = ImproveConTem::with('tasks')->where('id',$id)->first();
            //是否有分配任务
            $isTask = $improve_con_tem->tasks()->where('item_id',$item_id)->get()->isEmpty();
        }else{
            $diag_submod = DiagSubmodTem::find($id);

            if(!$diag_submod){
                $diag_submod = DiagSubmod::find($id);
            }

            //是否有分配任务
            $isTask = Functions::isTure($diag_submod, 'tasks');
        }

        return response()->json($isTask ? [ 'status' => 0 ] : [ 'status' => 1 ]);
    }

    /*
     * 任务延期
     * id 任务id
     * */
    public function delay(Request $request, $id)
    {
        $end_date = $request->get('content');

        $task = Task::find($id);
        $task->end_date = $end_date;
        $task->update();

        /*判断是否有数据更新*/
        $is_update = Functions::isUpdate(Task::find($id)->updated_at);

        return response()->json($is_update ? [ 'status' => 1, 'msg' => '延期成功' ] : [ 'status' => 0, 'msg' => '延期失败' ]);
    }

    /*
     * 检查延期时间
     *
     * 延期时间不能小于计划完成时间
     *
     * */
    public function checkDelay(Request $request, $id)
    {
        $delay_date = strtotime($request->get('content'));
        $end_date = strtotime(Task::find($id)->end_date);

        return response()->json($delay_date >= $end_date ? [ 'status' => 1 ] : [ 'status' => 0, 'msg' => '延期时间不能小于任务计划完成时间' ]);
    }

    /*全部任务搜索*/
    public function searchAll(Request $request,$item_id)
    {

        $status = $request->get('status');
        $level = $request->get('level');
        $item = Item::find($item_id);

        if($status && $level){
            if(Functions::getALId() == 23 || Functions::getALId() == $item->fid ||Functions::getALId() == $item->create_id){
                $tasks = $item->tasks()->where('status',$status)->where('level',$level)->paginate(15);
            }else{
                $tasks = $item->tasks()->where('admin_user_id',Functions::getALId())
                    ->orWhere('fpid',Functions::getALId())->where('status',$status)->where('level',$level)->paginate(15);
            }

        }elseif($status && !$level){
            if(Functions::getALId() == 23 || Functions::getALId() == $item->fid ||Functions::getALId() == $item->create_id){
                $tasks = $item->tasks()->where('status',$status)->paginate(15);
            }else{
                $tasks = $item->tasks()->where('admin_user_id',Functions::getALId())
                    ->orWhere('fpid',Functions::getALId())->where('status',$status)->paginate(15);
            }

        }elseif(!$status &&  $level){
            if(Functions::getALId() == 23 || Functions::getALId() == $item->fid ||Functions::getALId() == $item->create_id){
                $tasks = $item->tasks()->where('level',$level)->paginate(15);
            }else{
                $tasks = $item->tasks()->where('admin_user_id',Functions::getALId())
                    ->orWhere('fpid',Functions::getALId())->where('level',$level)->paginate(15);
            }

        }else{
            if(Functions::getALId() == 23 || Functions::getALId() == $item->fid ||Functions::getALId() == $item->create_id){
                $tasks = $item->tasks()->paginate(15);
            }else{
                $tasks = $item->tasks()->where('admin_user_id',Functions::getALId())
                    ->orWhere('fpid',Functions::getALId())->paginate(15);
            }

        }

        foreach( $tasks as $task )
        {
            $fpuser = AdminUser::find($task->fpid)->name;
            $user = AdminUser::find($task->admin_user_id)->name;
            /*服务满意度*/
            $suggest = '暂无';
            if( $task->suggests )
            {
                switch( $task->suggests->score )
                {
                    case 0:
                        $suggest = '不满意';
                        break;

                    case 1:
                        $suggest = '满意';
                        break;

                    default:
                        $suggest = '非常满意';
                }
            }
            $task->fpuser = $fpuser;
            $task->user = $user;
            $task->suggest = $suggest;
        }

        return view('admin.item.task.all', compact('item', 'tasks','status','level'));
    }


    /*我的任务搜索*/
    public function search(Request $request,$item_id)
    {
        $status = $request->get('status');
        $level = $request->get('level');
        $item = Item::find($item_id);

        if($status && $level){
            $tasks = $item->tasks()->where('fpid',Functions::getALId())->where('status',$status)->where('level',$level)->paginate(15);
        }elseif($status && !$level){
            $tasks = $item->tasks()->where('fpid',Functions::getALId())->where('status',$status)->paginate(15);
        }elseif(!$status &&  $level){
            $tasks = $item->tasks()->where('fpid',Functions::getALId())->where('level',$level)->paginate(15);
        }else{
            $tasks = $item->tasks()->where('fpid',Functions::getALId())->paginate(15);
        }

        foreach( $tasks as $task )
        {
            $fpuser = AdminUser::find($task->fpid)->name;
            $user = AdminUser::find($task->admin_user_id)->name;
            /*服务满意度*/
            $suggest = '暂无';
            if( $task->suggests )
            {
                switch( $task->suggests->score )
                {
                    case 0:
                        $suggest = '不满意';
                        break;

                    case 1:
                        $suggest = '满意';
                        break;

                    default:
                        $suggest = '非常满意';
                }
            }
            $task->fpuser = $fpuser;
            $task->user = $user;
            $task->suggest = $suggest;
        }

        return view('admin.item.task.index', compact('item', 'tasks','status','level'));
    }

    /*我分配的任务搜索*/
    public function searchAllot(Request $request,$item_id)
    {
        $item = Item::find($item_id);
        $status = $request->get('status');
        $level = $request->get('level');
//        dd(1);

        if($status && $level){
            $tasks = $item->tasks()->where('fpid',Functions::getALId())->where('status',$status)->where('level',$level)->paginate(15);
        }elseif($status && !$level){
            $tasks = $item->tasks()->where('fpid',Functions::getALId())->where('status',$status)->paginate(15);
        }elseif(!$status &&  $level){
            $tasks = $item->tasks()->where('fpid',Functions::getALId())->where('level',$level)->paginate(15);
        }else{
            $tasks = $item->tasks()->where('fpid',Functions::getALId())->paginate(15);
        }

        foreach( $tasks as $task )
        {
            $fpuser = AdminUser::find($task->fpid)->name;
            $user = AdminUser::find($task->admin_user_id)->name;
            /*服务满意度*/
            $suggest = '暂无';
            if( $task->suggests )
            {
                switch( $task->suggests->score )
                {
                    case 0:
                        $suggest = '不满意';
                        break;

                    case 1:
                        $suggest = '满意';
                        break;

                    default:
                        $suggest = '非常满意';
                }
            }
            $task->fpuser = $fpuser;
            $task->user = $user;
            $task->suggest = $suggest;
        }

        return view('admin.item.task.allot', compact('item', 'tasks','status','level'));
    }
}
