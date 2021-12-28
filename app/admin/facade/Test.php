<?php

namespace app\admin\facade;


use think\Facade;

class Test extends Facade
{
    protected static function getFacadeClass()
    {
        return 'app\admin\common\Test';
    }
}