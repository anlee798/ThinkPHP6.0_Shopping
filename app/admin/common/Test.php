<?php

namespace app\admin\common;

use think\facade\Db;
use think\facade\Session;
use think\facade\View;

class Test
{
    //获取用户ID
    public function getAdminID(){
        if(Session::has('adminid')){
            $this->adminid = Session::get('adminid');
            View::assign('userid',$this->adminid);
            return $this->adminid;
        }else{
            return null;
        }
    }

    //获取订单信息
    public function getOrder(){
        $order = Db::name('order')->alias('o')
            ->join('tp_goods g','o.goods_id=g.id')
            ->join('tp_adress a','o.user_adress=a.id')
            ->field('o.id,g.gname,g.imgsrc,g.statue,g.price,g.id goods_id,o.user_id,o.statue,o.num,o.money,a.adress,o.createtime')
            ->paginate(7);
        View::assign('ordercontr',$order);
    }

    //获取商品信息
    public function getGoods(){
        $goods=Db::name('goods')->alias('g')->join('tp_category c','g.cid=c.id')
            ->field('g.id,g.gname,c.name,g.price,g.imgsrc,c.create_time,g.stock,g.sales,g.evaluate')
            ->where('statue','=',1)->paginate(7);

        View::assign('goods',$goods);
    }
}