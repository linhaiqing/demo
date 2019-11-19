<?php

namespace app\demo\controller;

use think\Controller;
use app\demo\logic\Staticss;

/**
 * 测试静态模式
 */
class Statics extends Controller
{
    public function index()
    {
  //   	$user1 = new Staticss();     
		// $user2 = new Staticss();     
		// $user3 = new Staticss();     
		echo "now here have " . Staticss::getCount() . " user";     //now here have 3 user
		echo "<br />";     
		unset($user3);     
		echo "now here have " . Staticss::getCount() . " user"; //now here have 2 user

    }
}
