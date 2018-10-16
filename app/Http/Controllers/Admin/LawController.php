<?php
/*
 * 法律法规
 * */

namespace App\Http\Controllers\Admin;

use App\Helpers\Functions;
use App\Http\Requests\Admin\Law\CreateRequest;
use App\Http\Requests\Admin\Law\UpdateRequest;
use App\Models\Law;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yuansir\Toastr\Facades\Toastr;


//use App\Http\Controllers\Controller;

class LawController extends BaseController
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

        $laws = Law::paginate(15);

        return view('admin.law.index', compact('laws'));
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
        $title = $request->get('title');
        $title_no = $request->get('title_no');
        $name = $request->get('name');
        $content = htmlentities(addslashes($request->get('content')));

        $law = new Law();
        $law->name = $name;
        $law->title = $title;
        $law->title_no = $title_no;
        $law->content = $content;
        $law->save();

        /*查检是否存在*/

        $is_save = Functions::isCreate(Law::all(),$law->id);

        if( $is_save )
        {
            Toastr::success('新增成功');
        }else
        {
            Toastr::error('新增失败');
        }

        return redirect(route('law.index'));
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

        $law = Law::find($id);

        return view('admin.law.edit', compact('law'));
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
        $title = $request->get('title');
        $title_no = $request->get('title_no');
        $name = $request->get('name');
        $content = htmlentities(addslashes($request->get('content')));

        $law = Law::find($id);
        $law->name = $name;
        $law->title = $title;
        $law->title_no = $title_no;
        $law->content = $content;
        $law->update();

        /*判断是更新在成功*/
        $is_update = Functions::isUpdate(Law::find($id)->updated_at);

        if( $is_update )
        {
            Toastr::success('更新成功');
        }else
        {
            Toastr::warning('更新失败');
        }

        return redirect(route('law.index'));
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
        Law::find($id)->delete();
        /*删除机构id集合*/
        $is_delete = Functions::isCreate(Law::withTrashed(),$id);

        if( $is_delete )
        {
            Toastr::success('删除成功');
        }else
        {
            Toastr::error('删除失败');
        }

        return redirect(route('law.index'));
    }


    /*
     * 法律法规搜索
     *
     * */
    public function search(Request $request)
    {
        $str = $request->input('searchStr');
        $laws = Law::where('name', 'like', '%'.$str.'%')
            ->orWhere('title', 'like', '%'.$str.'%')
            ->orWhere('title_no', 'like', '%'.$str.'%')
            ->orWhere('content', 'like', '%'.$str.'%')
            ->latest()
            ->paginate(15);
        if(count($laws)){
            return view('admin.law.index', compact('laws'));
        }

        return view('admin.law.index');
    }

    /*
    * 法律法规名检查
    *
    * */
    public function checkLaw(Request $request)
    {
        $name = $request->get('name');
        $law = Law::where('name', $name)->get();

        return response()->json(count($law) ? [ 'status' => 1, 'msg' => '法律法规名检查已经存在' ] : [ 'status' => 0 ]);
    }


}
