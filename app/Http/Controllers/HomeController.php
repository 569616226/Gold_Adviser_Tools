<?php

namespace App\Http\Controllers;

use App\Helpers\Functions;
use App\Models\UserDepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class HomeController extends BaseController
{
    /**
     * CustomerController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user()->users;
        $ishand = Functions::isTure($user,'hands','one');
        if(!$ishand){
            $isitem = Functions::isTure($user->hands,'items','one');
            if(!$isitem){
                $item = $user->hands->items;
                $tasks = $item->tasks()->where('status',4)
                    ->where('tasktable_type','App\Models\ImproveConTem')
                    ->get();

                $suggest = 0;
                foreach($tasks as $task )
                {
                    $is_suggest = Functions::isTure($task,'suggests','one');
                    if(!$is_suggest && $task->suggests->score == -1){
                        $suggest++;
                    }
                }
                $item->suggestCount = $suggest;
                return view('home',compact('item'));
            }
        }
        return view('home');
    }

    /*重置密码*/
    public function resetPassword(Request $request)
    {

        $postData = $request->get('postdata');
        $password_old = $postData['password_old'];
        $password = $postData['password'];
        $password_confirmation = $postData['password_confirmation'];
        $user = UserDepart::find(Functions::getGLUser()->id);

        if(Hash::check($password_old, $user->password)){

            if($password === $password_confirmation){

                $user->password =  bcrypt($password);
                $user->update();

                $is_update = Functions::isUpdate($user->updated_at);

                return response()->json($is_update ? ['status' => 1 ,'msg' => '密码修改成功' ] : ['status' => 0 ,'msg' => '密码修改' ]);

            }else{

                return response()->json(['status' => 0 , 'msg' => '两次输入的密码不一致，请重新输入' ]);
            }
        }else{

            return response()->json(['status' => 0 , 'msg' => '旧密码输入有误，请重新输入' ]);
        }
    }

}
