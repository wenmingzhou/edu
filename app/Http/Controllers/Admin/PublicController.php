<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{
    //
    public function login(){
        return view('admin/public/login');
    }

    public function check(Request $request){
        //自动验证
        $this->validate($request,[
            'username' =>'required|max:30|min:2',
            'password' =>'required|min:6',
            'captcha' =>'required|captcha',
        ]);
        //继续开始身份校验
        $data =$request->only(['username','password']);
        $data['status']=2;
        $result =Auth::guard('admin')->attempt($data,$request->get('online'));
        //判断是否成功
        if($result){
            //调整到后台页面
            return redirect('/admin/index/index');
        }else{
            //调整到登录页
            return redirect('/admin/public/login')
                ->withErrors("用户名或密码错误");
        }
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('/admin/public/login');
    }
}
