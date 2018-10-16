<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
 *金牌顾问工具系统企业端
 *  */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
    $host_vip = 'lvip.elinkport.com';
    $host = 'lgold.elinkport.com';

  if($_SERVER['HTTP_HOST'] === 'tgold.elinkport.com' || $_SERVER['HTTP_HOST'] === 'tvip.elinkport.com'){
      $host_vip = 'tvip.elinkport.com';
      $host = 'tgold.elinkport.com';
  }elseif($_SERVER['HTTP_HOST'] === 'gold.elinkport.com' || $_SERVER['HTTP_HOST'] === 'vip.elinkport.com'){
      $host_vip = 'vip.elinkport.com';
      $host = 'gold.elinkport.com';
  }

Route::group(['domain'=> $host_vip], function ()
{
    Auth::routes();
    Route::get('/', 'HomeController@index');
    Route::post('/user/resetpassword',['as'=>'user.resetpassword','uses'=>'HomeController@resetPassword']);//修改密码
    //材料清单
    Route::get('/material/preview/{item}', [ 'as' => 'guest.material.preview', 'uses' => 'MaterialController@preview' ]);//材料清单在线预览封面
    Route::get('/material/preview/msg/{item}', [ 'as' => 'guest.material.preview.msg', 'uses' => 'MaterialController@previewMsg' ]);//在线预览清单信息
    Route::get('/material/preview/data/{item}', [ 'as' => 'guest.material.preview.data', 'uses' => 'MaterialController@previewData' ]);//在线预览清单审核资料
    //诊断报告
    Route::get('/diag/preview/{item}', [ 'as' => 'guest.diag.preview', 'uses' => 'DiagnosisController@preview' ]);//在线预览封面
    Route::get('/diag/preview/msg/{item}', [ 'as' => 'guest.diag.preview.msg', 'uses' => 'DiagnosisController@previewMsg' ]);//在线预览诊断概述
    Route::get('/diag/preview/data/{item}', [ 'as' => 'guest.diag.preview.data', 'uses' => 'DiagnosisController@previewData' ]);//在线预览具体分析
    Route::get('/diag/preview/company/{item}', [ 'as' => 'guest.diag.preview.company', 'uses' => 'DiagnosisController@previewCompany' ]);//在线预览企业背景
    Route::get('/diag/preview/closure/{item}', [ 'as' => 'guest.diag.preview.closure', 'uses' => 'DiagnosisController@previewClosure' ]);//在线预览附录
    //实施计划
    Route::get('/improve/preview/{item}', [ 'as' => 'guest.improve.preview', 'uses' => 'ImproveController@preview' ]);//实施计划在线预览
    Route::get('/improve/preview/msg/{item}', [ 'as' => 'guest.improve.preview.msg', 'uses' => 'ImproveController@previewMsg' ]);//实施计划在线预览信息
    //服务反馈
    Route::get('/item/{item}/suggest', [ 'as' => 'guest.suggest.index', 'uses' => 'SuggestController@index' ]);//服务反馈
    Route::get('/suggest/{suggest}', [ 'as' => 'guest.suggest.edit', 'uses' => 'SuggestController@edit' ]);//服务反馈评价
    Route::get('/suggest/{suggest}/show', [ 'as' => 'guest.suggest.show', 'uses' => 'SuggestController@show' ]);//服务反馈评价
    Route::post('/suggest/{suggest}', [ 'as' => 'guest.suggest.store', 'uses' => 'SuggestController@store' ]);//服务反馈评价

});

/*
 * 金牌顾问工具系统后台
 *
 * */
Route::group(['domain'=> $host], function () {

    Route::get('/',function(){
            return redirect(route('home.index'));
    });

    Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function ( $router) {

    $router->get('/',['as'=>'home.index','uses'=>'HomeController@index']);
    /*模板管理*/
    $router->get('/template',['as'=>'template.index','uses'=>'TemplateController@index']);

    $router->get('/template/{template_name}/material',['as'=>'template.material','uses'=>'MaterialController@temp']);////材料清单模板
    $router->get('/template/material/{mater}/create',['as'=>'template.material.create','uses'=>'MaterialController@temp_create']);//新增材料清单模板
    $router->get('/template/material/{mater}/edit',['as'=>'template.material.edit','uses'=>'MaterialController@temp_edit']);//编辑材料清单模板
    $router->post('/template/material/{mater}/store',['as'=>'template.material.store','uses'=>'MaterialController@temp_store']);//保存材料清单模板
    $router->post('/template/material/{mater}/content/update',['as'=>'template.material.update','uses'=>'MaterialController@temp_update']);//更新材料清单模板
    $router->post('/template/material/delete/{mater}',['as'=>'template.material.destroy','uses'=>'MaterialController@temp_destroy']);//删除材料清单模板

    $router->get('/template/material/depart',['as'=>'material.depart','uses'=>'MaterialController@depart']);//模板增加子模块
    $router->post('/template/{material_name}/materia/sub',['as'=>'template.material.sub.store','uses'=>'MaterialController@tempStore']);//模板保存子模块
    $router->post('/template/material/sub/{material}/edit',['as'=>'template.material.sub.edit','uses'=>'MaterialController@tempEdit']);//模板编辑子模块
    $router->post('/template/material/sub/{material}/update',['as'=>'template.material.sub.update','uses'=>'MaterialController@tempUpdate']);//模板更新子模块
    $router->post('/template/material/sub/{material}/destroy',['as'=>'template.material.sub.destory','uses'=>'MaterialController@tempDestroy']);//模板删除子模块

    /*诊断报告模板管理*/
    $router->get('/template/diag',['as'=>'template.diag','uses'=>'DiagController@temp']);//诊断报告
    $router->get('/template/diag/edit/{diag}',['as'=>'template.diag.edit','uses'=>'DiagController@tempEdit']);//诊断报告编辑
    $router->post('/item/diag/store/{diag}',['as'=>'template.diag.store','uses'=>'DiagController@tempStore']);//诊断报告保存

    //诊断结果具体分析
    $router->get('/template/diags/aeo',['as'=>'template.aeo','uses'=>'DiagnosisController@tempAeo']);//海关AEO
    $router->get('/template/diags/guanwu',['as'=>'template.guanwu','uses'=>'DiagnosisController@tempGuanwu']);//关务风险
    $router->get('/template/diags/system',['as'=>'template.system','uses'=>'DiagnosisController@tempSystem']);//系统化
    $router->get('/template/diags/wuliu',['as'=>'template.wuliu','uses'=>'DiagnosisController@tempWuliu']);//物流风险
    $router->get('/template/diags/edit/{diags}',['as'=>'template.diags.edit','uses'=>'DiagnosisController@tempEdit']);//编辑诊断结果具体分析任务
    $router->get('/template/diags/update/{diags}',['as'=>'template.diags.update','uses'=>'DiagnosisController@tempUpdate']);//更新诊断结果具体分析任务

    $router->get('/template/diags/addmod/{diag_mod}',['as'=>'template.diags.addmod','uses'=>'DiagnosisController@tempAddMod']);//增加子模块
    $router->post('/template/diags/addmod/{diag_mod}',['as'=>'template.diags.submod.store','uses'=>'DiagnosisController@tempSubModStore']);//保存子模块
    $router->post('/template/diags/addmod/{diag_submod}/edit',['as'=>'template.diags.submod.edit','uses'=>'DiagnosisController@tempSubModEdit']);//编辑子模块
    $router->post('/template/diags/addmod/{diag_submod}/update','DiagnosisController@tempSubModUpdate');//更新子模块
    $router->post('/template/diags/addmod/destroy/{diag_submod}',['as'=>'template.diags.submod.destroy','uses'=>'DiagnosisController@tempSubModDestroy']);//删除子模块

    $router->post('/template/diags/addcontent/{diag_submod}',['as'=>'template.diags.addcontent','uses'=>'DiagnosisController@tempAddContent']);//增加内容
    $router->post('/template/diags/editcontent/{diag_subcon}',['as'=>'template.diags.editcontent','uses'=>'DiagnosisController@tempEditContent']);//编辑子模块内容
    $router->post('/template/diags/storecontent/{diag_subcon}','DiagnosisController@tempUpdateContent');//更新子模块内容
    $router->post('/template/diags/delcontent/{diag_subcon}',['as'=>'template.diags.delcontent','uses'=>'DiagnosisController@tempDelContent']);//删除子模块内容

    $router->post('/template/diags/{diag_subcon}/law/edit',['as'=>'template.diags.law.edit','uses'=>'DiagnosisController@tempEditLaw']);//编辑法律法规名
    $router->post('/template/diags/{diag_subcon}/law',['as'=>'template.diags.law','uses'=>'DiagnosisController@tempSeeEditLaw']);//编辑页查看法律法规
    $router->post('/template/diags/{diag_subcon}/law/see',['as'=>'template.diags.law.see','uses'=>'DiagnosisController@tempSeeLaw']);//查看法律法规
    $router->post('/template/diags/{diag_subcon}/law/store',['as'=>'template.diags.law.store','uses'=>'DiagnosisController@tempStoreSubContent']);//更新子模块内容
    $router->post('/template/diags/law/relatename',['as'=>'template.diags.law.relate.name','uses'=>'DiagnosisController@tempRelateLawName']);///*法律法规条例名称联动*/
    $router->post('/template/diags/law/relatetitle',['as'=>'template.diags.law.relate.title','uses'=>'DiagnosisController@tempRelateLawTitle']);  /*法规条例文号联动*/

    /*后台 注册登陆退出*/
    $router->get('login', 'LoginController@showLoginForm');
    $router->post('login', 'LoginController@login')->name('admin.login');
    $router->post('logout', 'LoginController@logout');
    /*员工管理*/

    $router->resource('/admin_user', 'AdminUserController');
    $router->post('/admin_user/destroyall',['as'=>'admin.admin_user.destroy.all','uses'=>'AdminUserController@destroyAll']);//员工批量删除
    $router->post('/admin_user/search',['as'=>'admin_user.search','uses'=>'AdminUserController@search']);//员工搜索
    $router->post('/admin_user/checkdata',['as'=>'admin_user.checkdata','uses'=>'AdminUserController@checkAdminUser']);//员工用户名检查
    $router->post('/admin_user/frozen/{admin_user}',['as'=>'admin_user.frozen','uses'=>'AdminUserController@frozen']);//冻结员工
    $router->post('/admin_user/refrozen/{admin_user}',['as'=>'admin_user.refrozen','uses'=>'AdminUserController@refrozen']);//解冻员工
    $router->post('/admin_user/resetpassword',['as'=>'admin_user.resetpassword','uses'=>'AdminUserController@resetPassword']);//修改密码
    /*角色*/
    $router->resource('/role', 'RoleController');
    $router->post('/role/destroyall',['as'=>'admin.role.destroy.all','uses'=>'RoleController@destroyAll']);
    $router->get('/role/{role}/permissions',['as'=>'admin.role.permissions','uses'=>'RoleController@permissions']);
    $router->post('/role/{role}/permissions',['as'=>'admin.role.permissions.update','uses'=>'RoleController@storePermissions']);
    $router->post('/role/search',['as'=>'role.search','uses'=>'RoleController@search']);
    /*权限管理*/
    $router->resource('permission', 'PermissionController');
//    $router->post('permission/destroyall',['as'=>'admin.permission.destroy.all','uses'=>'PermissionController@destroyAll']);
    $router->post('/permission/search',['as'=>'permission.search','uses'=>'PermissionController@search']);
    $router->get('/permission/sub/{permission}',['as'=>'sub.edit','uses'=>'PermissionController@subeEdit']);
    //客户管理
    $router->resource('/user','UserController');
//    $router->post('/import',['as'=>'user.import','uses'=>'UserController@import']);//导入
//    $router->get('/export',['as'=>'user.export','uses'=>'UserController@export']);//导出
    $router->post('/custom/search',['as'=>'user.admin.search','uses'=>'UserController@search']);//搜索
    $router->post('/user/destroyall',['as'=>'admin.user.destroy.all','uses'=>'UserController@destroyAll']);//批量删除客户
    //子账号编辑
    $router->get('/user/depart/{depart}/edit/{user}',['as'=>'depart.edit','uses'=>'UserProfileController@edit']);//子账号编辑
    $router->get('/user/depart/{user}',['as'=>'depart.show','uses'=>'UserProfileController@show']);//子账号显示
    $router->post('/user/depart/{depart}/update/{user}',['as'=>'depart.update','uses'=>'UserProfileController@update']);//子账号更新
    $router->post('/user/depart/{user}/store',['as'=>'depart.store','uses'=>'UserProfileController@store']);//子账号保存
    $router->post('/user/checkdata',['as'=>'depart.checkdata','uses'=>'UserProfileController@checkUser']);//检查子账号用户名
    $router->post('/user/depart/{admin_user}/search',['as'=>'depart.search','uses'=>'UserProfileController@search']);//子账号搜索
    $router->post('/user/depart/{depart}/destroy/{user}',['as'=>'depart.destroy','uses'=>'UserProfileController@destroy']);//子账号删除
    $router->post('/user/depart/destroyall',['as'=>'depart.destroy.all','uses'=>'UserProfileController@destroyAll']);//子账号批量删除
    $router->post('/user/depart/{depart}/frozen/{user}',['as'=>'user.frozen','uses'=>'UserProfileController@frozen']);//冻结员工
    $router->post('/user/depart/{depart}/refrozen/{user}',['as'=>'user.refrozen','uses'=>'UserProfileController@refrozen']);//解冻员工
//    $router->post('/user/resetpassword',['as'=>'user.resetpassword','uses'=>'UserProfileController@resetPassword']);//修改密码
    //交接单
    $router->get('/handover/create/{admin_user}',['as'=>'handover.create','uses'=>'HandoverController@create']);
    $router->get('/handover/{admin_user}/show',['as'=>'handover.show','uses'=>'HandoverController@show']);
    $router->get('/handover/{admin_user}/edit',['as'=>'handover.edit','uses'=>'HandoverController@edit']);
    $router->post('/handover/{admin_user}/store',['as'=>'handover.store','uses'=>'HandoverController@store']);
    $router->post('/handover/{hand}/update/{admin_user}',['as'=>'handover.update','uses'=>'HandoverController@update']);
    $router->post('/handover/{contacter}/destroy',['as'=>'contacter.destroy','uses'=>'HandoverController@contacterDestroy']);
    //审核机构
    $router->resource('/mech','MechanismController');
    $router->post('/mech/search',['as'=>'mech.search','uses'=>'MechanismController@search']);//搜索
    $router->post('/mech/checkdata',['as'=>'mech.checkdata','uses'=>'MechanismController@checkMech']);//审核机构名检查
    //项目
    $router->resource('/item','ItemController');
    $router->get('/item_pro/{item}',['as'=>'item.pro','uses'=>'ItemController@pro']);//项目概况
    $router->post('/item/update_item/{hand}',['as'=>'item.hand.update','uses'=>'ItemController@updateItem']);//配置项目
    $router->post('/item/addTeamer/{hand}',['as'=>'item.addTeamer','uses'=>'ItemController@addTeamer']);//添加成员
    $router->post('/item/search',['as'=>'item.search','uses'=>'ItemController@search']);//搜索
    /*图片上传*/
    $router->post('/item/{item}/image/upload',['as'=>'item.image.upload','uses'=>'ImageController@upload']);//项目图片上传
    $router->post('/item/image/crop/{item}',['as'=>'item.image.crop','uses'=>'ImageController@postCrop']);//项目图片裁剪
    $router->post('/item/{item}/add/admin_user/{admin_user}',['as'=>'item.add.master','uses'=>'ItemController@addMaster']);//设置总负责人
    $router->post('/item/{item}/delete/admin_user/{admin_user}',['as'=>'item.delete.master','uses'=>'ItemController@delMaster']);//移除成员
    //材料清单
    $router->get('/item/{item}/material/',['as'=>'material.index','uses'=>'MaterialController@index']);//材料清单
    $router->get('/item/{item}/material/{mater}/create',['as'=>'material.create','uses'=>'MaterialController@create']);//新增
    $router->get('/item/{item}/material/{mater}/edit/{mater_con}',['as'=>'material.edit','uses'=>'MaterialController@edit']);//编辑
    $router->post('/item/{item}/material/{mater}',['as'=>'material.store','uses'=>'MaterialController@store']);//保存
    $router->post('/item/{item}/material/{mater}/update/{mater_con}',['as'=>'material.update','uses'=>'MaterialController@update']);//更新
    $router->post('/item/material/checkdepart',['as'=>'material.checkdepart','uses'=>'MaterialController@checkDepart']);//检查材料清单
    $router->post('/item/material/delete/{mater}',['as'=>'material.destroy','uses'=>'MaterialController@destroy']);//删除
    $router->get('/item/{item}/material/export/word',['as'=>'material.export.word','uses'=>'MaterialController@exportWord']);//导出word
//    $router->get('/item/{item}/material/export/pdf',['as'=>'material.export.pdf','uses'=>'MaterialController@exportPdf']);//导出PDF

    $router->get('/item/{item}/material/addmod/',['as'=>'material.addmod','uses'=>'MaterialController@addMod']);//增加子模块
    $router->post('/item/{item}/material',['as'=>'material.submod.store','uses'=>'MaterialController@subModStore']);//保存子模块
    $router->post('/item/material/addmod/{material}/edit',['as'=>'material.submod.edit','uses'=>'MaterialController@subModEdit']);//编辑子模块
    $router->post('/item/material/addmod/{material}/update',['as'=>'material.submod.update','uses'=>'MaterialController@subModUpdate']);//更新子模块
    $router->post('/item/material/addmod/{material}/destroy',['as'=>'material.submod.destroy','uses'=>'MaterialController@subModDestroy']);//删除子模块

    $router->get('/item/{item}/material/preview',['as'=>'material.preview','uses'=>'MaterialController@preview']);//在线预览封面
    $router->get('/item/{item}/material/preview/msg',['as'=>'material.preview.msg','uses'=>'MaterialController@previewMsg']);//在线预览清单信息
    $router->get('/item/{item}/material/preview/data',['as'=>'material.preview.data','uses'=>'MaterialController@previewData']);//在线预览清单审核资料
    $router->get('/item/{item}/material/preview/active',['as'=>'material.preview.active','uses'=>'MaterialController@active']);//交付客户

    //诊断报告
    $router->get('/item/{item}/diag/',['as'=>'diag.index','uses'=>'DiagController@index']);//诊断报告
    $router->get('/item/{item}/diag/edit/{diag}',['as'=>'diag.edit','uses'=>'DiagController@edit']);//诊断报告编辑
    $router->post('/item/diag/store/{diag}',['as'=>'diag.store','uses'=>'DiagController@store']);//诊断报告保存

    $router->get('/item/{item}/diag/background/',['as'=>'user.background','uses'=>'DiagController@background']);//企业背景
    $router->get('/item/{item}/diag/background/edit/{admin_user}',['as'=>'user.background.edit','uses'=>'DiagController@bgEdit']);//编辑企业背景
    $router->post('/item/diag/background/update/{admin_user}',['as'=>'user.background.update','uses'=>'DiagController@bgUpdate']);//更新企业背景

    $router->get('/item/{item}/diag/closure/',['as'=>'closure.index','uses'=>'DiagController@closure']);//附件
    $router->get('/item/{item}/diag/closure/edit',['as'=>'closure.edit','uses'=>'DiagController@closureEdit']);//附件编辑
    $router->post('/item/diag/closure/{closure}/edit',['as'=>'closure.update','uses'=>'DiagController@closureUpdate']);//附件更新

	$router->get('/item/{item}/diag/preview',['as'=>'diag.preview','uses'=>'DiagController@preview']);//在线预览封面
	$router->get('/item/{item}/diag/preview/msg',['as'=>'diag.preview.msg','uses'=>'DiagController@previewMsg']);//在线预览诊断概述
	$router->get('/item/{item}/diag/preview/data',['as'=>'diag.preview.data','uses'=>'DiagController@previewData']);//在线预览具体分析
	$router->get('/item/{item}/diag/preview/company',['as'=>'diag.preview.company','uses'=>'DiagController@previewCompany']);//在线预览企业背景
	$router->get('/item/{item}/diag/preview/closure',['as'=>'diag.preview.closure','uses'=>'DiagController@previewClosure']);//在线预览附录
    $router->get('/item/{item}/diag/preview/active',['as'=>'diag.preview.active','uses'=>'DiagController@active']);//交付客户
    $router->get('/item/{item}/diag/export/word',['as'=>'diag.export.word','uses'=>'DiagController@exportWord']);//导出word
    //实施计划
    $router->get('/item/{item}/improve/',['as'=>'improve.index','uses'=>'ImproveController@index']);//改善实施计划
    $router->post('/item/{item}/improve/store',['as'=>'improve.store','uses'=>'ImproveController@store']);//保存
    $router->get('/item/{item}/improve/edit',['as'=>'improve.edit','uses'=>'ImproveController@edit']);//编辑
    $router->post('/item/{item}/improve/update',['as'=>'improve.update','uses'=>'ImproveController@update']);//更新
    $router->get('/item/{item}/improve/task/edit/{improve}',['as'=>'improve.task.edit','uses'=>'ImproveController@taskEdit']);//实施计划任务编辑
    $router->post('/item/{item}/improve/task/edit/{improve}',['as'=>'improve.task.update','uses'=>'ImproveController@taskEdit']);//实施计划任务编辑
	$router->get('/item/{item}/improve/preview',['as'=>'improve.preview','uses'=>'ImproveController@preview']);//实施计划在线预览
	$router->get('/item/{item}/improve/preview/msg',['as'=>'improve.preview.msg','uses'=>'ImproveController@previewMsg']);//在线预览
    $router->get('/item/{item}/improve/preview/active',['as'=>'improve.preview.active','uses'=>'ImproveController@active']);//交付客户
    //诊断结果具体分析
    $router->get('/item/{item}/diags/aeo',['as'=>'aeo.diags','uses'=>'DiagnosisController@aeo']);//海关AEO
    $router->get('/item/{item}/diags/guanwu',['as'=>'guanwu.diags','uses'=>'DiagnosisController@guanwu']);//关务风险
    $router->get('/item/{item}/diags/system',['as'=>'system.diags','uses'=>'DiagnosisController@system']);//系统化
    $router->get('/item/{item}/diags/wuliu',['as'=>'wuliu.diags','uses'=>'DiagnosisController@wuliu']);//物流风险
    $router->get('/item/{item}/diags/edit/{diags}',['as'=>'diags.edit','uses'=>'DiagnosisController@edit']);//编辑诊断结果具体分析任务
    $router->get('/item/{item}/diags/update/{diags}',['as'=>'diags.update','uses'=>'DiagnosisController@update']);//更新诊断结果具体分析任务

    $router->get('/item/{item}/diags/addmod/{diag_mod}',['as'=>'diags.addmod','uses'=>'DiagnosisController@addMod']);//增加子模块
    $router->post('/item/diags/addmod/{diag_mod}',['as'=>'diags.submod.store','uses'=>'DiagnosisController@subModStore']);//保存子模块
    $router->post('/item/diags/addmod/{diag_submod}/edit',['as'=>'diags.submod.edit','uses'=>'DiagnosisController@subModEdit']);//编辑子模块
    $router->post('/item/diags/addmod/{diag_submod}/update',['as'=>'diags.submod.update','uses'=>'DiagnosisController@subModUpdate']);//更新子模块
    $router->post('/item/diags/addmod/destroy/{diag_submod}',['as'=>'diags.submod.destroy','uses'=>'DiagnosisController@subModDestroy']);//删除子模块

    $router->post('/item/diags/addcontent/{diag_submod}',['as'=>'diags.addcontent','uses'=>'DiagnosisController@addContent']);//增加内容
    $router->post('/item/diags/editcontent/{diag_subcon}',['as'=>'diags.editcontent','uses'=>'DiagnosisController@editContent']);//编辑子模块内容
    $router->post('/item/diags/storecontent/{diag_subcon}',['as'=>'diags.storecontent','uses'=>'DiagnosisController@storeContent']);//保存子模块内容
    $router->post('/item/diags/delcontent/{diag_subcon}',['as'=>'diags.delcontent','uses'=>'DiagnosisController@delContent']);//删除子模块内容

    $router->post('/item/diags/{diag_subcon}/law/edit',['as'=>'diags.law.edit','uses'=>'DiagnosisController@editLaw']);//编辑法律法规名
    $router->post('/item/diags/{diag_subcon}/law',['as'=>'diags.law','uses'=>'DiagnosisController@seeEditLaw']);//编辑页查看法律法规
    $router->post('/item/diags/{diag_subcon}/law/see',['as'=>'diags.law.see','uses'=>'DiagnosisController@seeLaw']);//查看法律法规
    $router->post('/item/diags/{diag_subcon}/law/store',['as'=>'diags.law.store','uses'=>'DiagnosisController@storeSubContent']);//更新子模块内容
    $router->post('/item/diags/law/relatename',['as'=>'diags.law.relate.name','uses'=>'DiagnosisController@relateLawName']);///*法律法规条例名称联动*/
    $router->post('/item/diags/law/relatetitle',['as'=>'diags.law.relate.title','uses'=>'DiagnosisController@relateLawTitle']);  /*法规条例文号联动*/

    //任务
    $router->get('/item/{item}/task/all',['as'=>'all.task','uses'=>'TaskController@all']);//我的任务
    $router->get('/item/{item}/task/',['as'=>'task.index','uses'=>'TaskController@index']);//我的任务
    $router->post('/item/task/show/{task}',['as'=>'task.show','uses'=>'TaskController@show']);//任务详情
    $router->get('/item/{item}/task/allot/',['as'=>'allot.index','uses'=>'TaskController@allot']);//我分配的
    $router->post('/item/{item}/task/setTask/{model_id}',['as'=>'task.settask','uses'=>'TaskController@setTask']);//分配任务
    $router->post('/item/{item}/task/checktask/{model_id}',['as'=>'task.checktask','uses'=>'TaskController@checkTask']);//检查任务是任务
    $router->post('/item/{item}/task/setTaskAll/{model_id}',['as'=>'task.set_task_all','uses'=>'TaskController@setTaskAll']);//一键分配任务
    $router->post('/item/task/tasks/{model_id}',['as'=>'task.settasks','uses'=>'TaskController@setTasks']);//指派任务
    $router->post('/item/task/complete',['as'=>'task.complete','uses'=>'TaskController@complete']);//去完成任务
    $router->post('/item/task/solution',['as'=>'task.solution','uses'=>'TaskController@solution']);//确认完成
    $router->post('/item/task/appcet',['as'=>'task.appcet','uses'=>'TaskController@appcet']);//验收任务
    $router->post('/item/task/{task}/delay',['as'=>'task.delay','uses'=>'TaskController@delay']);//延期任务
    $router->post('/item/task/{task}/checkdelay',['as'=>'task.checkdelay','uses'=>'TaskController@checkDelay']);//检查延期时间必须大于计划完成时间
    $router->get('/item/{item}/task/search',['as'=>'task.search','uses'=>'TaskController@search']);//我的任务搜索
    $router->get('/item/{item}/task/allot/search',['as'=>'allot.search','uses'=>'TaskController@searchAllot']);//我分配的搜索
    $router->get('/item/{item}/task/all/search',['as'=>'all.search','uses'=>'TaskController@searchAll']);//我分配的搜索

    $router->resource('/law','LawController');//法律法规
    $router->post('/law/search',['as'=>'law.search','uses'=>'LawController@search']);//搜索
    $router->post('/law/checkdata',['as'=>'law.checkdata','uses'=>'LawController@checkLaw']);//法律法规名检查
    
    $router->get('/item/{item}/suggest/{task}',['as'=>'suggest.index','uses'=>'SuggestController@index']);//服务反馈
    $router->get('/item/{item}/suggest/show/{task}',['as'=>'suggest.show','uses'=>'SuggestController@show']);//服务反馈评价
    $router->post('/item/suggest/{task}',['as'=>'suggest.store','uses'=>'SuggestController@store']);//服务反馈评价
    $router->get('/item/suggest/{suggest}/active/',['as'=>'suggest.active','uses'=>'SuggestController@active']);//提交客户

//    /*
// * 全文搜索测试部分
// */
//    Route::post('/admin_user/search',['as'=>'admin_user.search','uses'=>'AdminUserController@search']);

});
});
