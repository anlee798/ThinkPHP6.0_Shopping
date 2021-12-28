<?php

namespace app\index\controller;

use app\index\model\User;
use think\facade\Request;
use think\facade\Session;
use think\facade\View;

class LoginRegister
{
    public function index(){
        $errormessage = "";
        $mess2 = "";
        if(session('error')==1){
            $errormessage = "账号或密码错误！";
        }elseif (session('error')==2){
            $mess2 = "信息有误，重新尝试！";
        }
        View::assign('errormessage',$errormessage);
        View::assign('mess2',$mess2);
        return View::fetch("login");
    }

    //判断登录
    public function judgeLogin(){
        $postData = Request::post();
        $user = new User();
        $user->id = $postData['userid'];
        $user->password = $postData['password'];
        $password = $user->whereIn('id',$user->id)->value('password');
        $code = $postData['code'];
        if(!captcha_check($code)){
            View::assign('mess',"验证码错误");
            return View::fetch('login');
        }
        if(md5($user->password) == $password){
            //密码检验成功
            //进入登录页面
            User::where('id','=',$user->id)->update([
                'update_time'    =>      date("Y-m-d H:i:s"),
            ]);
            Session::set('id',$user->id);
            return redirect('/index');
        }
        return redirect('/login_register/index')->with('error',1);
    }

    public function judgeRegister(){
        $postData = Request::post();
        if($postData['username']==null||$postData['password']==null||$postData['email']==null||
            $postData['phone']==null||$postData['question']==null||$postData['answer']==null
        ){
            return redirect('/login_register/index')->with('error',2);
        }
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
        Session::set('id',$user->id);
        return redirect('/index');
    }

    public function ClickBackPW(){
        View::assign("number",1);
        return View::fetch("backpassword");
    }

    public function BackPassword(){
        $userId = Request::post("userId");
        $message = User::where("id",'=',$userId)->select();
        if(count($message)==0){
            View::assign("errormessage1","不存在该用户！");
            View::assign("number",1);
            return View::fetch("backpassword");
        }
        View::assign("userID",$userId);
        View::assign("question",$message[0]['question']);
        View::assign("number",2);
        return View::fetch("backpassword");
    }

    public function AltPassword(){
        $userid = Request::post("userid");
        $message = User::where("id",'=',$userid)->select();
        $answer = Request::post("answer");
        $newpw = Request::post("newpw");
        if($message[0]["answer"]==$answer){
            User::update([
                'password'  =>  md5($newpw),
            ],["id"=>$userid]);

            View::assign("number",2);
            View::assign("errormessage2","修改密码成功");
            return View::fetch("backpassword");
        }else{
            View::assign("number",2);
            View::assign("errormessage1","回答错误，修改密码失败");
            return View::fetch("backpassword");
        }
    }
}