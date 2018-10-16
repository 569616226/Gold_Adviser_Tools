<?php
/*
 *
 * 服务反馈
 * */

namespace App\Http\Controllers;

use App\Helpers\Functions;

use App\Models\Item;
use App\Models\Suggest;
use App\Models\UserDepart;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

    public function index($item_id)
    {

        $TaskCount = 0;
        $item = Item::find($item_id);

        $is_task = Functions::isTure($item,'tasks');
        if(!$is_task){
            $tasks = $item->tasks()->where('status',4)
                ->where('tasktable_type','App\Models\ImproveConTem')
                ->get();

            foreach($tasks as $task){
                $is_suggest = Functions::isTure($task,'suggests','one');
                if(!$is_suggest && $task->suggests->score == -1){
                    $TaskCount++;
                }
            }
        }

        return view('suggest.index', compact('item', 'tasks','TaskCount'));
    }

    /*
     * 客户评价
     *
     * */
    public function store(Request $request,$id)
    {
        $score = $request->get('score');//满意度
        $content = $request->get('content');//客户建议

        $suggest = Suggest::find($id);
        $suggest->score = $score;
        $suggest->content = $content;
        $suggest->update();

        /*是否保存成功*/
        $is_save = Functions::isUpdate($suggest->updated_at);

        if( $is_save )
        {
            Toastr::success('评价成功');
        }else
        {
            Toastr::error('评价失败');
        }

        return redirect(route('guest.suggest.index',[$suggest->tasks->items->id]));

    }

    /*查看服务反馈表*/
    public function show($id)
    {
        $suggest = Suggest::find($id);
        $suggest = Functions::getAdviseNo($suggest);

        return view('suggest.show', compact('suggest'));
    }

    /*评介服务反馈表*/
    public function edit($id)
    {
        $suggest = Suggest::find($id);


        return view('suggest.edit', compact('suggest'));
    }
}
