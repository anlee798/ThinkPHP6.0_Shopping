<?php

namespace app\index\controller;

use app\index\model\Order;
use think\facade\Session;
use think\facade\View;

class OrderContr
{
    public $userid;
    public function __construct()
    {
        $this->userid = Session::get('id');
        View::assign('userid',$this->userid);
    }

    public function index(){
        if(!Session::has('id')){
            //用户未登录，提醒用户登录undo
            return redirect('http://www.test.com/webtest/login');
        }
        \app\index\facade\Test::getOrderID($this->userid);
        return View::fetch('ordercontr');
    }

    public function deleteOrder($oid){
        $userid = Session::get('id');
        Order::where('id','=',$oid)->update([
           'statue'     =>      0,
        ]);
        \app\index\facade\Test::getOrderID($this->userid);
        return View::fetch('ordercontr');
    }

}