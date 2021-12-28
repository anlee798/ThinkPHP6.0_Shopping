<?php

namespace app\index\controller;

use app\index\model\Category;
use app\index\model\Evaluate;
use app\index\model\Goods;
use think\facade\Session;
use think\facade\View;

class Detail
{
    public function index($id){
        $userid =null;
        if(Session::has('id')){
            $userid = Session::get('id');
            View::assign('userid',$userid);
        }

        \app\index\facade\Test::showList();

        //商品信息数据
        $goodsdata = Goods::where('id','=',$id)->select();
        $message = Goods::where('id','=',$id)->select()->column('description');

        $strarr = explode(" ",$message[0]);
        View::assign('goodsdata',$goodsdata);
        View::assign('strarr',$strarr);

        //商品评价
        $evaluate = Evaluate::where('gid','=',$id)->select();
        View::assign('evaluate',$evaluate);

        //商品推荐
        $cid = Goods::where('id','=',$id)->column('cid');
        $tjgoods = Goods::where('cid','=',$cid[0])->where('id','<>',$id)->select();
        View::assign('tjgoods',$tjgoods);
        return View::fetch('detail');
    }

}