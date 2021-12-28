<?php
namespace app;

// 应用请求对象类
class Request extends \think\Request
{
    //配置字符过滤器
    protected $filter = ['htmlspecialchars'];
}
