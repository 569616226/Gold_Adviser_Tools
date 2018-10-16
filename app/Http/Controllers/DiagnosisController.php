<?php
/*
 *
 * 诊断报告
 * */

namespace App\Http\Controllers;

use App\Helpers\Functions;
use App\Models\Item;
use App\Models\UserDepart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class DiagnosisController extends BaseController
{
    /**
     * CustomerController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }
    //在线预览封面
    public function preview($item_id)
    {
        $item = Item::find($item_id);

        return view('diag.preview.preview',compact('item'));
    }

    //在线预览清单信息
    public function previewMsg($item_id)
    {
        $item = Item::find($item_id);

        return view('diag.preview.preview1',compact('item'));
    }

    //在线预览清单审核资料
    public function previewData($item_id)
    {

        $item = Item::find($item_id);
        $diag_mods = $item->diag_mods;


        return view('diag.preview.preview2',compact('item','diag_mods'));
    }

    //在线预览企业背景
    public function previewCompany($item_id)
    {
        $item = Item::find($item_id);
        $item->hands->users->create_date = Carbon::parse($item->hands->users->create_date);

        return view('diag.preview.preview4',compact('item'));
    }

    //在线预览附录
    public function previewClosure($item_id)
    {
        $item = Item::find($item_id);
        $laws = [];

        $diag_mods= $item->diag_mods()->with('diag_submods')->get();//诊断报告引用法律法规
        foreach($diag_mods as $diag_mod){
            $diag_submods = $diag_mod->diag_submods()->with('diag_subcontents')->get();
            foreach($diag_submods as $diag_submod){
                $diag_subcontents = $diag_submod->diag_subcontents()->with('laws')->get();
                foreach($diag_subcontents as $diag_subcontent){
                    foreach($diag_subcontent->laws as $law){
                        array_push($laws,$law);
                    }
                }
            }
        }
        return view('diag.preview.preview3',compact('item','laws'));
    }

}
