<?php

namespace app\demo\controller;

use app\demo\logic\Unit;
use think\Controller;

/**
 * 测试单例模式
 */
class Instance extends Controller
{
    public function index()
    {

        $db1 = Unit::getInstance(1);
        $db1->getName(); //我被实例化了1
        echo "<br>";
        $db2 = Unit::getInstance(4);
        $db2->getName(); //1

        $db3 = new Unit(6);
        $db3->getName(); //我被实例化了6
        $db2 = Unit::getInstance(4);
        $db2->getName(); //1

    }
}
