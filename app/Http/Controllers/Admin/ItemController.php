<?php
/*
 * 项目
 * */

namespace App\Http\Controllers\Admin;

use App\Helpers\Functions;
use App\Models\AdminUser;
use App\Models\Diag;
use App\Models\DiagMod;
use App\Models\DiagModTem;
use App\Models\DiagSubcontent;
use App\Models\DiagSubcontentTem;
use App\Models\DiagSubmod;
use App\Models\Hand;
use App\Models\ImproveTitleTem;
use App\Models\Item;
use App\Models\ItemData;
use App\Models\Material;
use App\Models\MaterialContent;
use App\Models\MaterialTemplate;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ItemController extends BaseController
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
        if(Functions::getALId()== 23){
            $items = Item::latest()->get();
        }else{
            $itemAlls = Item::with(['admin_users'])->get();
            $items = [];
            /*显示创建者或者成员所属项目*/
            foreach($itemAlls as $item){
                $adminUserIds = Functions::getIds( $item->admin_users);
                if(in_array(Functions::getALId(),$adminUserIds) || $item->create_id == Functions::getALId()){
                    array_unshift($items,$item);
                }
            }
        }

        $users = User::all();//所有客户
        $admin_users = Functions::getAdminUsers()->get();  /*所有员工*/

        /*我的待办数量*/
        foreach( $items as $item )
        {
            $tasks = $item->tasks()->where('admin_user_id',Functions::getALId())->where('status','=',5)->count();
            $item->task_count =  $tasks;
            //项目创建者
            $creator = AdminUser::find($item->create_id);
            $item->creator = $creator;
        }

        return view('admin.item.index', compact('items', 'admin_users', 'users'));
    }

    /*项目概况*/
    public function pro($item_id)
    {
        $item = Item::find($item_id);
        /*任务总数*/
        $tasks = $item->tasks;
        $item->task_count =  $tasks->count();

        /*进行中任务数量*/
        $taskings = $item->tasks->where('status',1);
        $item->tasking = $taskings->count();

        /*已延期数量*/
        $task_delay = $item->tasks->where('status',2);
        $item->task_delay =$task_delay->count();

        /*已完成数量*/
        $task_complate = $item->tasks->where('status',4);
        $item->task_complate = $task_complate->count();

        /*待查看任务*/
        $task_unsols = $item->tasks()->where('admin_user_id',Functions::getALId())
            ->where('status',5)->latest()->limit(5)->get();
        $item->task_unsols = $task_unsols;
        /*待查看任务数量*/
        $item->task_unsol = $task_unsols->count();

        /*项目成员数量*/
        $item->user_counts = count($item->admin_users);

        /*项目运行时间*/
        $run_days = floor((Carbon::now()->timestamp  - $item->created_at->timestamp ) / 86400);
        $item->run_days = $run_days.'天';

        /*诊断报告%度*/
        $item->diag_per = Functions::getDiagComplate($item);
        $improve_data = Functions::getImproveComplate($item);

        /*客户建议*/
        $item->suggest_counts_0 = $improve_data['suggest_counts_0'];
        $item->suggest_counts_1 = $improve_data['suggest_counts_1'];
        $item->suggest_counts_2 = $improve_data['suggest_counts_2'];
        $item->suggest_counts   = $improve_data['suggest_counts_0'] + $improve_data['suggest_counts_1'] +  $improve_data['suggest_counts_2'];

        /*改善实施计划任务完成百分度*/
        $item->improve_title_per = $improve_data['improve_title_per'];

        return view('admin.item.pro.index', compact('item'));
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
        $handId = $request->input('handid');
        if(!$handId){
            return response()->json([ 'status' => 0, 'msg' => '请选择客户' ]);
        }
        $item = new Item();
        $item->hand_id = $handId;
        $item->material_template_name_id = 1;//设置材料清单模板
        $item->create_id = Functions::getALId();
        $item->save();

        /*诊断结果概述*/
        for( $x = 1; $x <= 6; $x++ )
        {
            /*诊断结果概述*/
            $diag = new Diag();
            $diag->title = $x;
            $diag->item_id = $item->id;
            $diag->save();
        }

        /*诊断结果具体分析*/
        $diag_mod_tems = DiagModTem::with('diag_submod_tems.diag_subcontent_tems')->get();
        foreach($diag_mod_tems as $diag_mod_tem){
            $diag_mod = new DiagMod();
            $diag_mod->name = $diag_mod_tem->type;
            $diag_mod->item_id = $item->id;
            $diag_mod->save();

            foreach($diag_mod_tem->diag_submod_tems as $diag_submod_tem){
                $diag_submod = new DiagSubmod();
                $diag_submod->name = $diag_submod_tem->name;
                $diag_submod->trade_type = $diag_submod_tem->trade_type;
                $diag_submod->aeo_type = $diag_submod_tem->aeo_type;
                $diag_submod->diag_mod_id = $diag_mod->id;
                $diag_submod->save();

                foreach($diag_submod_tem->diag_subcontent_tems as $diag_subcontent_tem){
                    $diag_subcontent = new DiagSubcontent();
                    $diag_subcontent->content =  $diag_subcontent_tem->content;
                    $diag_subcontent->diag_submod_id = $diag_submod->id;
                    $diag_subcontent->save();
                }
            }
        }

        /*审核资料*/
        $itemDate = new ItemData();
        $itemDate->item_id = $item->id;
        $itemDate->save();

        $is_create = Functions::isCreate(Item::all(), $item->id);

        $creater_user = AdminUser::with('roles')->where('id',$item->create_id)->first();//项目创建者
        $offices = [];//项目创建者角色名集合
        foreach( $creater_user->roles as $role )
        {
            array_push($offices, $role->display_name);
        }

        $office = implode('|', $offices);

        /*创建者*/
        $creater = ' <div>'.$creater_user->name.$office.'</div><span class="color888 fs14">'.$creater_user->email.'</span><input type="hidden" value="'.$item->id.'/>';

        return response()->json($is_create ? [ 'status' => 1, 'creater' => $creater, 'msg' => '创建成功','item_id'=> $item->id ] : [ 'status' => 0, 'msg' => '创建失败' ]);

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
        $item = Item::with('admin_users')->where('id',$id)->first();
        $admin_users = $item->admin_users;
        $adminUserIds = Functions::getIds($admin_users);

        $creater = AdminUser::with('roles')->where('id',$item->create_id)->first();//项目创建者

        $offices = [];//项目创建者角色名集合
        foreach( $creater->roles as $role )
        {
            array_push($offices, $role->display_name);
        }

        $office = implode('|', $offices);
        $creater->office = $office;

        /*添加角色名到已经设置的员工*/
        foreach( $admin_users as $admin_user )
        {
            /*获取角色名*/
            $display_names = [];
            $roles = $admin_user->roles;
            foreach( $roles as $role )
            {
                array_push($display_names, $role->display_name);
            }
            $display_name = implode('|', $display_names);
            $admin_user->display_name = $display_name;
        }

        /*排除已经设置的员工*/
        $adminUsers = Functions::getAdminUsers()->whereNotIn('id', $adminUserIds)->get();

        return view('admin.item.edit', compact('item', 'adminUsers', 'admin_users', 'creater'));
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
        $item = Item::find($id);

        /*诊断结果概述*/
        $diags = $item->diags;
        Functions::delRelDate($diags, true);

        /*诊断结果具体分析*/
        $diag_mods = $item->diag_mods;
        foreach( $diag_mods as $diag_mod )
        {
            $diag_submods = $diag_mod->diag_submods;
            Functions::delRelDate($diag_submods, true);
        }

        /*审核资料*/
        $itemDatas = $item->item_datas;
        Functions::delRelDate($itemDatas, true, true);

        /*项目图片*/
        $images = $item->images;
        Functions::delRelDate($images, false, true);

        /*材料清单*/
        $maters = $item->maters;
        Functions::delRelDate($maters);

        $item->hand_id = null;
        $item->update();

        $item->delete();
        $is_del = Functions::isCreate(Item::withTrashed(),$id);

        return response()->json($is_del ? [ 'status' => 1, 'msg' => '删除成功' ] : [ 'status' => 0, 'msg' => '删除失败' ]);
    }

    /*搜索项目*/
    public function search(Request $request)
    {
        $str = $request->input('searchStr');

        $hands = Hand::where(function($query) use ($str)
        {
            $query->where('name', 'like', '%'.$str.'%');
        })->with('items')->get();

        $items = [];
        foreach( $hands as $hand )
        {

            $itemObj = $hand->items;
            $is_items = Functions::isTure($hand,'items','one');
            if(!$is_items)
            {
                /*显示创建者或者成员所属项目*/
                $adminUserIds = Functions::getIds( $itemObj->admin_users);
                if(in_array(Functions::getALId(),$adminUserIds) ||$itemObj->create_id == Functions::getALId()){
                    array_push($items, $itemObj);
                }
            }
        }

        /*我的任务数量*/
        foreach( $items as $item )
        {
            $tasks = $item->tasks->where('admin_user_id',Functions::getALId())
                ->where('status','!=',4);
            $item->task_count =  $tasks->count();
            //项目创建者
            $creator = AdminUser::find($item->create_id);
            $item->creator = $creator;
        }

        $users = User::all();
        $admin_users = Functions::getAdminUsers()->get();
        if(count($items)){
            return view('admin.item.index', compact('items', 'admin_users', 'users'));
        }

        return view('admin.item.index', compact( 'admin_users', 'users'));

    }

    /*更新项目信息*/
    public function updateItem(Request $request, $hand_id)
    {
        $name = $request->name;
        $description = $request->description;

        $hand = Hand::find($hand_id);
        $hand->name = $name;
        $hand->description = $description;
        $hand->update();


        /*是否有更新*/
        $is_update = Functions::isUpdate($hand->updated_at);

        return response()->json($is_update ? [ 'status' => 1, 'msg' => '更新成功' ] : [ 'status' => 0, 'msg' => '更新失败' ]);

    }

    /*添加员工*/
    public function addTeamer(Request $request, $handid)
    {

        $item = Hand::find($handid)->items;

        /*添加角色名到已经设置的员工*/
        $admin_user_id = $request->input('admin_user_id');

        $item->admin_users()->attach($admin_user_id);//添加成员到项目

        $admin_users = $item->admin_users;
        $listhtml = $this->getListhtml($admin_users, $item->fid);

        /*排除已经设置的员工*/
        $adminUserIds = Functions::getids($item->admin_users);;
        $adminUsers = Functions::getAdminUsers()->whereNotIn('id', $adminUserIds)->get();

        /*插入未设置的员工*/
        $optionhtml = $this->getOptionhtml($adminUsers);

        return response()->json([ 'status' => 1, 'listhtml' => $listhtml, 'optionhtml' => $optionhtml, 'msg' => '添加成功' ]);
    }

    /*添加总负责人*/
    public function addMaster($item_id,$admin_user_id)
    {
        $item = Item::find($item_id);
        $item->fid = $admin_user_id;
        $item->update();

        $admin_users = $item->admin_users;
        /*成员列表*/
        $listhtml = $this->getListhtml($admin_users, $item->fid);

        return response()->json([ 'status' => 1, 'listhtml' => $listhtml, 'msg' => '设置成功' ]);
    }

    /*移除成员*/
    public function delMaster( $item_id,$admin_user_id)
    {
        $item = Item::find($item_id);
        $item->admin_users()->detach($admin_user_id);//添加成员到项目
        if($admin_user_id == $item->fid){
            $item->fid = null;
            $item->update();
        }

        $admin_users = $item->admin_users;
        $listhtml = $this->getListhtml($admin_users, $item->fid);

        /*排除已经设置的员工*/
        $adminUserIds = Functions::getIds($item->admin_users);
        $adminUsers = Functions::getAdminUsers()->whereNotIn('id', $adminUserIds)->get();

        /*插入未设置的员工*/
        $optionhtml = $this->getOptionhtml($adminUsers);

        return response()->json([ 'status' => 1, 'listhtml' => $listhtml, 'optionhtml' => $optionhtml, 'msg' => '移除成功' ]);

    }

    /*项目成员列表*/
    public function getListhtml($admin_users, $item_fid = null)
    {
        $listhtml = '';
        foreach( $admin_users as $admin_user )
        {
            /*获取角色名*/
            $display_name = Functions::getRoleName($admin_user);

            if( $item_fid == $admin_user->id)
            {
                if($item_fid == Functions::getALId()){
                    $listhtml .= '<li class="list-child paddlr20px"><div class="am-fl am-text-left"><div>'.$admin_user->name.'('.$display_name.')</div><span class="color888 fs14 am-text-left">'.$admin_user->email.'</span>
                        </div>
                        <div class="am-fr paddt10px">
                            <span class="">总负责人</span></div>
                        <div style="clear: both;"></div>
                    </li>';
                }else{
                    $listhtml .= '<li class="list-child paddlr20px"><div class="am-fl am-text-left"><div>'.$admin_user->name.'('.$display_name.')</div><span class="color888 fs14 am-text-left">'.$admin_user->email.'</span>
                        </div>
                        <div class="am-fr paddt10px">
                            <span class="sbtn2 colorred" onclick="setdf(this)" name="'.$admin_user->id.'">移除</span>
                            <span class="">总负责人</span></div>
                        <div style="clear: both;"></div>
                    </li>';
                }

            }else
            {
                if($item_fid == Functions::getALId()){
                    $listhtml .= '<li class="list-child paddlr20px"><div class="am-fl am-text-left"><div>'.$admin_user->name.'('.$display_name.')</div><span class="color888 fs14 am-text-left">'.$admin_user->email.'</span>
                        </div>
                        <div class="am-fr paddt10px">
                            <span class="sbtn2 colorred" onclick="setdf(this)" name="'.$admin_user->id.'">移除</span>
                            <span class="">成员</span></div>
                        <div style="clear: both;"></div>
                    </li>';

                }else{
                    $listhtml .= '<li class="list-child paddlr20px"><div class="am-fl am-text-left"><div>'.$admin_user->name.'('.$display_name.')</div><span class="color888 fs14 am-text-left">'.$admin_user->email.'</span>
                            </div>
                            <div class="am-fr paddt10px">
                                <span class="sbtn1 color639" onclick="setz(this)" name="'.$admin_user->id.'">设置为总负责人</span>
                                <span class="sbtn2 colorred" onclick="setdf(this)" name="'.$admin_user->id.'">移除</span>
                                <span class="">成员</span></div>
                            <div style="clear: both;"></div>
                        </li>';
                }
            }
        }
        return $listhtml;
    }

    /*不在项目内的员工列表*/
    public function getOptionhtml($adminUsers)
    {
        /*插入未设置的员工*/
        $optionhtml = '';
        foreach( $adminUsers as $adminUser )
        {
            $optionhtml .= '<option value="'.$adminUser->id.'">'.$adminUser->name.'</option>';
        }
        return $optionhtml;
    }
}
