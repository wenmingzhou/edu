<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UploaderController extends Controller
{
    //
    public function webuploader(Request $request){
        //�ж��Ƿ����ļ��ϴ��ɹ�
        if($request->hasFile('file') && $request->file('file')->isValid()){
            //���ļ��ϴ�
            $filename =sha1(time().$request->file('file')->getClientOriginalName()).
                '.'.$request->file('file')->getClientOriginalExtension();

            Storage::disk('public')->put($filename,file_get_contents($request->file('file')->path()));
            //��������
            $result =[
                'errCode'   =>'0',
                'errMsg'    =>'',
                'path'      =>'/storage/'.$filename,
            ];
        }else{
            //û���ļ��ϴ����߳�����
            $result =[
                'errCode'  =>'10001',
                'errMsg'   =>$request->file('file')->getErrorMessage(),
            ];
        }

        return response()->json($result);

    }

    public function qiniu(Request $request){
        //�ж��Ƿ����ļ��ϴ��ɹ�
        if($request->hasFile('file') && $request->file('file')->isValid()){
            //���ļ��ϴ�
            $filename =sha1(time().$request->file('file')->getClientOriginalName()).
                '.'.$request->file('file')->getClientOriginalExtension();

            Storage::disk('qiniu')->put($filename,file_get_contents($request->file('file')->path()));
            //��������
            $result =[
                'errCode'   =>'0',
                'errMsg'    =>'',
                'path'      =>Storage::disk('qiniu')->downloadUrl($filename),
            ];
        }else{
            //û���ļ��ϴ����߳�����
            $result =[
                'errCode'  =>'10001',
                'errMsg'   =>$request->file('file')->getErrorMessage(),
            ];
        }

        return response()->json($result);
    }
}
