<?php

namespace app\index\controller;

use app\index\model\Adress;
use app\index\model\Goods;
use app\index\model\Order;
use app\index\model\Shopcart;
use think\facade\Db;
use think\facade\Request;
use think\facade\Session;
use think\facade\View;

class ShopCartTest
{
    public $ad = null;

    public function index(){

        if(!Session::has('id')){
            //用户未登录，提醒用户登录undo
            return redirect('/LoginRegister');
        }
        $userid = Session::get('id');

        $message = Db::table('tp_shopcart')->where('uid','=',$userid)
            ->alias('s')->join('tp_goods g','s.gid=g.id')->select();

        View::assign('message',$message);
        View::assign('ad',null);
        View::assign('userid',$userid);

        return View::fetch('shopcarttest');
    }

    public function addGoods($goodid){
        $shopcart = new Shopcart();
        $num = Request::post('num');

        if(!Session::has('id')){
            //用户未登录，提醒用户登录undo
            return readdir();
        }
        $userid = Session::get('id');

        $temp = Shopcart::where('gid','=',$goodid)->where('uid','=',$userid)->column('num');
        if($temp==null){
            $shopcart->save([
                'uid'       =>      Session::get('id'),
                'addtime'   =>      date("Y-m-d H:i:s"),
                'gid'       =>      $goodid,
                'num'       =>      $num,
            ]);
        }else{
            Shopcart::where('gid','=', $goodid)->where('uid','=',$userid)->update([ 'num' => ($temp[0]+$num)]);
        }

        $userid = Session::get('id');

        $message = Db::table('tp_shopcart')->where('uid','=',$userid)->alias('s')->join('tp_goods g','s.gid=g.id')->select();

        View::assign('message',$message);
        View::assign('ad',$this->ad);

        return View::fetch('shopcarttest');
    }

    public function deletecart($gid){
        Shopcart::where('gid','=',$gid)->delete();

        $userid = Session::get('id');

        $message = Db::table('tp_shopcart')->where('uid','=',$userid)->alias('s')->join('tp_goods g','s.gid=g.id')->select();

        View::assign('message',$message);
        View::assign('ad',$this->ad);

        return View::fetch('shopcarttest');
    }

    public function chooseAdress(){
        $userid = Session::get('id');
        $ad = Adress::where('uid','=',$userid)->select();
        $message = Db::table('tp_shopcart')->where('uid','=',$userid)->alias('s')->join('tp_goods g','s.gid=g.id')->select();

        View::assign('ad',$ad);
        View::assign('message',$message);
        return View::fetch('shopcarttest');
    }

    public function addorder($gid,$adid){
        $userid = Session::get('id');
        $message = Db::table('tp_shopcart')->where('uid','=',$userid)->alias('s')->join('tp_goods g','s.gid=g.id')->select();

        View::assign('message',$message);
        View::assign('ad',$this->ad);

        echo "gid".$gid."adid".$adid;
        $num = 0;
        $price = 0;
        foreach ($message as $value){
            if($value['gid']==$gid){
                $num = $value['num'];
                $price = $value['price'];
            }
        }
        $userid = Session::get('id');
        $od = new Order();
        $od->user_id = $userid;
        $od->goods_id = $gid;
        $od->num = $num;
        $od->money = $num*$price;
        $od->user_adress = $adid;
        $od->createtime = date("Y-m-d H:i:s");
        $od->save();
        $good = Goods::where("id","=",$value['id'])->select();
        $good[0]['stock'] = $good[0]['stock']-$num;
        $good[0]['sales'] = $good[0]['sales']+$num;
        Goods::update([
            "stock"  =>   $good[0]['stock'],
            "sales"   =>   $good[0]['sales']
        ],["id" => $value['id']]);
        return redirect("/shopcarttest/deletecart/gid/{$gid}");
    }

    public function clearShopCart(){
        $userid = Session::get('id');
        $ad = Adress::where('uid','=',$userid)->select();
        $message = Db::table('tp_shopcart')->where('uid','=',$userid)
            ->alias('s')->join('tp_goods g','s.gid=g.id')->select();
        View::assign('ad2',$ad);
        View::assign('message',$message);
        return View::fetch("ShopCartTest/shopcarttest");
    }

    public function addallorder($adid){
        $userid = Session::get('id');
        $shopcart = Shopcart::where("uid",'=',$userid)->select();
        foreach ($shopcart as $value){
            $message = Db::table('tp_shopcart')->where('uid','=',$userid)->alias('s')->join('tp_goods g','s.gid=g.id')->select();

            $num = 0;
            $price = 0;
            foreach ($message as $value){
                if($value['gid']==$value['id']){
                    $num = $value['num'];
                    $price = $value['price'];
                }
            }
            $userid = Session::get('id');
            $od = new Order();
            $od->user_id = $userid;
            $od->goods_id = $value['id'];
            $od->num = $num;
            $od->money = $num*$price;
            $od->user_adress = $adid;
            $od->createtime = date("Y-m-d H:i:s");
            $od->save();

            $good = Goods::where("id","=",$value['id'])->select();
            $good[0]['stock'] = $good[0]['stock']-$num;
            $good[0]['sales'] = $good[0]['sales']+$num;
            Goods::update([
                "stock"  =>   $good[0]['stock'],
                "sales"   =>   $good[0]['sales']
            ],["id" => $value['id']]);
            $this->deletecart($value['id']);
        }
        return View::fetch("shopcarttest");
    }

}