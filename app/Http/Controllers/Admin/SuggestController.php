<?php
/*
 *
 * 服务反馈
 * */

namespace App\Http\Controllers\Admin;

use App\Helpers\Functions;
use App\Models\Advise;
use App\Models\Suggest;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Task;
use Yuansir\Toastr\Facades\Toastr;

class SuggestController extends BaseController
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
    public function index($item_id,$id)
    {
        $task = Task::find($id);
        $item = Item::find($item_id);//项目图片

        $is_suggest = Functions::isTure($task,'suggests','one');
        if($is_suggest){
            return view('admin.item.task.suggest.index',compact('task' ,'item'));
        }else{
            $suggest = $task->suggests;
            return view('admin.item.task.suggest.index',compact('task' ,'item','suggest'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($item_id,$id)
    {

        $item = Item::find($item_id);//项目图片
        $task = Task::find($id);

        $suggest = Functions::getAdviseNo($task->suggests);

        return view('admin.item.task.suggest.show',compact('item','task','suggest'));
    }

    /*保存服务反馈表*/
    public function store(Request $request,$id)
    {
        $remark = $request->get('remark');
        $service_remark = $request->get('service_remark');
        $contacs = $request->get('contacs');
        $task = Task::find($id);
        $item_id = $task->items->id;
        $user_id = $task->items->hands->users->id;

        $is_suggest = Functions::isTure($task,'suggests','one');
        if($is_suggest){
            $suggest = new Suggest();
            $suggest->remark = $remark;
            $suggest->service_remark = $service_remark;
            $suggest->task_id = $id;
            $suggest->score = -1;
            $suggest->active = 0;
            $suggest->user_id = $user_id;
            $suggest->save();

            $suggest->tasks->status = 4;
            $suggest->tasks->update();

            $is_save = Functions::isCreate(Suggest::all(),$suggest->id);
            $isSave = true;

            if(count($contacs) >= 1){
                foreach($contacs as $contac){
                    $advise = new Advise();
                    $advise->title = $contac['title'];
                    $advise->content = $contac['content'];
                    $advise->plan_date = $contac['plan_date'];
                    $advise->suggest_id = $suggest->id;
                    $advise->save();
                }

                if($suggest->advises->count() == count($contacs)){
                    $isSave = true;
                }else{
                    $isSave = false;
                }
            }

            return response()->json($is_save && $isSave ? ['status' => 1 ,'msg' =>'新增成功','onurl' => '/admin/item/'.$item_id.'/suggest/show/'.$id] : ['status' => 0 ,'msg' =>'新增失败'] );
        }else{

            $suggest = $task->suggests;
            if($suggest->score == -1){
                $suggest->remark = $remark;
                $suggest->service_remark = $service_remark;
                $suggest->update();

                $is_update = Functions::isUpdate($suggest->updated_at);

                if(count($contacs) >= 1){
                    foreach($contacs as $contac){
                        if(isset($contac['advise_id'])){
                            $advise = Advise::find($contac['advise_id']);
                            $advise->title = $contac['title'];
                            $advise->content = $contac['content'];
                            $advise->plan_date = $contac['plan_date'];
                            $advise->update();

                        }else{
                            $advise = new Advise();
                            $advise->title = $contac['title'];
                            $advise->content = $contac['content'];
                            $advise->plan_date = $contac['plan_date'];
                            $advise->suggest_id = $suggest->id;
                            $advise->save();
                        }
                    }
                }

                $advise_count = count($contacs) - $suggest->advises->count();
                $msg = '保存成功';
                if($advise_count !== 0){
                    $msg .= '，并有'.$advise_count.'条服务问题新增失败';
                }

                return response()->json($is_update ? ['status' => 1 ,'msg' =>$msg,'onurl' => '/admin/item/'.$item_id.'/suggest/show/'.$id] : ['status' => 0 ,'msg' =>'新增失败'] );
            }else{
                return response()->json( ['status' => 0 ,'msg' =>'客户已经评价不能修改'] );
            }

        }

    }

    public function active($id)
    {
        $suggest = Suggest::find($id);
        $suggest->active = 1;
        $suggest->update();

        $is_update = Functions::isUpdate($suggest->updated_at);

        if($is_update){
            Toastr::success('提交成功');
        }else{
            Toastr::error('提交失败');
        }
        return redirect(route('suggest.index',[$suggest->tasks->items->id,$suggest->tasks->id]));
    }
}
