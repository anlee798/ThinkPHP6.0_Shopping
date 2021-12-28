<?php

namespace app\admin\controller;

use app\admin\model\User;
use think\facade\Request;
use think\facade\Session;
use think\facade\View;

class Login
{
    public function index()
    {
        $errormessage = "";
        if (session('error') == 1) {
            $errormessage = "账号或密码错误！";
        }elseif(session('error') == 2){
            $errormessage = "你不是管理员身份！";
        }
        View::assign('errormessage', $errormessage);
        return View::fetch('login');
    }

    //判断登录
    public function judgeLogin()
    {

        $postData = Request::post();
        $user = new User();
        $user->id = $postData['userid'];
        $user->password = $postData['password'];

        $password = $user->whereIn('id', $user->id)->value('password');
        $role = $user->whereIn('id', $user->id)->value('role');
        $code = Request::post('code');
        if(!captcha_check($code)){
            View::assign('mess',"验证码错误");
            return View::fetch('login');
        }
        if (md5($user->password) == $password) {
            //密码检验成功
            if($role==1){
                //进入登录页面
                Session::set('adminid', $user->id);
                return redirect('http://www.test.com/admin/index');
            }else{
                return redirect('/admin/login')->with('error', 2);
            }
        } else {
            //密码错误
            return redirect('/admin/login')->with('error', 1);
        }
    }

    //判断注册
    public function judgeRegister()
    {
        $postData = Request::post();
        $user = User::create([
            'username' => $postData['username'],
            'password' => md5($postData['password']),
            'email' => $postData['email'],
            'phone' => $postData['phone'],
            'question' => $postData['question'],
            'answer' => $postData['answer'],
            'role' => 2,
            'create_time' => date("Y-m-d H:i:s"),
            'update_time' => date("Y-m-d H:i:s"),
        ]);

        //跳转到注册成功界面
        Session::set('id', $user->id);
        return redirect('http://www.test.com/admin/index');
    }

    //跳转到登录界面
    public function login()
    {
        $errormessage = "";
        if (session('error') == 1) {
            $errormessage = "账号或密码错误！";
        }
        View::assign('errormessage', $errormessage);
        return View::fetch('login');
    }

    //跳转到注册界面
    public function register()
    {
        return View::fetch('register');
    }


}