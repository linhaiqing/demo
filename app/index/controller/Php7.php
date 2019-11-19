<?php
// 严格模式,代码中通过指定 strict_types的值（1或者0），1表示严格类型校验模式，作用于函数调用和返回语句；0表示弱类型校验模式。
declare (strict_types=1);

namespace app\index\controller;

use app\index\service\Interfaces;

/**
 * php7新特性
 * Class Php7
 * @package app\index\controller
 */
class Php7 implements Interfaces
{
    // 使用接口常量，需要用 作用域解析操作符
    private $username = Interfaces::USERNAME;

    public function getInfo($info)
    {
        return 'getInfo=>' . $info;
    }

    public function sendInfo($info)
    {
        return 'sendInfo=>' . $info;
    }

    public function getUserName()
    {
        return $this->username;
    }

    /**
     * 严格模式只能出现浮点型
     * @author haiqing.lin
     * @date   2019/11/19 0019
     */
    public function t1()
    {
        echo $this->sum(2, '3', 4.1);//Argument 2 passed to app\index\controller\Php7::sum() must be of the type float
    }

    /**
     * 数字相加
     * @param float ...$ints 由浮点型组合为一个数组
     * @return float 返回必须是浮点型
     * @author haiqing.lin
     * @date   2019/11/19 0019
     */
    public function sum(float ...$ints): float
    {
        return array_sum($ints);
    }

    /**
     * 太空船运算符（组合比较符）
     * 用于比较两个表达式 $a 和 $b，如果 $a 小于、等于或大于 $b时，它分别返回-1、0或1。
     * @author haiqing.lin
     * @date   2019/11/19 0019
     */
    public function t2()
    {
        // 整型比较
        print(1 <=> 1);//0
        print(1 <=> 2);//-1
        print(2 <=> 1);//1
    }

    /**
     * 常量数组
     * 使用 define 函数来定义数组
     * @author haiqing.lin
     * @date   2019/11/19 0019
     */
    public function t3()
    {
        define('SITES', [
            'Google',
            'Runoob',
            'Taobao',
        ]);
        echo '<pre>';
        print_r(SITES);
        die();

    }

    /**
     * 匿名类
     * @author haiqing.lin
     * @date   2019/11/19 0019
     */
    public function t4()
    {
        $app = new Application;
        // 使用 new class 创建匿名类
        $app->setLogger(new class implements Logger {
            public function log(string $msg) {
                print($msg);
            }
        });

        $app->getLogger()->log("我的第一条日志");
    }


}

interface Logger {
    public function log(string $msg);
}

class Application {
    private $logger;

    public function getLogger(): Logger {
        return $this->logger;
    }

    public function setLogger(Logger $logger) {
        $this->logger = $logger;
    }
}

