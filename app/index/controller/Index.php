<?php
namespace app\index\controller;

use app\index\facade\Test;
use app\index\model\Category;
use app\index\model\Goods;
use think\facade\Session;
use think\facade\View;

class Index
{
    //用户id
    public $userid;
    //构造方法
    public function __construct()
    {
        //获取用户ID
        if(Session::has('id')){
            $this->userid = Session::get('id');
            View::assign('userid',$this->userid);
        }
        Test::showList();
    }

    public function index()
    {
        //陈列商品信息数据
        $firstid = Category::where('parent_id','=',0)->limit(1)->select()->column('id');
        $goods=null;
        if($firstid!=null){
            $id = Category::where('parent_id','=',$firstid[0])->limit(1)->column('id');
            if($id!=null){
                $goods = Goods::where('cid','=',$id[0])->where('statue','=',1)->select();
            }
        }
        View::assign('goods',$goods);
        return View::fetch('index');
    }

    public function Get($row,$col){
        //陈列商品信息数据
        $firstid = Category::where('parent_id','=',0)->select()->column('id');
        $goods=null;
        if($firstid!=null){
            $id = Category::where('parent_id','=',$firstid[$row])->select()->column('id');
            if($id!=null){
                $goods = Goods::where('cid','=',$id[$col])->where('statue','=',1)->select();
            }
        }
        View::assign('goods',$goods);
        return View::fetch('index');
    }

    public function Tuichu(){
        Session::delete('id');
        return redirect('/index');
    }

}
