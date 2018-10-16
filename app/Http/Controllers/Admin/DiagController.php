<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Functions;
use App\Models\Diag;
use App\Models\Item;
use App\Models\ItemData;
use App\Models\Law;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Style\TOC;
use Yuansir\Toastr\Facades\Toastr;

class DiagController extends BaseController
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
        $diags = $item->diags;

        foreach( $diags as $diag )
        {
            //是否有分配任务
            $isTask = Functions::isTure($diag, 'tasks');
            if(!$isTask)
            {
                $tasks = $diag->tasks;
                foreach( $tasks as $task )
                {
                    $adminUser = $task->admin_users;
                    $diag->task = $task;
                    $diag->adminUser = $adminUser;
                }
            }
        }

        /*
          * 排序按角色是否是经理排序
           * right 经理在前
           * left 经理在后
           * return 成员集合 $teamers
           * */
        $teamers = Functions::orderAdminUsers($item, 'left');

        return view('admin.item.diag.index', compact('item', 'diags', 'teamers'));
    }


    /*保存诊断概述*/
    public function store(Request $request,$id)
    {
        $content = htmlentities(addslashes($request->get('content')));

        $diag = Diag::find($id);
        $diag->content = $content;
        $diag->update();

        /*判断是更新在成功*/
        $is_update = Functions::isUpdate($diag->updated_at);

        return response()->json($is_update ? ['status' => 1, 'msg' => '保存成功','url' => route('diag.index',[$diag->items->id])] : ['status' => 0, 'msg' => '更新失败']);

    }

    /*在线预览封面*/
    public function preview($item_id)
    {
        $item = Item::find($item_id);

        return view('admin.item.diag.preview.preview', compact('item'));
    }

    /*在线预览概述*/
    public function previewMsg($item_id)
    {
        $item = Item::find($item_id);

        return view('admin.item.diag.preview.preview1', compact('item'));
    }

    /*在线预览具体分析*/
    public function previewData($item_id)
    {
        $item = Item::find($item_id);
        $diag_mods = $item->diag_mods;

        return view('admin.item.diag.preview.preview2', compact('item','diag_mods'));
    }

    /*在线预览背景*/
    public function previewCompany($item_id)
    {
        $item = Item::find($item_id);

        return view('admin.item.diag.preview.preview4', compact('item'));
    }

    /*在线预览附录*/
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

        return view('admin.item.diag.preview.preview3', compact('item','laws'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($item_id,$id)
    {
        $item = Item::find($item_id);
        $diag = Diag::find($id);

        /*任务状态改变*/
        $task = $diag->tasks()->first();
        $task->status = 1;
        $task->update();

        return view('admin.item.diag.edit', compact('item', 'diag'));
    }


    /*企业背景*/
    public function background($item_id)
    {
        $item = Item::find($item_id);
        $user = $item->hands->users;//客户
        //是否有分配任务
        $isTask = Functions::isTure($user, 'tasks');

        if(!$isTask)
        {
            $tasks = $user->tasks;
            foreach( $tasks as $task )
            {
                $user->task = $task;
                $user->adminUser = $task->admin_users;
            }
        }

        /*
         * 排序按角色是否是经理排序
          * right 经理在前
          * left 经理在后
          * return 成员集合 $teamers
          * */
        $teamers = Functions::orderAdminUsers($item, 'left');

        return view('admin.item.diag.background.index', compact('item', 'user', 'teamers'));
    }


    /*企业背景编辑*/
    public function bgEdit($item_id,$user_id)
    {
        $user = User::find($user_id);
        $item = Item::find($item_id);

        return view('admin.item.diag.background.edit', compact('user', 'item'));
    }

    /*企业背景更新*/
    public function bgUpdate(Request $request, $user_id)
    {
        $pro = $request->get('pro_item_type');
        $main_trade = $request->get('main_trade');

        $user = User::find($user_id);
        $user->pro_item_type = $pro;
        $user->main_trade = $main_trade;
        $user->update();

        $isUpdate = Functions::isUpdate($user->updated_at);

        if( $isUpdate )
        {
            Toastr::success('更新成功!');
        }else
        {
            Toastr::error('更新失败!');
        }

        return redirect(route('user.background',[$user->hands->items->id]));
    }

    /*附件*/
    public function closure($item_id)
    {
        $item = Item::find($item_id);

        //是否有项目审核资料
        $isItemDate = Functions::isTure($item, 'item_datas','one');
        if(!$isItemDate)
        {
            $itemdata = $item->item_datas;
            //是否有分配任务
            $isTask = Functions::isTure($itemdata, 'tasks');
            if(!$isTask)
            {
                $tasks = $itemdata->tasks;
                foreach( $tasks as $task )
                {
                    $adminUser = $task->admin_users;
                    $itemdata->task = $task;
                    $itemdata->adminUser = $adminUser;
                }
            }
        }
        /*
         * 排序按角色是否是经理排序
          * right 经理在前
          * left 经理在后
          * return 成员集合 $teamers
          * */
        $teamers = Functions::orderAdminUsers($item, 'left');

        $diag_mods = $item->diag_mods;
        $laws= [];
        foreach($diag_mods as $diag_mod){
            //是否有诊断结果具体内容
            $isDiagSubMod = Functions::isTure($diag_mod, 'diag_submods');
            if( !$isDiagSubMod )
            {
                $diag_submods = $diag_mod->diag_submods;
                foreach( $diag_submods as $diag_submod )
                {
                    $isSubContents = Functions::isTure($diag_submod, 'diag_subcontents');
                    if( !$isSubContents )
                    {
                        $diag_subContents = $diag_submod->diag_subcontents;
                        foreach( $diag_subContents as $diag_subContent )
                        {
                            $isLaws = Functions::isTure($diag_subContent, 'laws');
                            if( !$isLaws )
                            {
                                $law = array_collapse($diag_subContent->laws->toArray());
                                array_push($laws,$law);
                            }
                        }
                    }
                }
            }
        }

        $item->laws = $laws;

        return view('admin.item.diag.closure', compact('item','itemdata', 'teamers'));
    }

    /*编辑附录*/
    public function closureEdit($item_id)
    {
        $item = Item::find($item_id);

        //是否有项目审核资料
        $isItemDate = Functions::isTure($item, 'item_datas','one');
        if(!$isItemDate)
        {
            $itemdata = $item->item_datas;

            //是否有分配任务
            $isTask = Functions::isTure($itemdata, 'tasks');
            if(!$isTask)
            {
                $tasks = $itemdata->tasks;
                foreach( $tasks as $task )
                {
                    $adminUser = $task->admin_users;
                    $itemdata->task = $task;
                    $itemdata->adminUser = $adminUser;
                }
            }
        }

        /*
         * 排序按角色是否是经理排序
          * right 经理在前
          * left 经理在后
          * return 成员集合 $teamers
          * */
        $teamers = Functions::orderAdminUsers($item, 'left');


        return view('admin.item.diag.closureEdite', compact('item','itemdata', 'teamers'));
    }
    
    /*附录更新*/
    public function closureUpdate(Request $request,$id)
    {
        $content = htmlentities(addslashes($request->get('postData')['content']));
        $item_data = ItemData::find($id);
        $item_data->content = $content;
        $item_data->update();

        $is_update = Functions::isUpdate($item_data->updated_at);

        return response()->json($is_update ? ['status' => 1 , 'msg' => '保存成功' , 'url' => route('closure.index',[$item_data->items->id])] : ['status' => 0 , 'msg' => '保存失败' ]);

    }

    /*交付客户*/
    public function active($item_id)
    {
        $item = Item::find($item_id);
        if(Functions::getDiagComplate($item) == 100){
            $item->diag_active = 1;
            $item->diag_active_time = Carbon::now();
            $item->update();

            if($item->diag_active == 1){
                Toastr::success('交付成功');
            }else{
                Toastr::error('交付失败');
            }
        }else{
            Toastr::error('未诊断报告未完成，交付失败！');
        }
        return redirect(route('diag.index',[$item_id]));
    }

    /*导出word文档*/
    public function exportWord($item_id)
    {
        $item = Item::find($item_id);
        $hands = $item->hands;//交接单
        $meches = $item->hands->meches;//审核机构
        $users = $item->hands->users;//客户信息

        //诊断概述
        $diags_1 = $item->diags->where('title',1)->first();
        $diags_2 = $item->diags->where('title',2)->first();
        $diags_3 = $item->diags->where('title',3)->first();
        $diags_4 = $item->diags->where('title',4)->first();
        $diags_5 = $item->diags->where('title',5)->first();
        $diags_6 = $item->diags->where('title',6)->first();
        //诊断具体分析
        $diag_mod_1 = $item->diag_mods->where('name',1)->first();
        $diag_mod_2 = $item->diag_mods->where('name',2)->first();
        $diag_mod_3 = $item->diag_mods->where('name',3)->first();
        $diag_mod_4 = $item->diag_mods->where('name',4)->first();
        $item_datas = $item->item_datas;

        $phpword = new PhpWord();
        $phpword->setDefaultFontName('宋体');//字体
        $phpword->setDefaultFontSize(12);//字号
        $phpword->setDefaultParagraphStyle([//段落默认样式
            'alignment'  => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
            'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(12),
            'spaceBefore' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(14),
            'spacing'    => 0,
            ]);

        $styleTable = [        //表格样式
            'borderColor' => '000',
            'borderSize' => 1,
            'cellMarginTop' => 0,
            'cellMarginRight' => 200,
            'cellMarginBottom' => 0,
            'cellMarginLeft' => 200,
            'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER
        ];

        $sectionstype = [   /*页面样式*/
            'paperSize' => 'A4',
            'orientation' => 'landscape',
            'borderColor' => '666666',
            'borderSize' => 1,
            'marginLeft' => 800,
            'marginRight' => 800,
            'marginTop' => 0,
            'marginBottom' => 0,
            'headerHeight' => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(13.15),
            'footerHeight' => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(13.15),
        ];

        $styleFirstRow = array('bgColor' => 'cccccc');
        $fancyTableTextStyle = array('bold' => true);
        $fancyTableTextAlgin = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START);
        $fancyTableTextAlginIn = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START,'indentation' => array('firstLine' => 340));
        $fancyTableCellSpan = array('valign' => 'center',);

        $listtext24 = ['name' => '宋体','size' => 24,'color' => 'black','bold' => true];
        $listtext20 = ['name' => '宋体','size' => 20,'color' => 'black','bold' => true];
        $listtext16 = ['name' => '宋体','size' => 16,'color' => 'black','bold' => true];
        $listtext14 = ['name' => '宋体','size' => 14,'color' => 'black','bold' => true];
        $listtext12 = ['name' => '宋体','size' => 12,'color' => 'black','bold' => true];
        $listtext12c = ['name' => '宋体','size' => 12,'color' => 'black'];

        $predefinedMultilevelStyle = array('listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER_NESTED);

        /*报告封面*/
        $section = $phpword->addSection($sectionstype);
        $section->addImage(public_path().'/images/logo_b.png',[
            'width'            => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(3.1),
            'height'           => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(2.7),
            'marginTop'        => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(3.55),
        ]);

        $section->addTextBreak(3);
        $section->addText($hands->name,$listtext24);
        $section->addTextBreak();
        $section->addText('供应链定制化服务风险诊断',$listtext20);
        $section->addTextBreak(2);
        $section->addText($meches->name,$listtext16);
        $section->addText(Carbon::now()->year.'年'.Carbon::now()->month.'月'.Carbon::now()->day.'日',$listtext16);
        //页眉与页脚
        $header = $section->addHeader();
        $footer = $section->addFooter();

        $section->addTextBreak();
        $footertextstype =  ['name' => '宋体','size' => 10,'color' => 'black'];/*页脚文字样式*/
        $footerparagstype = [ 'line-height' => 1, 'space' => array('before' => 0, 'after' => 0) ]; /*页脚文字段落样式*/

        $footer->addText('深圳市东华供应链科技有限公司',$footertextstype,$footerparagstype);
        $footer->addText('地址：深圳市前海深港合作区海运中心主塔楼2119A',$footertextstype,$footerparagstype);
        $footer->addText('TEL: 0769-8989-3366  FAX: 0769-8989-3939  E-mail: yangl@ruidonghua.com',$footertextstype,$footerparagstype);

        $section = $phpword->addSection($sectionstype);
        $section->addText('目录',$listtext24);
        $section->addText('一、诊断结果概述',$listtext14,$fancyTableTextAlgin);
        $section->addText('二、诊断结果具体分析',$listtext14,$fancyTableTextAlgin);
        $section->addListItem('关务风险管理', 0, $listtext14,$predefinedMultilevelStyle, $fancyTableTextAlgin);
       foreach($diag_mod_1->diag_submods as $submod){//子模块
            $section->addListItem($submod->name, 1, $listtext14,null, $fancyTableTextAlgin);
        }

        $section->addListItem('AEO管理 ', 0, $listtext14,$predefinedMultilevelStyle, $fancyTableTextAlgin);
        foreach($diag_mod_2->diag_submods as $submod){//子模块
            $section->addListItem($submod->name, 1, $listtext14,null, $fancyTableTextAlgin);
        }

        $section->addListItem('物流风险管理', 0, $listtext14,$predefinedMultilevelStyle, $fancyTableTextAlgin);
        foreach($diag_mod_3->diag_submods as $submod){//子模块
            $section->addListItem($submod->name, 1, $listtext14,null, $fancyTableTextAlgin);
        }

        $section->addListItem('系统化管理', 0, $listtext14,$predefinedMultilevelStyle, $fancyTableTextAlgin);
        foreach($diag_mod_4->diag_submods as $submod){//子模块
            $section->addListItem($submod->name, 1, $listtext14,null, $fancyTableTextAlgin);
        }

        $section->addListItem('预归类（所有商品编码都没有进行专业人士或专业机构进行归类）', 0, $listtext14,$predefinedMultilevelStyle, $fancyTableTextAlgin);
        $section->addListItem('预估价（一般贸易的进口没有做申报前的估价）', 0, $listtext14,$predefinedMultilevelStyle, $fancyTableTextAlgin);
        $section->addTextBreak(2);
        $section->addText('三、企业背景描述',$listtext14,$fancyTableTextAlgin);
        $section->addText('四、附录',$listtext14,$fancyTableTextAlgin);
        $section->addListItem('附录1 法规条例索引', 0, $listtext14,$predefinedMultilevelStyle, $fancyTableTextAlgin);
        $section->addListItem('附录5 供应链定制服务审核文件资料', 0, $listtext14,$predefinedMultilevelStyle, $fancyTableTextAlgin);

        $section->addTextBreak(2);
        $section->addText('免责声明：本诊断报告依据企业提供信息结合现行相关法律、法规等进行制作，因对法律、法规的理解及企业提供相关信息的完整性、准确性等相关因素影响，报告可能未全面反映企业实际情况。',
            ['name' => '宋体','size' => 10,'color' => '666666'],$fancyTableTextAlgin);
        $section->addTextBreak(2);

        $section->addText('一、诊断结果概述',$listtext16,$fancyTableTextAlgin);
        $section->addText('通过本次诊断，我司发现贵司存在如下主要问题：',$listtext12,$fancyTableTextAlgin);
        $section->addText('（一）关于关务管理诊断存在问题如下：',$listtext12,$fancyTableTextAlgin);
        foreach(explode('</p>',html_entity_decode(stripslashes($diags_1->content))) as $diag){
            $section->addText(strip_tags($diag),$listtext12c,$fancyTableTextAlginIn);
        }
        $section->addText('（二）关于AEO风险管理诊断存在问题如下：',$listtext12,$fancyTableTextAlgin);
        foreach(explode('</p>',html_entity_decode(stripslashes($diags_2->content))) as $diag){
            $section->addText(strip_tags($diag),$listtext12c,$fancyTableTextAlginIn);
        }
        $section->addText('（三）关于物流风险管理诊断存在问题如下：',$listtext12,$fancyTableTextAlgin);
        foreach(explode('</p>',html_entity_decode(stripslashes($diags_3->content))) as $diag){
            $section->addText(strip_tags($diag),$listtext12c,$fancyTableTextAlginIn);
        }
        $section->addText('（四）关于系统化管理诊断存在问题如下：',$listtext12,$fancyTableTextAlgin);
        foreach(explode('</p>',html_entity_decode(stripslashes($diags_4->content))) as $diag){
            $section->addText(strip_tags($diag),$listtext12c,$fancyTableTextAlginIn);
        }
        $section->addText('（五）关于预归类诊断存在问题如下：',$listtext12,$fancyTableTextAlgin);
        foreach(explode('</p>',html_entity_decode(stripslashes($diags_5->content))) as $diag){
            $section->addText(strip_tags($diag),$listtext12c,$fancyTableTextAlginIn);
        }
        $section->addText('（六）关于预估价诊断存在问题如下：',$listtext12,$fancyTableTextAlgin);
        foreach(explode('</p>',html_entity_decode(stripslashes($diags_6->content))) as $diag){
            $section->addText(strip_tags($diag),$listtext12c,$fancyTableTextAlginIn);
        }


        $section->addText('二．诊断结果具体分析',$listtext16,$fancyTableTextAlgin);
        $phpword->addTableStyle('myTable',$styleTable);
        $table = $section->addTable('myTable');
        $table->addRow(null);//行高400
        $table->addCell(2000,$styleFirstRow)->addText('项目',$fancyTableTextStyle);
        $table->addCell(5500,$styleFirstRow)->addText('审核内容',$fancyTableTextStyle);
        $table->addCell(2500,$styleFirstRow)->addText('问题及风险描述',$fancyTableTextStyle);
        $table->addCell(5000,$styleFirstRow)->addText('建议及改善方案',$fancyTableTextStyle);

        $diag_submods =$diag_mod_1->diag_submods;//诊断结果具体分析
        if(!$diag_submods->isEmpty()){
            $this->exprotWordTable($table,$diag_submods,$fancyTableTextAlgin);
        }

        $section->addTextBreak(2);
        $section->addText('三、企业背景描述',$listtext16,$fancyTableTextAlgin);
        $section->addText('►企业基本情况',null,$fancyTableTextAlgin);

        $phpword->addTableStyle('myTable',$styleTable);
        $table = $section->addTable('myTable');
        $table->addRow(null);//行高400
        $table->addCell(2000,$styleFirstRow)->addText('序号',$fancyTableTextStyle);
        $table->addCell(3000,$styleFirstRow)->addText('基本项目',$fancyTableTextStyle);
        $table->addCell(10000,$styleFirstRow)->addText('具体内容',$fancyTableTextStyle);
        $table->addRow(null);//行高400
        $table->addCell(null)->addText('1');
        $table->addCell(null)->addText('注册名称',null,$fancyTableTextAlgin);
        $table->addCell(null)->addText($users->name,null,$fancyTableTextAlgin);
        $table->addRow(null);//行高400
        $table->addCell(null)->addText('2');
        $table->addCell(null)->addText('注册地址',null,$fancyTableTextAlgin);
        $table->addCell(null)->addText($users->address,null,$fancyTableTextAlgin);
        $table->addRow(null);//行高400
        $table->addCell(null)->addText('3');
        $table->addCell(null)->addText('成立日期/营业期限',null,$fancyTableTextAlgin);
        $table->addCell(null)->addText($users->create_date,null,$fancyTableTextAlgin);
        $table->addRow(null);//行高400
        $table->addCell(null)->addText('4');
        $table->addCell(null)->addText('注册资本',null,$fancyTableTextAlgin);
        $table->addCell(null)->addText($users->captial,null,$fancyTableTextAlgin);
        $table->addRow(null);//行高400
        $table->addCell(null)->addText('5');
        $table->addCell(null)->addText('海关注册登记编码',null,$fancyTableTextAlgin);
        $table->addCell(null)->addText($users->code,null,$fancyTableTextAlgin);
        $table->addRow(null);//行高400
        $table->addCell(null)->addText('6');
        $table->addCell(null)->addText('管理类型',null,$fancyTableTextAlgin);
        $table->addCell(null)->addText($users->aeo,null,$fancyTableTextAlgin);
        $table->addRow(null);//行高400
        $table->addCell(null)->addText('7');
        $table->addCell(null)->addText('贸易方式',null,$fancyTableTextAlgin);
        $table->addCell(null)->addText($users->trade,null,$fancyTableTextAlgin);
        $table->addRow(null);//行高400
        $table->addCell(null)->addText('8');
        $table->addCell(null)->addText('加工贸易手册监管方式',null,$fancyTableTextAlgin);
        $table->addCell(null)->addText($users->trade_manual,null,$fancyTableTextAlgin);
        $table->addRow(null);//行高400
        $table->addCell(null)->addText('9');
        $table->addCell(null)->addText('生产项目类别',null,$fancyTableTextAlgin);
        $table->addCell(null)->addText($users->pro_item_type,null,$fancyTableTextAlgin);
        $table->addRow(null);//行高400
        $table->addCell(null)->addText('10');
        $table->addCell(null)->addText('主要进出口贸易方式',null,$fancyTableTextAlgin);
        $table->addCell(null)->addText($users->main_trade,null,$fancyTableTextAlgin);


        $section->addTextBreak(2);
        $section->addText('四、附录',$listtext16,$fancyTableTextAlgin);
        $section->addText('附录 1– 法规条例索引',$fancyTableTextAlgin);

        $phpword->addTableStyle('myTable',$styleTable);
        $table = $section->addTable('myTable');
        $table->addRow(null);//行高400
        $table->addCell(1000,$styleFirstRow)->addText('序号',$fancyTableTextStyle);
        $table->addCell(3500,$styleFirstRow)->addText('法规条例名称',$fancyTableTextStyle);
        $table->addCell(3500,$styleFirstRow)->addText('法规条例文号',$fancyTableTextStyle);
        $table->addCell(7000,$styleFirstRow)->addText('法规条例内容',$fancyTableTextStyle);

        $diag_mods= $item->diag_mods()->with('diag_submods')->get();//诊断报告引用法律法规
        foreach($diag_mods as $diag_mod){
            $diag_submods = $diag_mod->diag_submods()->with('diag_subcontents')->get();
            foreach($diag_submods as $diag_submod){
                $diag_subcontents = $diag_submod->diag_subcontents()->with('laws')->get();
                foreach($diag_subcontents as $diag_subcontent){
                    $laws = $diag_subcontent->laws;
                    foreach($laws as $law){
                        $table->addRow(null);//行高400
                        $table->addCell(null,$fancyTableCellSpan)->addText($law->id,null,$fancyTableTextAlgin);
                        $table->addCell(null,$fancyTableCellSpan)->addText($law->name,null,$fancyTableTextAlgin);
                        $table->addCell(null,$fancyTableCellSpan)->addText($law->title,null,$fancyTableTextAlgin);
                        $table->addCell(null,$fancyTableCellSpan)->addText('第'.$law->title_no.'条  '
                            .strip_tags(html_entity_decode(stripslashes($law->content))),null,$fancyTableTextAlgin);
                    }
                }
            }
        }

        $section->addTextBreak();
        $section->addText('附录 2– 关务分析审核的资料清单',$listtext12,$fancyTableTextAlgin);
        $phpword->addTableStyle('myTable',$styleTable);
        $table = $section->addTable('myTable');
        $item_datas = explode('</p>',html_entity_decode(stripslashes($item_datas->content)));
        foreach($item_datas as $item_data){
            for($x=1;$x>=count($item_datas);$x--){
                $table->addRow(null);//行高400
                $table->addCell(1000)->addText($x,null,$fancyTableTextStyle);
                $table->addCell(14000)->addText(strip_tags($item_data),null,$fancyTableTextStyle);
            }
        }

        $header = $section->addHeader();        //页眉与页脚
        $footer = $section->addFooter();        //页眉与页脚
        $header->addText(' ');
        $footer->addText('深圳市东华供应链科技有限公司',$footertextstype,$footerparagstype);
        $footer->addText('地址：深圳市前海深港合作区海运中心主塔楼2119A',$footertextstype,$footerparagstype);
        $footer->addText('TEL: 0769-8989-3366  FAX: 0769-8989-3939  E-mail: yangl@ruidonghua.com',$footertextstype,$footerparagstype);

        //生成的文档为Word2007
        $writer = IOFactory::createWriter($phpword, 'Word2007');

        $name = $item->hands->users->name.'-风险诊断报告.docx';
        $writer->save($name);
        /*下载文档*/
        return response()->download(realpath(base_path('public')).'/'. $name, $name);
    }

    /*导出word表格*/
    public function exprotWordTable($table,$objs,$fancyTableTextAlgin)
    {
        $textstyle = ['color' => 'ff0000'];
        foreach($objs as $obj){
            $sub_contents = $obj->diag_subcontents;
            if(!$sub_contents->isEmpty()){
                foreach($sub_contents as $key => $sub_content){
                    if($key == 0){
                        $table->addRow();
                        $table->addCell(null,['vMerge' => 'restart', 'valign' => 'center'])
                            ->addText($obj->name,null,$fancyTableTextAlgin);
                        $table->addCell(null)->addText($sub_content->content,null,$fancyTableTextAlgin);
                        $table->addCell(null)->addText($sub_content->describle,$textstyle,$fancyTableTextAlgin);
                        $table->addCell(null)->addText($sub_content->suggest,$textstyle,$fancyTableTextAlgin);
                    }else{
                        $table->addRow();
                        $table->addCell(null,['vMerge' => 'continue']);
                        $table->addCell(null)->addText($sub_content->content,null,$fancyTableTextAlgin);
                        $table->addCell(null)->addText($sub_content->describle,$textstyle,$fancyTableTextAlgin);
                        $table->addCell(null)->addText($sub_content->suggest,$textstyle,$fancyTableTextAlgin);
                    }
                }
            }
        }
    }
}
