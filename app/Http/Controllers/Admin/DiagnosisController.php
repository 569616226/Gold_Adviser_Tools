<?php
/*
 * 诊断报告
 * */

namespace App\Http\Controllers\Admin;

use App\Helpers\Functions;
use App\Models\AdminUser;
use App\Models\DiagMod;
use App\Models\DiagModTem;
use App\Models\DiagSubcontent;
use App\Models\DiagSubcontentTem;
use App\Models\DiagSubmod;
use App\Models\DiagSubmodTem;
use App\Models\Item;
use App\Models\Law;
use Illuminate\Http\Request;
use Yuansir\Toastr\Facades\Toastr;


class DiagnosisController extends BaseController
{
    /**
     * CustomerController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }


    /*海关高级AEO管理*/
    public function aeo($item_id)
    {
        $item = Item::find($item_id);
        $diag_mod = $this->getDiagMod($item, 2);

        /*
         * 排序按角色是否是经理排序
          * right 经理在前
          * left 经理在后
          * return 成员集合 $teamers
          * */
        $teamerRs = Functions::orderAdminUsers($item, 'right');
        $teamerLs = Functions::orderAdminUsers($item, 'left');

        /*用户是否有查看此功能的权限*/
        $is_see = $this->getIsSee($item);

        return view('admin.item.diag.diag_module.aeo.index', compact('item', 'diag_mod', 'teamerRs', 'teamerLs','is_see'));
    }


    /*关务风险管理*/
    public function guanwu($item_id)
    {
        $item = Item::find($item_id);
        $diag_mod = $this->getDiagMod($item, 1);
        /*
         * 排序按角色是否是经理排序
          * right 经理在前
          * left 经理在后
          * return 成员集合 $teamers
          * */
        $teamerRs = Functions::orderAdminUsers($item, 'right');
        $teamerLs = Functions::orderAdminUsers($item, 'left');

        /*用户是否有查看此功能的权限*/
        $is_see = $this->getIsSee($item);

        return view('admin.item.diag.diag_module.guanwu.index', compact('item', 'diag_mod', 'teamerRs', 'teamerLs','is_see'));
    }

    /*系统化管理*/
    public function system($item_id)
    {
        $item = Item::find($item_id);
        $diag_mod = $this->getDiagMod($item, 4);

        /*
         * 排序按角色是否是经理排序
          * right 经理在前
          * left 经理在后
          * return 成员集合 $teamers
          * */
        $teamerRs = Functions::orderAdminUsers($item, 'right');
        $teamerLs = Functions::orderAdminUsers($item, 'left');

        /*用户是否有查看此功能的权限*/
        $is_see = $this->getIsSee($item);

        return view('admin.item.diag.diag_module.system.index', compact('item', 'diag_mod', 'teamerRs', 'teamerLs','is_see'));
    }

    /*物流风险管理*/
    public function wuliu($item_id)
    {
        $item = Item::find($item_id);
        $diag_mod = $this->getDiagMod($item, 3);
        /*
         * 排序按角色是否是经理排序
          * right 经理在前
          * left 经理在后
          * return 成员集合 $teamers
          * */
        $teamerRs = Functions::orderAdminUsers($item, 'right');
        $teamerLs = Functions::orderAdminUsers($item, 'left');

        /*用户是否有查看此功能的权限*/
        $is_see = $this->getIsSee($item);

        return view('admin.item.diag.diag_module.wuliu.index', compact('item', 'diag_mod', 'teamerRs', 'teamerLs','is_see'));
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
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($item_id, $id)
    {
        $item = Item::find($item_id);
        $laws = Law::all();

        switch( $id )
        {
            case 'guanwu':

                $diag_mod = $this->getDiagMod($item, 1);
                return view('admin.item.diag.diag_module.guanwu.editMod', compact('item', 'diag_mod', 'laws'));
                break;

            case 'aeo':

                $diag_mod = $this->getDiagMod($item, 2);
                return view('admin.item.diag.diag_module.aeo.editModAeo', compact('item', 'diag_mod', 'laws'));

                break;

            case 'wuliu':

                $diag_mod = $this->getDiagMod($item, 3);
                return view('admin.item.diag.diag_module.wuliu.editMod', compact('item', 'diag_mod', 'laws'));

                break;

            case 'system':

                $diag_mod = $this->getDiagMod($item, 4);
                return view('admin.item.diag.diag_module.system.editMod', compact('item', 'diag_mod', 'laws'));

                break;

            default :
                $diag_mod = $this->getDiagMod(null, null,$id);

                if( $diag_mod->name == 1 )
                {
                    return view('admin.item.diag.diag_module.guanwu.editMod', compact('item', 'diag_mod', 'laws'));
                }elseif( $diag_mod->name == 2 )
                {
                    return view('admin.item.diag.diag_module.aeo.editModAeo', compact('item', 'diag_mod', 'laws'));
                }elseif( $diag_mod->name == 3 )
                {
                    return view('admin.item.diag.diag_module.wuliu.editMod', compact('item', 'diag_mod', 'laws'));
                }else
                {
                    return view('admin.item.diag.diag_module.system.editMod', compact('item', 'diag_mod', 'laws'));
                }
        }
    }

    /*新增模块*/
    public function addMod($item_id, $id)
    {
        $item = Item::find($item_id);
        $diag_mod = DiagMod::find($id);
        $diag_mod->diag_submods = $diag_mod->diag_submods()->latest()->paginate(15);

        return view('admin.item.diag.diag_module.addMod', compact('item', 'diag_mod'));
    }

    /*保存模块*/
    public function subModStore(Request $request, $id)
    {
        $name = $request->input('name');
        $aeo_type = $request->input('aeo_type');
        $trade_type = $request->input('trade_type');

        $diag_submod = new DiagSubmod();
        $diag_submod->name = $name;
        $diag_submod->aeo_type = $aeo_type;
        $diag_submod->trade_type = $trade_type;
        $diag_submod->diag_mod_id = $id;
        $diag_submod->save();

        $item_id = $diag_submod->diag_mods->items->id;

        /*是否保存成功*/
        $is_save = Functions::isCreate(DiagSubmod::all(), $diag_submod->id);

        if( $is_save )
        {
            Toastr::success('新增成功');
        }else
        {
            Toastr::error('新增失败');
        }

        return redirect(route('diags.addmod', [ $item_id, $id ]));
    }

    /*编辑模块*/
    public function subModEdit($id)
    {
        $diag_submod = DiagSubmod::find($id);
        $name = $diag_submod->name;

        return response()->json([ 'name' => $name ]);
    }

    /*更新模块*/
    public function subModUpdate(Request $request, $id)
    {
        $name = $request->input('name');
        $aeo_type = $request->input('aeo_type');
        $trade_type = $request->input('trade_type');

        $diag_submod = DiagSubmod::find($id);
        $diag_submod->name = $name;
        $diag_submod->aeo_type = $aeo_type;
        $diag_submod->trade_type = $trade_type;
        $diag_submod->update();

        /*是否保存成功*/
        $is_save = Functions::isUpdate($diag_submod->updated_at);

        return response()->json($is_save ? [ 'status' => 1, 'msg' => '编辑成功' ] : [ 'status' => 0, 'msg' => '编辑失败' ]);
    }

    /*删除模块*/
    public function subModDestroy($id)
    {
        DiagSubmod::find($id)->delete();

        /*是否保存成功*/
        $is_del = Functions::isCreate(DiagSubmod::withTrashed(), $id);

        return response()->json($is_del ? [ 'status' => 1, 'msg' => '删除成功' ] : [ 'status' => 0, 'msg' => '删除失败' ]);
    }

    /*增加子模块内容*/
    public function addContent(Request $request, $id)
    {
        $content = htmlentities(addslashes($request->get('content')));

        $diag_subCon = new DiagSubcontent();
        $diag_subCon->diag_submod_id = $id;
        $diag_subCon->content = $content;
        $diag_subCon->save();

        $is_save = Functions::isCreate(DiagSubcontent::all(), $diag_subCon->id);

        return response()->json($is_save ? [ 'status' => 1, 'msg' => '新增成功' ] : [ 'status' => 0, 'msg' => '新增失败' ]);
    }

    /*编辑子模块内容*/
    public function editContent($id)
    {
        $diag_subCon = DiagSubcontent::find($id);
        $content = html_entity_decode(stripslashes($diag_subCon->content));

        return response()->json([ 'content' => $content ]);
    }

    /*更新子模块内容*/
    public function storeContent(Request $request, $id)
    {
        $diag_subCon = DiagSubcontent::find($id);
        $content = htmlentities(addslashes($request->get('content')));
        $diag_subCon->content = $content;
        $diag_subCon->update();

        $is_update = Functions::isUpdate($diag_subCon->updated_at);

        return response()->json($is_update ? [ 'status' => 1, 'msg' => '编辑成功' ] : [ 'status' => 0, 'msg' => '更新失败' ]);
    }

    /*删除子模块内容*/
    public function delContent($id)
    {
        DiagSubcontent::find($id)->delete();

        /*删除机构id集合*/
        $is_delete = Functions::isCreate(DiagSubcontent::withTrashed(), $id);

        return response()->json($is_delete ? [ 'status' => 1, 'msg' => '删除成功' ] : [ 'status' => 0, 'msg' => '删除失败' ]);
    }

    /*查看编辑页法律法规*/
    public function seeEditlaw($id)
    {
        $lawAlls = Law::all();
        $diag_subcontent = DiagSubcontent::find($id);
        $lawsIds = Functions::getIds($diag_subcontent->laws);
        $namehtml = '';
        foreach( $lawAlls as $lawAll )
        {
            if( count($lawsIds) )
            {
                if( in_array($lawAll->id, $lawsIds) )
                {
                    $namehtml .= '<option selected value="'.$lawAll->name.'">'.$lawAll->name.'</option>';
                }else
                {
                    $namehtml .= '<option value="'.$lawAll->name.'">'.$lawAll->name.'</option>';
                }
            }else
            {
                $namehtml .= '<option value="'.$lawAll->name.'">'.$lawAll->name.'</option>';
            }
        }

        $titlehtml = '';
        foreach( $lawAlls as $lawAll )
        {
            if( count($lawsIds) )
            {
                if( in_array($lawAll->id, $lawsIds) )
                {
                    $titlehtml .= '<option selected value="'.$lawAll->title.'">'.$lawAll->title.'</option>';
                }
            }
        }

        $contenthtml = '';
        foreach( $lawAlls as $lawAll )
        {
            if( count($lawsIds) )
            {
                if( in_array($lawAll->id, $lawsIds) )
                {
                    $contenthtml .= '  <div class="am-form-group">
                            <div class="checkbox am-text-left">
                                <label>
                                    <input type="checkbox" checked  value="'.$lawAll->id.'" name="TTcheck" data-val="第'.$lawAll->title_no.'条" class="am-margin-right" style="width: 16px;height: 16px;">
                                    第'.$lawAll->title_no.'条
                                    
                                </label>
                            </div>
                            <div class="check-content am-text-left am-padding-left">
                                '.html_entity_decode(stripslashes($lawAll->content)).'
                            </div>
                        </div>';
                }
            }
        }

        return response()->json([ 'namehtml' => $namehtml, 'title' => $titlehtml, 'contenthtml' => $contenthtml ]);
    }

    /*查看法律法规*/
    public function seeLaw($id)
    {
        $diag_subcontent = DiagSubcontent::find($id);
        $laws = $diag_subcontent->laws;

        $html = '';
        foreach( $laws as $law )
        {
            $html .= ' <tr>
                    <td class="am-text-center am-text-middle">'.$law->name.'</td>
                    <td class="am-text-center am-text-middle">'.$law->title.'</td>
                    <td class="am-text-center am-text-middle">'.$law->title_no.'</td>
                    <td class="am-text-middle am-text-left">
                    '.html_entity_decode(stripslashes($law->content)).'
                    </td>
                </tr>';
        }

        return response()->json([ 'html' => $html ]);
    }

    /*法律法规条例名称联动*/
    public function relateLawName(Request $request)
    {
        $name = $request->get('name');
        $laws = Law::where('name', $name)->get();
        $html = '';
        foreach( $laws as $law )
        {
            $html .= '<option value="'.$law->title.'">'.$law->title.'</option>';
        }

        return response()->json([ 'html' => $html ]);
    }

    /*法规条例文号联动*/
    public function relateLawTitle(Request $request)
    {
        $title = $request->get('title');
        $laws = Law::where('title', $title)->get();
        $html = '';
        foreach( $laws as $law )
        {
            $html .= '  <div class="am-form-group">
                            <div class="checkbox am-text-left">
                                <label>
                                    <input type="checkbox" value="'.$law->id.'" name="TTcheck" data-val="第'.$law->title_no.'条" class="am-margin-right" style="width: 16px;height: 16px;">
                                    第'.$law->title_no.'条
                                    
                                </label>
                            </div>
                            <div class="check-content am-text-left am-padding-left">
                                '.html_entity_decode(stripslashes($law->content)).'
                            </div>
                        </div>';
        }

        return response()->json([ 'html' => $html ]);
    }

    /*保持法律法规*/
    public function editLaw(Request $request, $id)
    {
        $diag_subContent = DiagSubcontent::find($id);
        $law_ids = $request->get('law_ids');

        if( $law_ids )
        {

            $diag_subContent->laws()->detach();
            $diag_subContent->laws()->sync($law_ids);

            $lawIds = Functions::getIds($diag_subContent->laws);
            $is_save = array_intersect($lawIds, $law_ids);

            $isLaws = Functions::isTure($diag_subContent, 'laws');
            $law_title_no = '';
            if( !$isLaws )
            {

                $laws = $diag_subContent->laws;
                foreach( $laws as $law )
                {
                    $law_title_no .= '第'.$law->title_no.'条,';
                }
                $diag_subContent->law = $law_title_no;
            }

            return response()->json($is_save ? [ 'status' => 1, 'msg' => '设置成功', 'laws' => $law_title_no ] : [ 'status' => 0, 'msg' => '设置失败' ]);
        }
    }

    /*保持子账号内容*/
    public function storeSubContent(Request $request, $id)
    {
        $describle = $request->get('describle');
        $suggest = $request->get('suggest');

        $diag_subContent = DiagSubcontent::find($id);
        $diag_subContent->describle = $describle;
        $diag_subContent->suggest = $suggest;
        $diag_subContent->update();

        $is_update = Functions::isUpdate($diag_subContent->updated_at);

        return response()->json($is_update ? [ 'status' => 1, 'msg' => '保存成功', 'describel' => $diag_subContent->describle, 'suggest' => $diag_subContent->suggest ] : [ 'status' => 0, 'msg' => '更新失败' ]);
    }


    /*获取诊断结果具体分析子模块*/
    public function getDiagMod($item, $name,$id = null)
    {

        if($id == null)//进入诊断具体分析时
        {
            $diag_mod = $item->diag_mods()->where('name', $name)->first();
            //是否有诊断结果具体内容
            $isDiagSubMod = Functions::isTure($diag_mod, 'diag_submods');
            if( !$isDiagSubMod )
            {
                $diag_submods = $diag_mod->diag_submods;
                foreach( $diag_submods as $diag_submod )
                {
                    //是否有分配任务
                    $isTask = Functions::isTure($diag_submod, 'tasks');
                    if( !$isTask )
                    {
                        $tasks = $diag_submod->tasks;
                        foreach( $tasks as $task )
                        {
                            $diag_submod->adminUser = $task->admin_users;
                            $diag_submod->task = $task;
                        }
                    }

                    $isSubContents = Functions::isTure($diag_submod, 'diag_subcontents');
                    if( !$isSubContents )
                    {
                        $diag_subContents = $diag_submod->diag_subcontents;
                        foreach( $diag_subContents as $diag_subContent )
                        {
                            $isLaws = Functions::isTure($diag_subContent, 'laws');
                            if( !$isLaws )
                            {

                                $laws = $diag_subContent->laws;
                                $law_title_no = '';
                                foreach( $laws as $law )
                                {
                                    $law_title_no .= '第'.$law->title_no.'条';
                                }
                                $diag_subContent->law = $law_title_no;
                            }
                        }
                    }

                }
            }

            $diag_mod->master = AdminUser::find($diag_mod->fid);

            return $diag_mod;

        }else{

            /*查看后任务状态变为进行中*/
            $diag_submod = DiagSubmod::find($id);
            $isTask = Functions::isTure($diag_submod, 'tasks');
            if( !$isTask )
            {
                $tasks = $diag_submod->tasks;
                foreach( $tasks as $task )
                {
                    $task->status = 1;//查看后任务状态变为进行中
                    $task->update();
                }
            }

            $diag_mod = $diag_submod->diag_mods;

            //是否有诊断结果具体内容
            $isDiagSubMod = Functions::isTure($diag_mod, 'diag_submods');
            if( !$isDiagSubMod )
            {
                $diag_submods = $diag_mod->diag_submods;
                foreach( $diag_submods as $diag_submod )
                {
                    //是否有分配任务
                    $isTask = Functions::isTure($diag_submod, 'tasks');
                    if( !$isTask )
                    {
                        $tasks = $diag_submod->tasks;
                        foreach( $tasks as $task )
                        {
                            $diag_submod->adminUser = $task->admin_users;
                            $diag_submod->task = $task;
                        }
                    }

                    $isSubContents = Functions::isTure($diag_submod, 'diag_subcontents');
                    if( !$isSubContents )
                    {
                        $diag_subContents = $diag_submod->diag_subcontents;
                        foreach( $diag_subContents as $diag_subContent )
                        {
                            $isLaws = Functions::isTure($diag_subContent, 'laws');
                            if( !$isLaws )
                            {

                                $laws = $diag_subContent->laws;
                                $law_title_no = '';
                                foreach( $laws as $law )
                                {
                                    $law_title_no .= '第'.$law->title_no.'条';
                                }
                                $diag_subContent->law = $law_title_no;
                            }else{
                                $diag_subContent->law = '请选择';
                            }
                        }
                    }

                }
            }

            $diag_mod->master = AdminUser::find($diag_mod->fid);

            return $diag_mod;
        }
    }

    /*
     * 诊断报告模板管理
     * type 1:关务管理 2：aeo管理 3：物流管理 4：系统化管理
     * */
    public function tempGuanwu()
    {
        return $this->getDiagModTem(1);
    }

    public function tempAeo()
    {
        return $this->getDiagModTem(2);

    }

    public function tempWuliu()
    {
        return $this->getDiagModTem(3);

    }

    public function tempSystem()
    {
        return $this->getDiagModTem(4);

    }

    public function getDiagModTem($type)
    {
        $diag_mod_tem = DiagModTem::with('diag_submod_tems.diag_subcontent_tems')->where('type',$type)->first();
        if($type == 1){
            if($diag_mod_tem){
                return view('admin.template.diag.diag_module.guanwu.index',compact('diag_mod_tem'));
            }else{
                return view('admin.template.diag.diag_module.guanwu.index');
            }
        }elseif($type == 2){
            if($diag_mod_tem){
                return view('admin.template.diag.diag_module.aeo.index',compact('diag_mod_tem'));
            }else{
                return view('admin.template.diag.diag_module.aeo.index');
            }
        }elseif($type == 3){
            if($diag_mod_tem){
                return view('admin.template.diag.diag_module.wuliu.index',compact('diag_mod_tem'));
            }else{
                return view('admin.template.diag.diag_module.wuliu.index');
            }
        }else{
            if($diag_mod_tem){
                return view('admin.template.diag.diag_module.system.index',compact('diag_mod_tem'));
            }else{
                return view('admin.template.diag.diag_module.system.index');
            }
        }
    }

    public function tempAddMod($id)
    {
        $diag_mod_tem = DiagModTem::find($id);
        $diag_submod_tems = $diag_mod_tem->diag_submod_tems()->latest()->paginate(15);

        return view('admin.template.diag.diag_module.addMod', compact( 'diag_mod_tem','diag_submod_tems'));
    }

    public function tempSubModStore(Request $request, $id)
    {
        $name = $request->input('name');
        $aeo_type = $request->get('aeo_type');
        $trade_type = $request->get('trade_type');

        $diag_submod_tem = new DiagSubmodTem();
        $diag_submod_tem->name = $name;
        $diag_submod_tem->aeo_type = $aeo_type;
        $diag_submod_tem->trade_type = $trade_type;
        $diag_submod_tem->diag_mod_tem_id = $id;
        $diag_submod_tem->save();

        /*是否保存成功*/
        $is_save = Functions::isCreate(DiagSubmodTem::all(), $diag_submod_tem->id);

        if( $is_save )
        {
            Toastr::success('新增成功');
        }else
        {
            Toastr::error('新增失败');
        }

        return redirect(route('template.diags.addmod', $id));
    }

    public function tempSubModEdit($id)
    {
        $diag_submod_tem = DiagSubmodTem::find($id);
        $name = $diag_submod_tem->name;
        $aeo_type = $diag_submod_tem->aeo_type;
        $trade_type = $diag_submod_tem->trade_type;

        if($aeo_type === 0){
            $aeo_html = '<option value="-1">无</option>
                                <option selected value="0">一般认证</option>
                                <option value="1">高级认证</option>';

        }elseif($aeo_type === 1){
            $aeo_html = '<option value="-1">无</option>
                                <option value="0">一般认证</option>
                                <option selected value="1">高级认证</option>';
        }else{
            $aeo_html = '<option selected value="-1">无</option>
                                <option value="0">一般认证</option>
                                <option  value="1">高级认证</option>';
        }

        if($trade_type === 0){
            $trade_html = '<option value="-1">无</option>
                                <option selected value="0">一般贸易</option>
                                <option value="1">加工贸易</option>';

        }elseif($trade_type === 1){
            $trade_html = '<option value="-1">无</option>
                                <option value="0">一般贸易</option>
                                <option selected value="1">加工贸易</option>';
        }else{
            $trade_html = '<option selected value="-1">无</option>
                                <option value="0">一般贸易</option>
                                <option  value="1">加工贸易</option>';
        }

        return response()->json([ 'name' => $name,'aeo_type'=> $aeo_html, 'trade_type'=> $trade_html]);
    }

    public function tempSubModUpdate(Request $request, $id)
    {
        $name = $request->input('name');
        $aeo_type = $request->get('aeo_type');
        $trade_type = $request->get('trade_type');

        $diag_submod_tem = DiagSubmodTem::find($id);
        $diag_submod_tem->name = $name;
        $diag_submod_tem->aeo_type = $aeo_type;
        $diag_submod_tem->trade_type = $trade_type;
        $diag_submod_tem->update();

        /*是否保存成功*/
        $is_save = Functions::isUpdate($diag_submod_tem->updated_at);

        return response()->json($is_save ? [ 'status' => 1, 'msg' => '编辑成功' ] : [ 'status' => 0, 'msg' => '编辑失败' ]);
    }

    public function tempSubModDestroy($id)
    {
        DiagSubmodTem::find($id)->delete();

        /*是否保存成功*/
        $is_del = Functions::isCreate(DiagSubmodTem::withTrashed(), $id);

        return response()->json($is_del ? [ 'status' => 1, 'msg' => '删除成功' ] : [ 'status' => 0, 'msg' => '删除失败' ]);
    }

    public function tempAddContent(Request $request, $id)
    {
        $content = $request->get('content');

        $diag_subCon_tem = new DiagSubcontentTem();
        $diag_subCon_tem->diag_submod_tem_id = $id;
        $diag_subCon_tem->content = $content;
        $diag_subCon_tem->save();

        $is_save = Functions::isCreate(DiagSubcontentTem::all(),$diag_subCon_tem->id);

        return response()->json($is_save ? [ 'status' => 1, 'msg' => '新增成功' ] : [ 'status' => 0, 'msg' => '新增失败' ]);
    }

    public function tempEditContent($id)
    {
        $diag_subCon_tem = DiagSubcontentTem::find($id);
        $content = $diag_subCon_tem->content;

        return response()->json([ 'content' => $content ]);
    }

    public function tempUpdateContent(Request $request, $id)
    {
        $content = $request->get('content');

        $diag_subCon_tem = DiagSubcontentTem::find($id);
        $diag_subCon_tem->content = $content;
        $diag_subCon_tem->update();

        $is_update = Functions::isUpdate($diag_subCon_tem->updated_at);

        return response()->json($is_update ? [ 'status' => 1, 'msg' => '编辑成功' ] : [ 'status' => 0, 'msg' => '更新失败' ]);
    }

    public function tempDelContent($id)
    {
        DiagSubcontentTem::find($id)->delete();

        /*删除机构id集合*/
        $is_delete = Functions::isCreate(DiagSubcontentTem::withTrashed(), $id);

        return response()->json($is_delete ? [ 'status' => 1, 'msg' => '删除成功' ] : [ 'status' => 0, 'msg' => '删除失败' ]);
    }
}