<?php

namespace app\index\controller;

use app\index\model\User;
use think\facade\Request;
use think\facade\Session;
use think\facade\View;
class WebTest
{
    public function index(){
        $errormessage = "";
        if(session('error')==1){
            $errormessage = "账号或密码错误！";
        }
        View::assign('errormessage',$errormessage);
        return View::fetch('login');
    }

    //判断登录
    public function judgeLogin(){
        //echo Request::param('userid');

        $postData = Request::post();
        $user = new User();
        $user->id = $postData['userid'];
        $user->password = $postData['password'];
        $code = $postData['code'];
        if(!captcha_check($code)){
            View::assign('mess',"验证码错误");
            return View::fetch('login');
        }
        $password = $user->whereIn('id',$user->id)->value('password');
        if(md5($user->password) == $password){
            //密码检验成功
            //进入登录页面
            User::where('id','=',$user->id)->update([
               'update_time'    =>      date("Y-m-d H:i:s"),
            ]);
            Session::set('id',$user->id);
            return redirect('/index');
        }else{
            //密码错误
            return redirect('/webtest/index')->with('error',1);
        }
    }
    //判断注册
    public function judgeRegister(){

        $postData = Request::post();
        $user = User::create([
            'username'       =>      $postData['username'],
            'password'       =>      md5($postData['password']),
            'email'          =>      $postData['email'],
            'phone'          =>      $postData['phone'],
            'question'       =>      $postData['question'],
            'answer'         =>      $postData['answer'],
            'role'           =>      2,
            'create_time'    =>      date("Y-m-d H:i:s"),
            'update_time'    =>      date("Y-m-d H:i:s"),
        ]);
        //跳转到注册成功界面
        var_dump($user->id);
        Session::set('id',$user->id);
        //return redirect('/index');
    }

    //跳转到登录界面
    public function login(){
        $errormessage = "";
        if(session('error')==1){
            $errormessage = "账号或密码错误！";
        }
        View::assign('errormessage',$errormessage);
        return View::fetch('login');
    }

    //跳转到注册界面
    public function register(){
        return View::fetch('register');
    }


}