<?php

namespace app\index\controller;

use app\index\model\Evaluate;
use app\index\model\Goods;
use think\facade\Db;
use think\facade\Request;
use think\facade\Session;
use think\facade\View;

class EvaluateTest
{
    public function index($gid){
        $userid = Session::get('id');

        $goods = Goods::where('id','=',$gid)->select();

        View::assign('goods',$goods);
        View::assign('userid',$userid);
        return View::fetch('evaluatetest');
    }
    public function sub($gid){
        $text = Request::post('text');
        $userid = Session::get('id');

        if($text==''){
            View::assign('message2','提交信息失败！');
        }else{
            $evaluate = new Evaluate();
            $evaluate->save([
                'uid'       =>      $userid,
                'gid'       =>      $gid,
                'nav'       =>      $text,
            ]);
            View::assign('message','提交信息成功！');
            $evaluate = Goods::where('id','=',$gid)->column('evaluate');
            Goods::where('id','=',$gid)->update([
                'evaluate'      =>     $evaluate[0]+1,
            ]);
        }
        $goods = Goods::where('id','=',$gid)->select();
        View::assign('goods',$goods);
        View::assign('userid',$userid);
        return View::fetch('evaluatetest');
    }
}