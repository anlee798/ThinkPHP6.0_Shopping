<?php

namespace app\index\common;

use app\index\model\Category;
use think\facade\Db;
use think\facade\View;

class Test
{
    //二级列表数据(index/detail)
    public function showList(){
        //二级列表数据
        $res = Category::where('parent_id','=',0)->select();

        $data = $res->column('id');

        for($i = 0;$i<count($data);$i++){
            $dd = Category::where('parent_id','=',$data[$i])->column('name');
            for($j=0;$j<count($dd);$j++){
                $MyData[$i][$j]= $dd[$j];
            }
        }
        View::assign('datas',$MyData);
        View::assign('users',$res);
    }

    //获取订单数据(OrderContr)
    public function getOrderID($userid){
        $order = Db::name('order')->alias('o')
            ->where('user_id','=',$userid)->where('o.statue','=','1')
            ->join('tp_goods g','o.goods_id=g.id')
            ->join('tp_adress a','o.user_adress=a.id')
            ->field('o.id,g.gname,g.imgsrc,g.statue,g.price,g.id goods_id,o.statue,o.num,o.money,a.adress,o.createtime')->select();
        View::assign('order',$order);
    }

}