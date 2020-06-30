<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;


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
                'avatar'        =>Input::get('avatar'),
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

    function export(){

        $cellData = [
            ['学号','姓名','成绩'],
            ['10001','AAAAA','99'],
            ['10002','BBBBB','92'],
            ['10003','CCCCC','95'],
            ['10004','DDDDD','89'],
            ['10005','EEEEE','96'],
        ];

        Excel::create('学生成绩',function($excel) use ($cellData){
            $excel->sheet('score', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');
    }
}
