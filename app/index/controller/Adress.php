<?php

namespace app\index\controller;

use think\facade\Request;
use think\facade\Session;
use think\facade\View;

class Adress
{
    public $userid;
    public function chongfu(){
        $this->userid = Session::get('id');
        View::assign('userid',$this->userid);
        $ad = \app\index\model\Adress::where('uid','=',$this->userid)->select();
        View::assign('ad',$ad);
    }

    public function index(){
        if(!Session::has('id')){
            //用户未登录，提醒用户登录undo
            return redirect('http://www.test.com/webtest/login');
        }
        $this->chongfu();
        return View::fetch('adress');
    }

    public function addAddress(){
        $this->chongfu();

        $adr = new \app\index\model\Adress();
        $adr->save([
            'uid'           =>      $this->userid,
            'username'      =>      Request::post('name'),
            'phone'         =>      Request::post('phone'),
            'postcode'      =>      Request::post('postcode'),
            'adress'        =>      Request::post('adress'),
        ]);
        return redirect('http://www.test.com/adress');
    }

    public function deleteAdress($id){
        $userid = Session::get('id');
        View::assign('userid',$userid);
        \app\index\model\Adress::destroy($id);
        return redirect('http://www.test.com/adress');
    }
}