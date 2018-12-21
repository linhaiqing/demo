<?php

namespace app\common\command;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;
use think\Db;

/**
 * 处理一些任务
 */
class Deal extends Command
{
    protected function configure()
    {
        $this->setName("demo:deal")
            ->addArgument("action", Argument::OPTIONAL, "方法")
            ->setDescription("deal something");
    }

    /**
     * 执行应用
     * @param Input $input
     * @param Output $output
     * @return void
     */
    protected function execute(Input $input, Output $output)
    {
        $args   = $input->getArguments();
        $action = $args['action'] ?? 'test';
        switch ($action) {
            case 'con':
                $this->testCon();
                break;

            case 'redis':
                $this->testRedis();
                break;

            case 'class':
                $this->testClass();
                break;

            default:
                $this->test();
                break;
        }
    }

    /**
     * 测试
     * @author haiqing
     * @date    2018-11-29
     * @version 1.0.0
     * @return  [type]     [description]
     */
    public function test()
    {
        echo 1;
        
    }

    /**
     * 测试redis
     * 问题描述：超时将无法获得数据
     * @example php think deal redis
     * @throws  Redis::get(): send of 25 bytes failed with errno=10054
     * @author haiqing
     * @date    2018-11-29
     * @version 1.0.0
     * @return  [type]     [description]
     */
    public function testRedis()
    {
        $redis = getRedisInstance(false, 1);
        while (true) {
            echo $redis->ping();
            sleep(6);
            
        }
        echo 1;

    }

    /**
     * 测试长连接
     * 问题描述：数据库长时间未连接，再次连接的时候已经连接不上了
     * @example php think deal con
     * @author haiqing
     * @date    2018-11-29
     * @version 1.0.0
     * @return  [type]     [description]
     */
    public function testCon()
    {
        $database_config = config()['database'];
        $database_config = array_merge($database_config, ['break_reconnect' => false]);
        $this->db        = Db::connect($database_config);
        while (true) {
            $rs = $this->db->name('user')->find();
            echo date('s') . '-';
            sleep(5);
        }
    }

    /**
     * 测试实例
     * 问题描述：如果开启断线重连，则会重新连接（建议），如果开启强制性连接，则会产生很多连接（不建议）
     * 断线重连：break_reconnect=true,强制性连接:force=true
     * @example php think deal class
     * @throws think\db\Connection::free(): send of 9 bytes failed with errno=10053 你的主机中的软件中止了一个已建立的连接
     * @author haiqing
     * @date    2018-11-29
     * @version 1.0.0
     * @return  [type]     [description]
     */
    public function testClass()
    {
        while (true) {
            db('cfd_product')->find();
            sleep(6);
        }
    }

}

