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

Route::get('/', function () {
    return view('welcome');
});

Route::any('/wechat', 'Home\WeChatController@serve');

//后台路由部分
Route::group(['prefix'=>'admin'],function (){
    //后台登录页面
    Route::get('public/login','Admin\PublicController@login')->name('login');
    //后台登录处理页面
    Route::post('public/check','Admin\PublicController@check');
    //后台退出处理页面
    Route::get('public/logout','Admin\PublicController@logout');
});

//需要权限判断的
Route::group(['prefix'=>'admin','middleware'=>['auth:admin','checkrbac']],function (){
    //后台首页路由
    Route::get('index/index','Admin\IndexController@index');
    Route::get('index/welcome','Admin\IndexController@welcome');

    //管理员的管理模块
    Route::get('manager/index','Admin\ManagerController@index');

    //权限的管理模块
    Route::get('auth/index','Admin\AuthController@index');
    Route::any('auth/add','Admin\AuthController@add');

    //角色权限
    Route::get('role/index','Admin\RoleController@index');
    Route::any('role/assign','Admin\RoleController@assign');

    //会员管理
    Route::get('member/index','Admin\MemberController@index');
    Route::any('member/add','Admin\MemberController@add');

    //头像上传
    Route::post('uploader/webuploader','Admin\uploaderController@webuploader');
    Route::post('uploader/qiniu','Admin\uploaderController@qiniu');
    //ajax联动
    Route::get('member/getareabyid','Admin\MemberController@getAreaById');

    //导出
    Route::get('member/export','Admin\MemberController@export');
    //导入
    Route::any('member/import','Admin\MemberController@import');
});



