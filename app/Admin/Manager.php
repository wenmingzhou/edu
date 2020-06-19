<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;

class Manager extends Model implements \Illuminate\Contracts\Auth\Authenticatable
{
    //定义当前模型需要关联的数据表
    protected $table ='manager';
    //使用trait,相当于将整个trait代码复制到这个里面
    //protected $primaryKey   ='id';
    use Authenticatable;

    //定义与角色模型管理模型的关系
    public function role(){
        return $this->hasOne('App\Admin\Role','id','role_id');
    }
}
