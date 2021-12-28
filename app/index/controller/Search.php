<?php

namespace app\index\controller;

use app\index\facade\Test;
use app\index\model\Category;
use app\index\model\Goods;
use think\facade\Db;
use think\facade\Request;
use think\facade\Session;
use think\facade\View;

class Search
{
    public function index(){
        if(Session::has('id')){
            $userid = Session::get('id');
            View::assign('userid',$userid);
        }
        $search = Request::post('search');
        if($search==''){
            return redirect('index');
        }
        $gname = Goods::field('id,gname')->select();
        $arr = array();
        foreach ($gname as $key=>$value){
            if(strstr($value['gname'],$search)){
                $arr[] = $value['id'];
            }
        }
        $serachgood = Db::name('goods')->whereIn('id',$arr)->select();
        View::assign('serachgood',$serachgood);

        Test::showList();

        return View::fetch('search');
    }
}