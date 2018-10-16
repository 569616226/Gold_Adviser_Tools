<?php
/*
 *
 * 材料清单
 * */

namespace App\Http\Controllers;

use App\Helpers\Functions;
use App\Models\Item;
use App\Models\MaterialDepart;
use App\Models\MaterialTemplate;
use App\Models\UserDepart;
use Illuminate\Http\Request;

class MaterialController extends BaseController
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

        return view('material.preview.preview',compact('item'));
    }

    //在线预览清单信息
    public function previewMsg($item_id)
    {
        $item = Item::find($item_id);

        return view('material.preview.preview1',compact('item'));
    }

    //在线预览清单审核资料
    public function previewData($item_id)
    {
        $item = Item::with('material_template_names.material_templates.material_content_templates')->where('id',$item_id)->first();
        $maters = $item->material_template_names->material_templates;

        /*如果自定义清单*/
        if(!$item->maters->isEmpty())
        {
            $material_selfs = $item->maters;
            return view('material.preview.preview2', compact('item','maters','material_selfs'));
        }else{
            return view('material.preview.preview2', compact('item','maters'));
        }
    }

}
