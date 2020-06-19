<?php
namespace App\Admin;
use Illuminate\Database\Eloquent\Model;
class Role extends Model
{
    //
    protected $table ='role';
    public $timestamps =false;

    public function assignAuth($data){
        //处理数据
        $posts['auth_ids'] =implode(',',$data['auth_id']);
        //获取auth_ac
        $tmp  =Auth::where('pid','>',0)
            ->whereIn('id',$data['auth_id'])->get();
        $ac ='';
        foreach ($tmp as $key =>$item){
            $ac .=$ac.$item->controller.'@'.$item->action.',';
        }
        $ac =strtolower(rtrim($ac,','));
        $posts['auth_ac'] =$ac;

        return self::where('id',$data['id'])->update($posts);
    }
}
