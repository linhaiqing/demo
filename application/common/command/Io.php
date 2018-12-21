<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/11/13
 * Time: 20:49
 */

namespace app\common\command;

use Workerman\Worker;
use Workerman\WebServer;
use Workerman\Autoloader;
use PHPSocketIO\SocketIO;

use app\gateway\ThinkWorker;
use think\Config;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;

defined("SPOTSOCKET_LOG_PATH") or define("SPOTSOCKET_LOG_PATH",   "/");
class Io extends Command
{
    protected function configure()
    {
        $this->setName("demo:io")
            ->addArgument("cmd", Argument::OPTIONAL, "启动命令", "")
            ->addOption("daemon", "d", Option::VALUE_NONE, "启动守护模式")
            ->addOption("gracefully", "g", Option::VALUE_NONE, "")
            ->addOption("debug", "", Option::VALUE_OPTIONAL, "调试模式", false)
            ->setDescription("phpsocket.io");
    }

    protected function execute(Input $input, Output $output)
    {
        $options = $input->getOptions();

        // 重组参数给 Workman
        $argv   = [];
        $argv[] = "subscribe";
        $argv[] = $input->getArgument("cmd");

        if ($options['daemon'] != false) {
            $argv[] = "-d";
        }

        if ($options['gracefully'] != false) {
            $argv[] = "-g";
        }

        $this->debug = $options['debug'] ?: false;

        $io = new SocketIO(2020);
        $io->on('connection', function($socket){
            $socket->addedUser = false;
            // when the client emits 'new message', this listens and executes
            $socket->on('new message', function ($data)use($socket){
                // we tell the client to execute 'new message'
                $socket->broadcast->emit('new message', array(
                    'username'=> $socket->username,
                    'message'=> $data
                ));
            });

            // when the client emits 'add user', this listens and executes
            $socket->on('add user', function ($username) use($socket){
                global $usernames, $numUsers;
                // we store the username in the socket session for this client
                $socket->username = $username;
                // add the client's username to the global list
                $usernames[$username] = $username;
                ++$numUsers;
                $socket->addedUser = true;
                $socket->emit('login', array( 
                    'numUsers' => $numUsers
                ));
                // echo globally (all clients) that a person has connected
                $socket->broadcast->emit('user joined', array(
                    'username' => $socket->username,
                    'numUsers' => $numUsers
                ));
            });

            // when the client emits 'typing', we broadcast it to others
            $socket->on('typing', function () use($socket) {
                $socket->broadcast->emit('typing', array(
                    'username' => $socket->username
                ));
            });

            // when the client emits 'stop typing', we broadcast it to others
            $socket->on('stop typing', function () use($socket) {
                $socket->broadcast->emit('stop typing', array(
                    'username' => $socket->username
                ));
            });

            // when the user disconnects.. perform this
            $socket->on('disconnect', function () use($socket) {
                global $usernames, $numUsers;
                // remove the username from global usernames list
                if($socket->addedUser) {
                    unset($usernames[$socket->username]);
                    --$numUsers;

                   // echo globally that this client has left
                   $socket->broadcast->emit('user left', array(
                       'username' => $socket->username,
                       'numUsers' => $numUsers
                    ));
                }
           });
           
        });
        // 传入参数
        ThinkWorker::setArguments($argv);
        // 设置WorkerMan进程的pid文件路径
        ThinkWorker::$pidFile = SPOTSOCKET_LOG_PATH  . 'spot.pid';
        // 如果以守护进程方式(-d启动)运行，则所有向终端的输出(echo var_dump等) 都会被重定向到stdoutFile指定的文件中。
        ThinkWorker::$stdoutFile = SPOTSOCKET_LOG_PATH  . 'spot_stdout.log';
        // 此文件记录了workerman自身相关的日志，包括启动、停止等
        ThinkWorker::$logFile = SPOTSOCKET_LOG_PATH  . 'spot_run.log';
        // 启动所有进程
        ThinkWorker::runAll();
        
    }

   
    /**
     * 调试模式下输出日志
     * @author haiqing
     * @date    2018-12-04
     * @version 1.0.0
     * @param   [type]     $content [description]
     * @return  [type]              [description]
     */
    public function log($content)
    {
        if ($this->debug) {
            echo '-' . $content . '-' . PHP_EOL;
        }
        return;
    }
}
