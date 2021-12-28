<?php


namespace app\index\facade;


use think\Facade;

class Test extends Facade
{
    protected static function getFacadeClass()
    {
        return 'app\index\common\Test';
    }
}