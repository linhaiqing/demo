<?php
namespace app\demo\logic;
//静态方法
class Staticss
{
    private static $count = 0; //记录所有用户的登录情况.
    public function __construct()
    {
        self::$count = self::$count + 1;
    }
    public static function getCount()
    {
        return self::$count;
    }
    public function __destruct()
    {
        self::$count = self::$count - 1;
    }

}
