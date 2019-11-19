<?php
namespace app\demo\logic;

//单例
class Unit
{
    //创建静态私有的变量保存该类对象
    private static $instance;
    //参数
    private $config;
    //防止直接创建对象
    public function __construct($config)
    {
        $this->config = $config;
        echo "我被实例化了";
    }
    //防止克隆对象
    private function __clone()
    {

    }
    public static function getInstance($config)
    {
        //判断$instance是否是Uni的对象
        //没有则创建
        if (!self::$instance instanceof self) {
            self::$instance = new self($config);
        }
        return self::$instance;

    }
    public function getName()
    {
        echo $this->config;
    }
}
