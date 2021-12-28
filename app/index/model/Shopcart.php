<?php

namespace app\index\model;

use think\Model;

class Shopcart extends Model
{
    //设置表
    protected $table = 'tp_shopcart';

    public function profile(){
        return $this->hasOne('Goods','id','gid');
    }
}