<?php

namespace app\admin\controller;

use app\admin\facade\Test;
use app\admin\model\Category;
use app\admin\model\Goods;
use app\admin\model\Order;
use app\admin\model\User;
use think\Exception;
use think\facade\Db;
use think\facade\Env;
use think\facade\Filesystem;
use think\facade\Request;
use think\facade\Session;
use think\facade\View;

class Index
{
    public function index(){

        if( Test::getAdminID()==null){
            return redirect('http://www.test.com/admin/LoginRegister');
        }
        $user = User::where('role','=',2)->paginate(7);
        View::assign('user',$user);
        View::assign('number',1);
        return View::fetch('index');
    }

    public function managerorder(){
        Test::getAdminID();
        Test::getOrder();
        View::assign('number',5);
        return View::fetch('index');
    }

    public function deleteOrder($oid){
        Order::where('id','=',$oid)->delete();
        Test::getAdminID();
        Test::getOrder();
        View::assign('number',5);
        return View::fetch('index');
    }

    public function managergoods(){
        Test::getAdminID();
        Test::getGoods();
        View::assign('number',3);
        return View::fetch('index');
    }
    //商品下架
    public function xiajia($gid){
        Goods::where('id','=',$gid)->update([
            'statue'    =>      0,
        ]);
        Test::getAdminID();
        Test::getOrder();
        View::assign('number',3);
        return View::fetch('index');
    }

    //修改密码
    public function set(){
        Test::getAdminID();
        View::assign('number',6);
        return View::fetch('index');
    }

    public function alterPw(){
        $userid = Test::getAdminID();
        $pw = Request::post('pw');
        $newpw = Request::post('newpw');
        $mm = \app\index\model\User::where('id','=',$userid)->value('password');

        if(md5($pw) == $mm){
            User::where('id','=',$userid)->update(['password'   =>  md5($newpw)]);
            View::assign('errormessage2',"密码修改成功");
        }else{
            $errormessage = "输入的密码不正确！";
            View::assign('errormessage',$errormessage);
        }
        View::assign('userid',$userid);
        View::assign('number',6);
        return View::fetch('index');
    }

    public function formBackPassword(){
        $userid = Test::getAdminID();
        $question = User::where('id','=',$userid)->column('question');
        View::assign('question',$question[0]);
        View::assign('num',2);
        View::assign('number',6);
        return View::fetch('index');
    }

    public function backPassword(){
        $answer = Request::post('answer');
        $newpw = Request::post('newpw');
        $userid = Test::getAdminID();
        $rightanswer = User::where('id','=',$userid)->column('answer');
        if($answer==$rightanswer[0]){
            User::where('id','=',$userid)->update(['password'=>md5($newpw)]);
            View::assign('errormessage4',"密码修改成功！");
        }else{
            View::assign('errormessage3',"回答错误！修改密码失败！");
        }
        $question = User::where('id','=',$userid)->column('question');
        View::assign('question',$question[0]);
        View::assign('num',2);
        View::assign('number',6);
        return View::fetch('index');
    }

    public function Tuichu(){
        Session::delete('adminid');
        return redirect('http://www.test.com/admin/LoginRegister');
    }

    //商品分类
    public function formcategory(){
        Test::getAdminID();
        $first = Category::where('parent_id','=',0)->column('name');
        View::assign('first',$first);
        View::assign('number',2);
        return View::fetch('index');
    }
    public function formcategory1(){
        Test::getAdminID();
        $cg = Request::post('cg');
        $first = Category::where('parent_id','=',0)->column('name');
        if(in_array($cg,$first)){
            //数据重复
            View::assign('chongfu','数据重复');
        }else{
            $addCategory = new Category();
            $addCategory->save([
                'parent_id'     =>       0,
                'name'          =>       $cg,
                'create_time'   =>       date("Y-m-d H:i:s"),
            ]);
            View::assign('chenggong','数据数据添加成功！');
        }
        View::assign('first',$first);
        View::assign('number',2);
        return View::fetch('index');
    }
    public function formcategory2(){
        Test::getAdminID();
        $first = Category::where('parent_id','=',0)->column('name');
        $pcname = Request::post('pcname');
        $cname = Request::post('cname');
        $second = Category::where('parent_id','=',0)->where('name','=',$pcname)->column('id');
        $child = Category::where('parent_id','=',$second[0])->column('name');
        if(in_array($cname,$child)){
            //数据重复
            View::assign('chongfu2','数据重复');
        }else{
            $addCategory = new Category();
            $addCategory->save([
                'parent_id'     =>       $second[0],
                'name'          =>       $cname,
                'create_time'   =>       date("Y-m-d H:i:s"),
            ]);
            View::assign('chenggong2','数据数据添加成功！');
        }
        View::assign('first',$first);
        View::assign('number',2);
        return View::fetch('index');
    }

    //添加商品
    public function formgoods(){
        Test::getAdminID();
        $list = Category::where('parent_id','<>',0)->column('name');
        View::assign('list',$list);
        View::assign('number',4);
        return View::fetch('index');
    }

    public function upload(){
        Test::getAdminID();
        $list = Category::where('parent_id','<>',0)->column('name');
        View::assign('list',$list);
        try{
            //商品标签
            $pcname = Request::post('pcname');
            //商品名称
            $name = Request::post('name');
            //商品价格
            $price = Request::post('price');
            //商品描述
            $description = Request::post('description');
            //商品库存
            $stock = Request::post('stock');

            $cid = Category::where('name','=',$pcname)->column('id');

            //图片上传及路径
            $file = Request::file('image');
            $savename = Filesystem::disk('public')->putFile('shopImg',$file,'md5');
            $imgsrc = "/static/img/".$savename;

            $goods = new Goods();
            $goods->save([
                'gname'         =>      $name,
                'price'         =>      $price,
                'imgsrc'        =>      $imgsrc,
                'description'   =>      $description,
                'stock'         =>      $stock,
                'cid'           =>      $cid[0],
                'sales'         =>      0,
                'evaluate'      =>      0,
                'statue'        =>      1,
            ]);
            View::assign('message',"上传成功！");
        }catch (Exception $exception){
            View::assign('message2',"上传失败，数据填写不规范！");
        }
        View::assign('number',4);
        return View::fetch('index');
    }

    //配置信息
    public function myConfig(){
        $arr = array([
            'type'=>Env::get('database.type'),
            'hostname'=>Env::get('database.hostname'),
            'database'=>Env::get('database.database'),
            'username'=>Env::get('database.username'),
            'password'=>Env::get('database.password'),
            'charset'=>Env::get('database.charset'),
        ]);
        View::assign('arr',$arr[0]);
        View::assign('number',7);
        Test::getAdminID();
        return View::fetch('index');
    }

    //商品补货
    public function buHuo(){
        Test::getAdminID();
        $buhuoID = Goods::column('id');
        View::assign('buhuoID',$buhuoID);
        View::assign('number',8);
        View::assign('flag',1);
        return View::fetch('index');
    }

    public function buHuo2(){
        Test::getAdminID();
        $buhuoID = Request::post('buhuoID');
        $goods = Goods::where('id','=',$buhuoID)->select();
        $cid = Category::where('parent_id','<>',0)->column('id');
        View::assign('cid',$cid);
        View::assign('gd',$goods);
        View::assign('flag',2);
        View::assign('number',8);
        return View::fetch('index');
    }
    public function buHuo3(){
        Test::getAdminID();
        $gid = Request::post('gid');
        $gname = Request::post('gname');
        $price = Request::post('price');
        $text = Request::post('text');
        $sel = Request::post('sel');
        $stock = Request::post('stock');

        Goods::where('id','=',$gid)->update([
            'gname'             =>              $gname,
            'price'             =>              $price,
            'description'       =>              $text,
            'cid'               =>              $sel,
            'stock'             =>              $stock,
        ]);
        $buhuoID = Goods::column('id');
        View::assign('buhuoID',$buhuoID);
        View::assign('flag',1);
        View::assign('back',"操作成功！");
        View::assign('number',8);
        return View::fetch('index');
    }
    public function buHuo4($gid){
        Test::getAdminID();
        $goods = Goods::where('id','=',$gid)->select();
        $cid = Category::where('parent_id','<>',0)->column('id');
        View::assign('cid',$cid);
        View::assign('gd',$goods);
        View::assign('flag',2);
        View::assign('number',8);
        return View::fetch('index');
    }

    //站内消息
    public function message(){
        $goods=Db::name('goods')->alias('g')->join('tp_category c','g.cid=c.id')
            ->field('g.id,g.gname,c.name,g.price,g.imgsrc,g.stock,g.sales,g.evaluate')
            ->where('g.stock','=',0)->paginate(6);

        View::assign('goods',$goods);

        Test::getAdminID();
        View::assign('number',9);
        return View::fetch('index');
    }
}