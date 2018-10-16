<?php
/*
 * 交接单
 * */

namespace App\Http\Controllers\Admin;

use App\Helpers\Functions;
use App\Models\Hand;
use App\Models\Mech;
use App\Models\UserContacter;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HandoverController extends BaseController
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
        return view('admin.handover.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($user_id)
    {
        $mechs = Mech::all();
        $user = User::find($user_id);

        return view('admin.handover.create', compact('mechs', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $user_id)
    {

        $container = $request->input('container');
        $contacts = $request->input('contacs');
        $countArrays = 0;
        if(count($contacts) >=1 ){
            $hand = new Hand();
            $hand->handover_no = $container[ 'handover_no' ];
            $hand->name = $container[ 'name' ];
            $hand->description = $container[ 'description' ];
            $hand->end_time = $container[ 'end_time' ];
            $hand->suggest = htmlentities(addslashes($container[ 'suggest' ]));
            $hand->meche_id = $container[ 'mech_id' ];
            $hand->user_id = $user_id;
            $hand->save();

            /*判断是否新增成功*/
            $isSave = Functions::isCreate(Hand::all(),$hand->id);
          if( $isSave )
            {
                foreach( $contacts as $contact )
                {
                    $con = new UserContacter();
                    $con->wechat = $contact[ 'wechat' ];
                    $con->contacter = $contact[ 'contacter' ];
                    $con->business = $contact[ 'busniess' ];
                    $con->phone = $contact[ 'phone' ];
                    $con->email = $contact[ 'email' ];
                    $con->hand_id = $hand->id;
                    $con->save();
                    $countArrays++;
                }

                $data = [ 'status' => 1, 'user_id' => $user_id, 'msg' => '交接单新增成功,新增'.$countArrays.'个联系人' ];

            }else
            {
                $data = [ 'status' => 0, 'user_id' => $user_id, 'msg' => '交接单新增失败' ];
            }

        }else{
            $data = [ 'status' => 0, 'msg' => '必须填写一个联系人' ];
        }



        return response()->json($data);

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
        $user = User::find($id);
        $hand = $user->hands;

        return view('admin.handover.index', compact('hand', 'user'));
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
        $hand = $user->hands;
        $mechs = Mech::all();

        return view('admin.handover.edit', compact('hand', 'mechs', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $user_id)
    {
        $container = $request->input('container');
        $contacts = $request->input('contacts');

        if( count($contacts)>= 1 ){

            $hand = Hand::find($id);
            $hand->handover_no = $container[ 'handover_no' ];
            $hand->name = $container[ 'name' ];
            $hand->description = $container[ 'description' ];
            $hand->end_time = $container[ 'end_time' ];
            $hand->suggest = $container[ 'suggest' ];
            $hand->meche_id = $container[ 'mech_id' ];
            $hand->update();

            $isUpdate = Functions::isUpdate($hand->updated_at);

            foreach( $contacts as $contact )
            {
                if( $contact[ 'contacter_id' ] !== '' )
                {
                    $con = UserContacter::find($contact[ 'contacter_id' ]);
                    $con->wechat = $contact[ 'wechat' ];
                    $con->contacter = $contact[ 'contacter' ];
                    $con->business = $contact[ 'busniess' ];
                    $con->phone = $contact[ 'phone' ];
                    $con->email = $contact[ 'email' ];
                    $con->update();

                }elseif( $contact[ 'contacter' ] !== '' && $contact[ 'phone' ] !== '' && $contact[ 'busniess' ] !== '' )
                {
                    $con = new UserContacter();
                    $con->wechat = $contact[ 'wechat' ];
                    $con->contacter = $contact[ 'contacter' ];
                    $con->business = $contact[ 'busniess' ];
                    $con->phone = $contact[ 'phone' ];
                    $con->email = $contact[ 'email' ];
                    $con->hand_id = $hand->id;
                    $con->save();
                }
            }

            /*新增的联系人数量*/
            $contactIds = $hand->contacts->pluck('contacter')->toArray();

            /*获取要新增的联系人的ID*/
            $contactCreateds = [];
            foreach($contacts as $contact){
                if($contact['contacter_id'] == ''){
                    array_push($contactCreateds,$contact['contacter']);
                }
            }

            $countCreateArrays = count(array_intersect($contactCreateds, $contactIds));

            /*更新的联系人数量*/
            $contactUpdateds = [];
            foreach($contacts as $contact){
                if($contact['contacter_id'] !== '' && UserContacter::find($contact['contacter_id'])->updated_at->timestamp < Carbon::now()->timestamp){

                }else{
                    array_push($contactUpdateds,$contact);
                }
            }

            if($isUpdate)
            {
                $data = [ 'status' => 1, 'user_id' => $user_id, 'msg' => '交接单更新成功,新增'
                    .$countCreateArrays.'个联系人，更新'.count($contactUpdateds).'个联系人'];
            }else
            {
                $data = [ 'status' => 0, 'user_id' => $user_id, 'msg' => '没有交接数据更新,新增'
                    .$countCreateArrays.'个联系人，更新'.count($contactUpdateds).'个联系人'];
            }

        }else{
            $data = [ 'status' => 0, 'msg' => '必须填写一个联系人' ];
        }


        return response()->json($data);
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
        Hand::find($id)->delete();
        $is_delete = Functions::isCreate(Hand::withTrashed(),$id);

        return response()->json($is_delete ? [ 'status' => 1, 'msg' => '交接单删除成功' ] : [ 'status' => 0, 'msg' => '交接单删除失败' ]);

    }

    /*联系人删除*/
    public function contacterDestroy($contacter_id)
    {
        UserContacter::find($contacter_id)->delete();
        $is_delete = Functions::isCreate(UserContacter::withTrashed(),$contacter_id);

        return response()->json($is_delete ? [ 'status' => 1, 'msg' => '联系人删除成功' ] : [ 'status' => 0, 'msg' => '联系人删除失败' ]);
    }


}
