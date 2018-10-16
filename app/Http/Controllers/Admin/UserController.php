<?php
/*客户*/

namespace App\Http\Controllers\Admin;

use App\Helpers\Functions;
use App\Http\Requests\Admin\User\CreateRequest;
use App\Http\Requests\Admin\User\UpdateRequest;
use App\User;
use Carbon\Carbon;
use ClassesWithParents\F;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yuansir\Toastr\Facades\Toastr;

class UserController extends BaseController
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

        $users = User::with('user_departs','hands')->latest()->paginate(15);
        $users->load('user_departs','hands');

//        $users = User::latest()->paginate(15);

        return view('admin.user.index', compact('users'));
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
        $name = $request->input('name');
        $address = $request->input('address');
        $code = $request->input('code');
        $trade = $request->input('trade');
        $tel = $request->input('tel');
        $email = $request->input('email');
        $fax = $request->input('fax');
        $aeo = $request->input('aeo');
        $trade_manual = $request->input('trade_manual');
        $main_trade = $request->input('main_trade');
        $pro_item_type = $request->input('pro_item_type');
        $remark = $request->input('remark');
        $capital = $request->input('capital');
        $create_date = $request->input('create_date');

        $user = new User();
        $user->name = $name;
        $user->address = $address;
        $user->code = $code;
        $user->trade = $trade;
        $user->email = $email;
        $user->tel = $tel;
        $user->fax = $fax;
        $user->aeo = $aeo;

        /*联动，如果是一般贸易，没有贸易手册*/
        if( $trade == 0 || $trade == 2 )
        {
            $user->trade_manual = $trade_manual;
        }elseif( $trade == 1 )
        {
            $user->trade_manual = '';
        }
        $user->main_trade = $main_trade;
        $user->pro_item_type = $pro_item_type;
        $user->remark = $remark;
        $user->capital = $capital;
        $user->create_date = $create_date;
        $user->save();

        /*判断是否存在成功*/
        $isSave = Functions::isCreate(User::all(),$user->id);

        if( $isSave )
        {
            Toastr::success('新增成功');
        }else
        {
            Toastr::error('新增失败');
        }

        return redirect(route('user.index'));

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
        $user = User::find($id);

        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $name = $request->input('name');
        $address = $request->input('address');
        $code = $request->input('code');
        $trade = $request->input('trade');
        $tel = $request->input('tel');
        $email = $request->input('email');
        $fax = $request->input('fax');
        $pro_item_type = $request->input('pro_item_type');
        $remark = $request->input('remark');
        $capital = $request->input('capital');
        $create_date = $request->input('create_date');

        $is_hands = Functions::isTure($user,'hands','one');
        if(!$is_hands){
            $is_items = Functions::isTure($user->hands,'items','one');
            if(!$is_items){
                $aeo = '';
                $trade_manual = '';
                $main_trade = '';
            }else{
                $aeo = $request->input('aeo');
                $trade_manual = $request->input('trade_manual');
                $main_trade = $request->input('main_trade');
            }
        }else{
            $aeo = $request->input('aeo');
            $trade_manual = $request->input('trade_manual');
            $main_trade = $request->input('main_trade');
        }

        $user->name = $name;
        $user->address = $address;
        $user->code = $code;
        $user->trade = $trade;
        $user->tel = $tel;
        $user->fax = $fax;
        $user->email = $email;
        $user->aeo = $aeo;
        /*联动，如果是一般贸易，没有贸易手册*/
        if($trade == 0 || $trade == 2)
        {
            $user->trade_manual = $trade_manual;
        }elseif( $trade == 1 )
        {
            $user->trade_manual = '';
        }

        $user->main_trade = $main_trade;
        $user->pro_item_type = $pro_item_type;
        $user->remark = $remark;
        $user->capital = $capital;
        $user->create_date = $create_date;
        $user->update();

        /*判断是否有数据更新*/
        $is_update = Functions::isUpdate(User::find($id)->updated_at);

        if( $is_update )
        {
            Toastr::success('更新成功');
        }else
        {
            Toastr::warning('更新失败');
        }

        return redirect(route('user.index'));

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
        /*软删除*/
       $user =  User::find($id);
        $is_hands = Functions::isTure($user,'hands','one');
        if($is_hands){
            $user->hands->items()->delete();
            $user->delete();

            $is_delete = Functions::isCreate(User::withTrashed(),$id);

            if( $is_delete )
            {
                Toastr::success('删除成功');
            }else{
                Toastr::error('删除失败');
            }

        }else{
            Toastr::error('不能删除有交接单的客户');
        }

        return redirect(route('user.index'));

    }

    /**
     * Delete multi users
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyAll(Request $request)
    {

        if( !( $ids = $request->get('ids') ) )
        {
            return response()->json([ 'status' => 0, 'msg' => '请求参数错误' ]);
        }

        foreach( $ids as $id )
        {
            User::find($id)->delete();
        }

        $UserIds = Functions::getIds(User::withTrashed());
        $delUserCounts = array_intersect($UserIds,$ids);

        return response()->json([ 'status' => 1, 'msg' => '成功删除'.count($delUserCounts).'个客户' ]);
    }


    /** 导入客户* */
    public function import(Request $request)
    {
        /*
         * 上传文件
         * return bool $reslut
         * */
        $reslut = $this->uploadFile($request);
        //客户导入文件保存路径
        $path = $this->getPath($request);

        if( $reslut )
        {
            Excel::load($path, function($reader)
            {

                $reader = $reader->getSheet(0);//获取excel的第1张表

                $results = $reader->toArray();//获取表中的数据

                $head = [ '企业名称', '地址', '传真', '海关识别码', '贸易方式', '营业期限', 'AEO认证', '加工贸易手册管理方式', '主要进出口贸易方式', '生产项目类别', '注册资本', '企业性质', '成立日期' ];
                $err_msg = '';
                $suc_msg = '';

                foreach( $results as $k => $row )
                {
                    if( $k == 0 )
                    {
                        if( $row === $head )
                        {

                            continue;
                        }else
                        {
                            echo '模板不对';
                            //                            return Response::json([
                            //                                'status' => 0,
                            //                                'msg' =>  '模板不对',
                            //                            ]);
                        }
                    }else
                    {

                        $is_user = User::where('name', $row[ 0 ])->get();

                        if( count($is_user) !== 0 )
                        {
                            $err_msg .= "<font color='red'>第".( $k + 1 )."行,客户名称:.$row[0].清单已存在<br><font>";
                            continue;
                        }
                        $in_arr = [ 'name' => $row[ 0 ], 'address' => $row[ 1 ], 'fax' => $row[ 2 ], 'code' => $row[ 3 ], 'trade' => $row[ 4 ], 'end_date' => $row[ 5 ], 'aeo' => $row[ 6 ], 'trade_manual' => $row[ 7 ], 'main_trade' => $row[ 8 ], 'pro_item_type' => $row[ 9 ], 'capital' => $row[ 10 ], 'company_type' => $row[ 11 ], 'create_date' => $row[ 12 ], ];

                        if( !empty($in_arr[ 'name' ]) )
                        {
                            User::insert($in_arr);
                            $suc_msg .= "第".( $k + 1 )."行,客户名称:".$row[ 0 ]."客户插入成功<br>";
                        }
                    }
                }

                //                echo $suc_msg;
                //                echo $err_msg;

                if( !empty($err_msg) || !empty($suc_msg) )
                {

                    echo $suc_msg.$err_msg;
                    //                    return Response::json([
                    //                        'status' => 1,
                    //                        'success' => $suc_msg,
                    //                        'error' => $err_msg,
                    //                    ]);

                }else
                {
                    echo '没有客户数据导入';
                    //                    return Response::json([
                    //                        'status' => 0,
                    //                        'msg' => '没有清单数据导入',
                    //                    ]);
                }
            });
        }else
        {
            echo '请选择文件';
            //            return Response::json([
            //                'status' => 0,
            //                'msg' => '请选择文件',
            //            ]);
        }
    }

    /** 导出客户* */
    public function export()
    {

        $users = User::all();
        $cellData = [ [ '企业名称', '地址', '传真', '海关识别码', '贸易方式', '营业期限', 'AEO认证', '加工贸易手册管理方式', '主要进出口贸易方式', '生产项目类别', '注册资本', '企业性质', '成立日期' ],

        ];
        foreach( $users as $user )
        {

            $userData = [ $user->name, $user->address, $user->fax, $user->code, $user->trade, $user->end_date, $user->aeo, $user->trade_manual, $user->main_trade, $user->pro_item_type, $user->capital, $user->company_type, $user->create_date, ];

            array_push($cellData, $userData);
        }

        $name = iconv('UTF-8', 'GBK', '客户数据'.$this->getTime());//文件名称
        $dir = $this->getDir().'\\exports\\';//导出客户文件保存路径

        Excel::create($name, function($excel) use ($cellData)
        {
            $excel->sheet('score', function($sheet) use ($cellData)
            {
                $sheet->rows($cellData);
            });

        })->store('xls', $dir)->export('xls');


    }

    /*
     * 上传文件到本地服务器
     * return bool $exists
    */
    public function uploadFile($request)
    {
        /*上传文件*/
        $request->file('excelfile')->storeAs('users/'.Auth::guard('admin')->user()->username.'/imports/', $request->file('excelfile')->getClientOriginalName());
        /*文件是否存在*/
        $exists = Storage::disk('local')->exists('users/'.Auth::guard('admin')->user()->username.'/imports/'.$request->file('excelfile')->getClientOriginalName());

        return $exists;
    }

    /*
     * 获取上传目录
     *
     * return string $dir
     * */
    public function getDir()
    {
        $dir = storage_path().'\app\users\\'.Auth::guard('admin')->user()->username;

        return $dir;
    }

    /*
      * 获取上传文件的路径
      * return bool $path
      * */
    public function getPath($request)
    {
        $path = $this->getDir().'\\imports\\'.$request->file('excelfile')->getClientOriginalName();

        return $path;
    }

    /*
     * 获取当前时间
     *
     * return string $time
     *
     * */
    public function getTime()
    {
        $time = Carbon::now()->year.Carbon::now()->month.Carbon::now()->day.Carbon::now()->hour.Carbon::now()->minute.Carbon::now()->second;

        return $time;
    }

    /*
     * 客户搜索
    */
    public function search(Request $request)
    {
        $trade = $request->input('trade');
        $str = $request->input('searchStr');

        if( $trade === '')
        {
            if( empty($str) )
            {
                $users = User::latest()->paginate(15);
            }else
            {
                $users = User::where('name', 'like', '%'.$str.'%')->latest()->paginate(15);
            }
            return view('admin.user.index', compact('users'));

        }else {
            if( empty($str) )
            {
                $users = User::where('trade', $trade)->latest()->paginate(15);
            }else
            {
                $users = User::where(function($query) use ($trade, $str)
                {
                    $query->where('trade', $trade)->where('name', 'like', '%'.$str.'%');
                })->latest()->paginate(15);
            }
            return view('admin.user.index', compact('users','trade'));
        }

    }

}
