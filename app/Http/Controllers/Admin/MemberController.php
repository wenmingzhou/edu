<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class MemberController extends Controller
{
    //
    function index(){
        $data =Member::get();
        return view('admin.member.index',compact('data'));
    }

    function add(){
        if (Input::method()=='POST'){
            //自动验证
            $result =Member::insert([
                'username'      =>Input::get('username'),
                'password'      =>bcrypt('password'),
                'gender'        =>Input::get('gender'),
                'mobile'        =>Input::get('mobile'),
                'email'         =>Input::get('email'),
                'avatar'        =>'/static/avatar.jpg',
                'country_id'    =>Input::get('country_id'),
                'province_id'   =>Input::get('province_id'),
                'city_id'       =>Input::get('city_id'),
                'county_id'     =>Input::get('county_id'),
                'type'          =>Input::get('type'),
                'status'        =>Input::get('status'),
                'created_at'    =>date('Y-m-d H:i:s'),
            ]);

            return $result ? '1':'0';


        }else{
            $country =DB::table('area')->where('pid','0')->get();
            return view('admin.member.add',compact('country'));
        }
    }
    //ajax
    function getAreaById(){
        $id =Input::get('id');
        $data =DB::table('area')->where('pid',$id)->get();
        return response()->json($data);
    }
}
