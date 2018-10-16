<?php
/*
 * 材料清单
 * */

namespace App\Http\Controllers\Admin;

use App\Helpers\Functions;
use App\Models\Item;
use App\Models\Material;
use App\Models\MaterialContent;
use App\Models\MaterialContentTemplate;
use App\Models\MaterialTemplate;
use Barryvdh\Snappy\Facades\SnappyImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Style\Font;
use PhpOffice\PhpWord\Style\ListItem;
use PhpOffice\PhpWord\Style\TOC;
use PhpOffice\PhpWord\TemplateProcessor;
use \PhpOffice\PhpWord\PhpWord;
use Yuansir\Toastr\Facades\Toastr;
use PDF;


class MaterialController extends BaseController
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
        $item = Item::with(['material_template_names.material_templates.material_content_templates'
            ,'material_template_names.material_templates.material_contents'])->where('id',$item_id)->first();
        $maters = $item->material_template_names->material_templates;

        /*如果自定义清单*/
        if(!$item->maters->isEmpty())
        {
            $material_selfs = $item->maters;
            return view('admin.item.material.index', compact('item', 'maters','material_selfs'));
        }else{
            return view('admin.item.material.index', compact('item', 'maters'));
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($item_id,$material_id)
    {
        $item = Item::find($item_id);

        return view('admin.item.material.create', compact('item','material_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    /*保存材料清单*/
    public function store(Request $request,$item_id,$material_id)
    {
        $name = $request->get('name');//清单部门名称
        $content = htmlentities(addslashes($request->get('content')));//清单内容

        /*是不是模板*/
        $is_tem = MaterialTemplate::find($material_id);

        //新建材料清单
        $matercon = new MaterialContent();
        $matercon->name = $name;
        $matercon->content = $content;

        if($is_tem){//如果是模板
            $matercon->material_template_id = $material_id;
        }else{
            $matercon->material_id = $material_id;
        }

        $matercon->save();

        /*所有清单部门名称合集*/
        $is_save = Functions::isUpdate($matercon->updated_at);


        $url = route('material.index',[$item_id])."?id".$material_id;

        return response()->json($is_save ? [ 'status' => 1, 'msg' => '新增成功', 'url' => $url ] : [ 'status' => 0, 'msg' => '新增失败', 'url' => $url ]);

    }

    /*更新材料清单*/
    public function update(Request $request,$item_id,$material_id,$id)
    {
        $name = $request->get('name');//清单部门名称
        $content = htmlentities(addslashes($request->get('content')));//清单内容

        $matercon = MaterialContent::find($id);
        $matercon->name = $name;
        $matercon->content = $content;
        $matercon->update();

        /*所有清单部门名称合集*/
        $is_save = Functions::isUpdate($matercon->updated_at);
        $url = route('material.index',[$item_id])."?id".$material_id;

        return response()->json($is_save ? [ 'status' => 1, 'msg' => '更新成功', 'url' => $url ] : [ 'status' => 0, 'msg' => '更新失败', 'url' => $url]);
    }

    /*检查清单名称*/
    public function checkDepart(Request $request,$item_id)
    {
        $department = $request->get('department');//清单部门名称
        /*所有清单部门名称合集*/
        $materDeparts = Item::find($item_id)->maters->pluck('department')->toArray();
        $is_true = in_array($department, $materDeparts);

        return response()->json($is_true ? [ 'status' => 1, 'msg' => '名称已经存在' ] : [ 'status' => 0 ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($item_id,$material_id,$id)
    {
        $item = Item::find($item_id);
        $mater_content = MaterialContent::find($id);

        return view('admin.item.material.edit', compact('item', 'mater_content','material_id'));
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
        MaterialContent::find($id)->delete();
        $is_del = Functions::isCreate(MaterialContent::withTrashed(),$id);

        return response()->json($is_del ? [ 'status' => 1, 'msg' => '成功删除' ] : [ 'status' => 0, 'msg' => '删除失败' ]);

    }

    /*在线预览*/
    public function preview($item_id)
    {
        $item = Item::find($item_id);

        return view('admin.item.material.preview.preview', compact('item'));
    }

    /*预览清单信息*/
    public function previewMsg($item_id)
    {
        $item = Item::find($item_id);

        return view('admin.item.material.preview.preview1', compact('item'));
    }

    /*预览清单信息*/
    public function previewData($item_id)
    {
        $item = Item::with('material_template_names.material_templates.material_content_templates')
            ->where('id',$item_id)->first();
        $maters = $item->material_template_names->material_templates;

        /*如果自定义清单*/
        if(!$item->maters->isEmpty())
        {
            $material_selfs = $item->maters;
            return view('admin.item.material.preview.preview2', compact('item','maters','material_selfs'));
        }else{
            return view('admin.item.material.preview.preview2', compact('item','maters'));
        }
    }

    /*交付客户*/
    public function active($item_id)
    {
        $item = Item::find($item_id);
        $item->material_active = 1;
        $item->material_active_time = Carbon::now();
        $item->update();

        if($item->material_active == 1){
            Toastr::success('交付成功');
        }else{
            Toastr::error('交付失败');
        }

        return redirect(route('material.index',[$item_id]));
    }

    /*模块管理*/
    public function addMod($item_id)
    {
        $item = Item::with('material_template_names.material_templates')->where('id',$item_id)->first();

        $material_template_names =$item->material_template_names;
        $materials = $material_template_names->material_templates()->get();

        /*如果自定义清单*/
        if(!$item->maters->isEmpty())
        {
            $material_selfs = $item->maters;
            return view('admin.item.material.addMod', compact('item', 'materials','material_selfs'));
        }else{
            return view('admin.item.material.addMod', compact('item', 'materials'));
        }
    }

    /*保存模块*/
    public function subModStore(Request $request,$item_id)
    {
        $department = $request->input('department');
//        $aeo_type = $request->input('aeo_type');
//        $trade_type = $request->input('trade_type');

        $materN = new Material();
        $materN->department = $department;
//        $materN->aeo_type = $aeo_type;
//        $materN->trade_type = $trade_type;
        $materN->item_id = $item_id;
        $materN->save();

        /*所有清单部门名称合集*/
        $is_save = Functions::isCreate(Item::find($item_id)->maters,$materN->id);

        if($is_save){
            Toastr::success('新增成功');
        }else{
            Toastr::error('新增失败');
        }

        return redirect(route('material.addmod',[$item_id]));
    }

    /*编辑模块*/
    public function subModEdit($id)
    {
        $material = Material::find($id);
        $department = $material->department;

        return response()->json(['department' => $department]);
    }

    /*更新模块*/
    public function subModUpdate(Request $request, $id)
    {
        $department = $request->input('department');
//        $aeo_type = $request->input('aeo_type');
//        $trade_type = $request->input('trade_type');

        $material = Material::find($id);
        $material->department = $department;
//        $material->aeo_type = $aeo_type;
//        $material->trade_type = $trade_type;
        $material->update();

        /*是否保存成功*/
        $is_save = Functions::isUpdate($material->updated_at);

        return response()->json($is_save ? ['status' => 1, 'msg' => '编辑成功' ] : ['status' => 0, 'msg' => '更新失败' ]);
    }

    /*删除模块*/
    public function subModDestroy($id)
    {
        $material = Material::find($id);
//        $item_id = $material->items->id;

        $material->delete();

        /*是否保存成功*/
        $is_del = Functions::isCreate(Material::withTrashed(),$id);

        return response()->json($is_del ? ['status' => 1, 'msg' => '删除成功' ] : ['status' => 0, 'msg' => '删除失败' ]);

    }

    /*清单模版管理*/
    public function temp($id)
    {
        $maters = MaterialTemplate::with('material_content_templates')->where('material_template_name_id',$id)->get();

        return view('admin.template.material.index',compact('maters'));
    }

    /*模版部门管理*/
    public function depart()
    {
        $materials = MaterialTemplate::paginate(15);
        return view('admin.template.material.addMod',compact('materials'));
    }

    /*模版部门管理保存*/
    public function tempStore(Request $request,$id)
    {
        $department = $request->get('department');
//        $aeo_type = $request->input('aeo_type');
//        $trade_type = $request->input('trade_type');

        $mater = new MaterialTemplate();
        $mater->department = $department;
//        $mater->aeo_type = $aeo_type;
//        $mater->trade_type = $trade_type;
        $mater->material_template_name_id = $id;
        $mater->save();

        $is_save = Functions::isCreate(MaterialTemplate::all(),$mater->id);
        if($is_save){
            Toastr::success('新增成功');
        }else{
            Toastr::error('新增失败');
        }

        return redirect(route('template.material',[$mater->material_template_names->id]));

    }

    /*模版部门管理编辑*/
    public function tempEdit($id)
    {

        $mater = MaterialTemplate::find($id);
        $department = $mater->department;

        return response()->json(['department' => $department]);

    }

    /*模版部门管理更新*/
    public function tempUpdate(Request $request,$id)
    {
        $department = $request->get('department');
//        $aeo_type = $request->input('aeo_type');
//        $trade_type = $request->input('trade_type');

        $mater = MaterialTemplate::find($id);
        $mater->department = $department;
//        $mater->aeo_type = $aeo_type;
//        $mater->trade_type = $trade_type;
        $mater->update();

        $is_save = Functions::isUpdate($mater->updated_at);

        return response()->json($is_save ? ['status' => 1,'msg' => '更新成功'] :  ['status' => 0,'msg' => '更新失败']);
    }
    
    /*模版部门管理删除*/
    public function tempDestroy($id)
    {
        MaterialTemplate::find($id)->delete();
        $is_del = Functions::isCreate(MaterialTemplate::withTrashed(),$id);
        return response()->json($is_del ? ['status' => 1,'msg' => '删除成功'] :  ['status' => 0,'msg' => '删除失败']);

    }

    /*模板内容新增*/
    public function temp_create($material_id)
    {
        $material = MaterialTemplate::with('material_template_names')->where('id',$material_id)->first();
        $material_name_id = $material->material_template_names->id;

        return view('admin.template.material.create', compact('material_id','material_name_id'));
    }

    /*模板内容编辑*/
    public function temp_edit($material_id)
    {

        $material_tem = MaterialContentTemplate::with('material_templates.material_template_names')
            ->where('id',$material_id)->first();
        $material_name_id = $material_tem->material_templates->material_template_names->id;

        return view('admin.template.material.edit', compact('material_tem','material_name_id'));
    }

    /*模板内容保存*/
    public function temp_store(Request $request,$material_id)
    {
        $name = $request->get('name');
        $content = $request->get('content');

        $material_tem_con  = new MaterialContentTemplate();
        $material_tem_con ->name = $name;
        $material_tem_con ->content = $content;
        $material_tem_con ->material_template_id = $material_id;
        $material_tem_con ->save();

        $material = MaterialTemplate::with('material_template_names')->where('id',$material_id)->first();
        $material_name_id = $material->material_template_names->id;

        $is_save = Functions::isCreate(MaterialContentTemplate::all(),$material_tem_con->id);

        return response()->json($is_save ? ['status' => 1,'msg' => '新增成功','url' => route('template.material',[$material_name_id])] :  ['status' => 0,'msg' => '新增失败']);
    }

    /*模板内容更新*/
    public function temp_update(Request $request,$material_id)
    {
        $name = $request->get('name');
        $content = $request->get('content');

        $material_tem_con  = MaterialContentTemplate::find($material_id);
        $material_tem_con ->name = $name;
        $material_tem_con ->content = $content;
        $material_tem_con ->update();

        $material = MaterialContentTemplate::with('material_templates.material_template_names')->where('id',$material_id)->first();
        $material_name_id = $material->material_templates->material_template_names->id;

        $is_save = Functions::isUpdate($material_tem_con->updated_at);

        return response()->json($is_save ? ['status' => 1,'msg' => '更新成功','url' => route('template.material',[$material_name_id])] : ['status' => 0,'msg' => '更新失败']);
    }

    /*模板内容删除*/
    public function temp_destroy($material_id)
    {
        MaterialContentTemplate::find($material_id)->delete();
        $is_del = Functions::isCreate(MaterialContentTemplate::withTrashed(),$material_id);

        return response()->json($is_del ? ['status' => 1,'msg' => '删除成功'] :  ['status' => 0,'msg' => '删除失败']);
    }


    /*清单导出word*/
    public function exportWord($item_id)
    {
        $item = Item::with(['material_template_names.material_templates.material_content_templates'
            ,'material_template_names.material_templates.material_contents'])->where('id',$item_id)->first();

        $phpword = new PhpWord();
        //设置默认样式
        $phpword->setDefaultFontName('宋体');//字体
        $phpword->setDefaultFontSize(12);//字号

        //段落默认样式
        $phpword->setDefaultParagraphStyle(
            array(
                'alignment'  => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
                'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(12),
                'spaceBefore' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(14),
                'spacing'    => 0,
            )
        );
        //        表格样式
        $styleTable = [
            'borderColor' => '000',
            'borderSize' => 1,
            'cellMarginTop' => 0,
            'cellMarginRight' => 200,
            'cellMarginBottom' => 0,
            'cellMarginLeft' => 200,
            'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER
        ];

        $styleTableF = [
            'borderColor' => 'FFFFFF',
            'borderSize' => 1,
            'cellMarginTop' => 0,
            'cellMarginRight' => 60,
            'cellMarginBottom' => 0,
            'cellMarginLeft' => 60,
            'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER
        ];

        $styleFirstRow = ['bgColor' => '66BBFF'];//第一行样式
        $fancyTableTextStyle = array('bold' => true);
        $fancyTableTextAlgin = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START);
        $fancyTableCellSpan2 = array('gridSpan' => 2, 'valign' => 'center',);
        $fancyTableCellSpan3 = array('gridSpan' => 3, 'valign' => 'center',);
        $fancyTableCellSpan5 = array('gridSpan' => 5, 'valign' => 'center',);
        $fancyTableCellSpan6 = array('gridSpan' => 6, 'valign' => 'center',);
        $fancyTableCellvMerge = array('vMerge' => 'restart', 'valign' => 'center');
        $fancyTableCellcontinue = array('vMerge' => 'continue');

        $sectionF =  $phpword->addSection([
            'paperSize' => 'A4',
            'marginLeft' => 0,
            'marginRight' => 0,
            'marginTop' => 1000,
            'marginBottom' => 0,
            'footerHeight'  => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(1.64),
            'headerHeight'  => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(1.64),
        ]);

        $imageStyle = [
            'width'            => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(21.00),
            'height'           => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(29.7),
            'marginLeft' => 0,
            'marginRight' => 0,
            'marginTop' => 0,
            'marginBottom' => 0,
            'positioning'   => 'absolute',
            'posHorizontal'    => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_RIGHT,
            'posHorizontalRel' => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,
            'posVerticalRel'   => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,
        ];
        $header = $sectionF->addHeader();
        $header->addWatermark(public_path().'/logo.png', $imageStyle);
        $sectionF->addTextBreak(4);
        $sectionF->addText('跨易通', [
            'name' => '微软雅黑',
            'size' => 46,
            'color' => '0068ce',
            'bold' => true,
        ]);

        $sectionF->addText('供应链定制化服务	', [
            'name' => '微软雅黑',
            'size' => 46,
            'color' => '0068ce',
            'bold' => true,
        ]);
        $sectionF->addTextBreak(8);
        $table = $sectionF->addTable($styleTableF);
        $table->addRow(400,array('exactHeight' => true));//行高400

        $tableparagstype = [
            'line-height' => 1,
            'space' => array('before' => 0, 'after' => 0),
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START,
        ];

        $tabletexgtstype = [
            'name' => '宋体',
            'size' => 10,
            'color' => 'FFFFFF',
        ];

        $table->addCell(1500,['valign' => 'center'])->addText('方案编号：',$tabletexgtstype,$tableparagstype);
        $table->addCell(3000,['valign' => 'center'])->addText('GP-KYT-2017011601',$tabletexgtstype,$tableparagstype);
        $table->addRow(400,array('exactHeight' => true));//行高400
        $table->addCell(null,['valign' => 'center'])->addText('文档名称：',$tabletexgtstype,$tableparagstype);
        $table->addCell(null,['valign' => 'center'])->addText('跨易通供应链定制化服务',$tabletexgtstype,$tableparagstype);
        $table->addRow(400,array('exactHeight' => true));//行高400
        $table->addCell(null,['valign' => 'center'])->addText('安全级别：',$tabletexgtstype,$tableparagstype);
        $table->addCell(null,['valign' => 'center'])->addText('机密',$tabletexgtstype,$tableparagstype);
        $table->addRow(400,array('exactHeight' => true));//行高400
        $table->addCell(null,['valign' => 'center'])->addText('当前版本：',$tabletexgtstype,$tableparagstype);
        $table->addCell(null,['valign' => 'center'])->addText('V1.0',$tabletexgtstype,$tableparagstype);
        $table->addRow(400,array('exactHeight' => true));//行高400
        $table->addCell(null,['valign' => 'center'])->addText('文档提供：',$tabletexgtstype,$tableparagstype);
        $table->addCell(null,['valign' => 'center'])->addText('深圳市东华供应链科技有限公司',$tabletexgtstype,$tableparagstype);
        $table->addRow(400,array('exactHeight' => true));//行高400
        $table->addCell(null,['valign' => 'center'])->addText('建立日期：',$tabletexgtstype,$tableparagstype);

        $table->addCell(null,['valign' => 'center'])->addText($item->created_at->toDateString(),$tabletexgtstype,$tableparagstype);
        $table->addRow(400,array('exactHeight' => true));//行高400
        $table->addCell(null,['valign' => 'center'])->addText('审核日期：',$tabletexgtstype,$tableparagstype);
        $table->addCell(null,['valign' => 'center'])->addText(Carbon::now()->toDateString(),$tabletexgtstype,$tableparagstype);

        //添加页面
        $section = $phpword->addSection([
            'paperSize' => 'A4',
            'marginLeft' => 0,
            'marginRight' => 0,
            'marginTop' => 0,
            'marginBottom' => 0,
            'footerHeight'  => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(1.64),
            'headerHeight'  => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(1.64),
        ]);

        $section->addText($item->hands->name,   [
            'name' => '宋体',
            'size' => 18,
            'color' => 'black',
            'bold' => true,
            ]);
        $section->addText('供应链定制化服务风险诊断审核清单	',  [
            'name' => '宋体',
            'size' => 18,
            'color' => 'black',
            'bold' => true,
        ]);

        $phpword->addTableStyle('myTable', $styleTable, $styleFirstRow);

        $table = $section->addTable('myTable');

        $table->addRow();//行高400
        $table->addCell(null)->addText('审核项目',$fancyTableTextStyle);
        $table->addCell(null,$fancyTableCellSpan6)->addText('供应链定制化服务风险诊断审核清单',null,$fancyTableTextAlgin);

        $table->addRow();//行高400
        $table->addCell(null)->addText('审核地点',$fancyTableTextStyle);
        $table->addCell(null,$fancyTableCellSpan3)->addText($item->hands->users->address,null,$fancyTableTextAlgin);
        $table->addCell(null,$fancyTableCellSpan2)->addText('审核需用时间',$fancyTableTextStyle);
        $table->addCell(null)->addText('2天',null,$fancyTableTextAlgin);

        $table->addRow();
        $table->addCell(null,$fancyTableCellvMerge)->addText('审核机构',$fancyTableTextStyle);
        $table->addCell(null)->addText('名    称');
        $table->addCell(null,$fancyTableCellSpan5)->addText($item->hands->meches->name,$fancyTableTextAlgin);

        $table->addRow();
        $table->addCell(null, $fancyTableCellcontinue);
        $table->addCell(null)->addText('通信地址');
        $table->addCell(null,$fancyTableCellSpan3)->addText($item->hands->meches->address,null,$fancyTableTextAlgin);
        $table->addCell(null)->addText('邮政编码');
        $table->addCell(null)->addText($item->hands->meches->zip_code,null,$fancyTableTextAlgin);

        $table->addRow();
        $table->addCell(1250, $fancyTableCellcontinue);
        $table->addCell(1250)->addText('负 责 人');
        $table->addCell(1250)->addText($item->hands->meches->master,null,$fancyTableTextAlgin);
        $table->addCell(1250)->addText('电  话');
        $table->addCell(2500)->addText($item->hands->meches->master_tel,null,$fancyTableTextAlgin);
        $table->addCell(1250)->addText('传  真');
        $table->addCell(2500)->addText($item->hands->meches->master_fax,null,$fancyTableTextAlgin);

        $table->addRow();
        $table->addCell(null,$fancyTableCellcontinue);
        $table->addCell(null)->addText('项目督导');
        $table->addCell(null)->addText($item->hands->meches->super,null,$fancyTableTextAlgin);
        $table->addCell(null)->addText('电  话');
        $table->addCell(null)->addText($item->hands->meches->super_tel,null,$fancyTableTextAlgin);
        $table->addCell(null)->addText('传  真');
        $table->addCell(null)->addText($item->hands->meches->super_fax,null,$fancyTableTextAlgin);

        $table->addRow();
        $table->addCell(null,$fancyTableCellcontinue);
        $table->addCell(null)->addText('审核团队');
        $table->addCell(null,$fancyTableCellSpan5)->addText($item->hands->meches->verify_team,null,$fancyTableTextAlgin);

        $table->addRow();
        $table->addCell(null, $fancyTableCellcontinue);
        $table->addCell(null)->addText('电子信箱');
        $table->addCell(null,$fancyTableCellSpan5)->addText($item->hands->meches->email,null,$fancyTableTextAlgin);

        $maters = $item->material_template_names->material_templates;

        $departments = '';//部门集合
        foreach($maters as $mater){
            $departments .= '、' . $mater->department;
        }

        /*如果自定义清单*/
        if( !$item->maters->isEmpty() ){
            $material_selfs = $item->maters;

            foreach($material_selfs as $mater){//部门集合
                $departments .= '、' . $mater->department;
            }

            $this->exprotWordTable($table,$maters,$material_selfs,$fancyTableTextAlgin);
        }else{
            $this->exprotWordTable($table,$maters,null,$fancyTableTextAlgin);
        }

        $table->addRow();
        $table->addCell(null,[ 'valign' => 'center'])
            ->addText('审核范围',['bold' => true]);
        $table->addCell(null,['gridSpan' => 6, 'valign' => 'center'])
            ->addText('包括但不限于上表所列'.$departments.'等部门信息及企业现场管理情况。必要时，可根据实际情况扩大调查范围并提取相关信息。',null, $fancyTableTextAlgin);


        //页眉与页脚
        $header = $section->addHeader();
        $footer = $section->addFooter();

        $imageStyleHeader = [
            'width'            => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(20.80),
            'height'           => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(1.64),
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
            'marginLeft' => 15,
            'marginRight' => 15,
            'marginTop' => 15,
            'marginBottom' => 15
        ];

        $imageStyleFooter = [
            'width'            => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(20.80),
            'height'           => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(1.26),
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
            'marginLeft' => 15,
            'marginRight' => 15,
            'marginTop' => 15,
            'marginBottom' => 15
        ];

        $header->addImage(public_path().'/header.png', $imageStyleHeader);
        $footer->addImage(public_path().'/footer.png', $imageStyleFooter);

        //生成的文档为Word2007
        $writer = IOFactory::createWriter($phpword, 'Word2007');

        $name = $item->hands->users->name.'_材料清单报告.doc';
        $writer->save($name);
        /*下载文档*/
        return response()->download(realpath(base_path('public')).'/'. $name, $name);
    }

    /*导出word表格*/
    public function exprotWordTable($table,$objs,$obj_selfs=null,$fancyTableTextAlgin)
    {
        foreach($objs as $key_obj => $obj){
            if(!$obj->material_content_templates->isEmpty()){
                foreach($obj->material_content_templates as $key => $material_con){
                    $material_con->content = str_replace('</p>','<w:br/>',html_entity_decode(stripslashes($material_con->content)));
                    $material_con->content = str_replace('<p>','',html_entity_decode(stripslashes($material_con->content)));
                    if($key == 0){
                        $table->addRow();
                        $table->addCell(null,['vMerge' => 'restart', 'valign' => 'center'])
                            ->addText('审核所涉及的资料',['bold' => true]);
                        $table->addCell(null,['vMerge' => 'restart', 'valign' => 'center'])
                            ->addText($obj->department,['bold' => true]);
                        $table->addCell(null,['valign' => 'center'])->addText($material_con->name,['bold' => true]);
//                        dd(str_replace('</p>','<w:br/>',html_entity_decode(stripslashes($material_con->content))));
                        $table->addCell(null,['gridSpan' => 4, 'valign' => 'center'])
                            ->addText($material_con->content,null, $fancyTableTextAlgin);

                    }else{
                        $table->addRow();
                        $table->addCell(null,['vMerge' => 'continue']);
                        $table->addCell(null,['vMerge' => 'continue']);
                        $table->addCell(null,['valign' => 'center'])->addText($material_con->name,['bold' => true]);
                        $table->addCell(null,['gridSpan' => 4, 'valign' => 'center'])
                            ->addText($material_con->content,null, $fancyTableTextAlgin);
                    }
                }

            }else{
                if($key_obj == 0){
                    $table->addRow();
                    $table->addCell(null,['vMerge' => 'restart', 'valign' => 'center'])
                        ->addText('审核所涉及的资料',['bold' => true]);
                    $table->addCell(null,['valign' => 'center'])
                        ->addText($obj->department,['bold' => true]);
                    $table->addCell(null,['valign' => 'center'])->addText('',['bold' => true]);
                    $table->addCell(null,['gridSpan' => 4, 'valign' => 'center'])
                        ->addText('',null,$fancyTableTextAlgin);

                }else{
                    $table->addRow();
                    $table->addCell(null,['vMerge' => 'continue']);
                    $table->addCell(null,['valign' => 'center'])
                        ->addText($obj->department,['bold' => true]);
                    $table->addCell(null,['valign' => 'center'])->addText('',['bold' => true]);
                    $table->addCell(null,['gridSpan' => 4, 'valign' => 'center'])
                        ->addText('',null, $fancyTableTextAlgin);
                }
            }

            if(!$obj->material_contents->isEmpty()){
                    foreach($obj->material_contents as $key => $material_con){
                        $material_con->content = str_replace('</p>','<w:br/>',html_entity_decode(stripslashes($material_con->content)));
                        $material_con->content = str_replace('<p>','',html_entity_decode(stripslashes($material_con->content)));
                        if($key == 0){
                            $table->addRow();
                            $table->addCell(null,['vMerge' => 'restart', 'valign' => 'center'])
                                ->addText('审核所涉及的资料',['bold' => true]);
                            $table->addCell(null,['vMerge' => 'restart', 'valign' => 'center'])
                                ->addText($obj->department,['bold' => true]);
                            $table->addCell(null,['valign' => 'center'])->addText($material_con->name,['bold' => true]);
                            $table->addCell(null,['gridSpan' => 4, 'valign' => 'center'])
                                ->addText($material_con->content,null,$fancyTableTextAlgin);
                        }else{
                            $table->addRow();
                            $table->addCell(null,['vMerge' => 'continue']);
                            $table->addCell(null,['vMerge' => 'continue']);
                            $table->addCell(null,['valign' => 'center'])->addText($material_con->name,['bold' => true]);
                            $table->addCell(null,['gridSpan' => 4, 'valign' => 'center'])
                                ->addText($material_con->content,null,$fancyTableTextAlgin);
                        }
                    }
                }
        }

        if($obj_selfs){
            foreach($obj_selfs as $key_obj => $obj){
                if(!$obj->material_contents->isEmpty()){
                    foreach($obj->material_contents as $key => $material_con){
                        if($key == 0){
                            $table->addRow();
                            $table->addCell(null,['vMerge' => 'restart', 'valign' => 'center'])
                                ->addText('审核所涉及的资料',['bold' => true]);
                            $table->addCell(null,['vMerge' => 'restart', 'valign' => 'center'])
                                ->addText($obj->department,['bold' => true]);
                            $table->addCell(null,['valign' => 'center'])->addText($material_con->name,['bold' => true]);
                            $table->addCell(null,['gridSpan' => 4, 'valign' => 'center'])
                                ->addText($material_con->content,null,$fancyTableTextAlgin);
                        }else{
                            $table->addRow();
                            $table->addCell(null,['vMerge' => 'continue']);
                            $table->addCell(null,['vMerge' => 'continue']);
                            $table->addCell(null,['valign' => 'center'])->addText($material_con->name,['bold' => true]);
                            $table->addCell(null,['gridSpan' => 4, 'valign' => 'center'])
                                ->addText($material_con->content,null,$fancyTableTextAlgin);
                        }
                    }

                }else{
                    if($key_obj == 0){
                        $table->addRow();
                        $table->addCell(null,['vMerge' => 'restart', 'valign' => 'center'])
                            ->addText('审核所涉及的资料',['bold' => true]);
                        $table->addCell(null,['valign' => 'center'])
                            ->addText($obj->department,['bold' => true]);
                        $table->addCell(null,['valign' => 'center'])->addText('',['bold' => true]);
                        $table->addCell(null,['gridSpan' => 4, 'valign' => 'center'])
                            ->addText('',null,$fancyTableTextAlgin);

                    }else{
                        $table->addRow();
                        $table->addCell(null,['vMerge' => 'continue']);
                        $table->addCell(null,['valign' => 'center'])
                            ->addText($obj->department,['bold' => true]);
                        $table->addCell(null,['valign' => 'center'])->addText('',['bold' => true]);
                        $table->addCell(null,['gridSpan' => 4, 'valign' => 'center'])
                            ->addText('',null,$fancyTableTextAlgin);
                    }
                }
            }
        }

    }

    /*清单导出pdf*/
    public function exportPdf($item_id)
    {

        $hand = Item::find($item_id)->hands;
        $user = $hand->users;
        $pdf = PDF::loadView('print',compact('hand','user'))
            ->setOption('background',true)
            ->setPaper('a4')
            ->setOrientation('Portrait')
            ->setOption('custom-header',['content-type' => 'text/html'])
            ->setOption('encoding','UTF-8')
            ->setOption('margin-bottom','3mm')
            ->setOption('margin-top','3mm')
            ->setOption('margin-left','3mm')
            ->setOption('margin-right','3mm')
            ->setOption('images',true);

        return $pdf->inline('invoice.pdf');
    }
}
