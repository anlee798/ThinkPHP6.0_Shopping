<?php

namespace app\index\controller;

use app\index\model\User;
use think\facade\Request;
use think\facade\Session;
use think\facade\View;

class Set
{
    public function index(){
        if(!Session::has('id')){
            //用户未登录，提醒用户登录undo
            return redirect('http://www.test.com/webtest/login');
        }
        $userid = Session::get('id');
        View::assign('userid',$userid);
        return View::fetch('set');
    }

    public function alterPw(){
        $userid = Session::get('id');
        $pw = Request::post('pw');
        $newpw = Request::post('newpw');
        $mm = User::where('id','=',$userid)->value('password');

        if(md5($pw) == $mm){
            User::where('id','=',$userid)->update(['password'   =>  md5($newpw)]);
            View::assign('errormessage2',"密码修改成功");
        }else{
            $errormessage = "输入的密码不正确！";
            View::assign('errormessage',$errormessage);
        }
        View::assign('userid',$userid);
        return View::fetch('set');
    }

    public function formBackPassword(){
        $userid = Session::get('id');
        View::assign('userid',$userid);
        $question = User::where('id','=',$userid)->column('question');
        View::assign('question',$question[0]);
        View::assign('number',2);
        return View::fetch('set');
    }

    public function backPassword(){
        $answer = Request::post('answer');
        $newpw = Request::post('newpw');
        $userid = Session::get('id');
        $rightanswer = User::where('id','=',$userid)->column('answer');
        if($answer==$rightanswer[0]){
            User::where('id','=',$userid)->update(['password'=>md5($newpw)]);
            View::assign('errormessage4',"密码修改成功！");
        }else{
            View::assign('errormessage3',"回答错误！修改密码失败！");
        }
        $question = User::where('id','=',$userid)->column('question');
        View::assign('question',$question[0]);
        View::assign('userid',$userid);
        View::assign('number',2);
        return View::fetch('set');
    }
}