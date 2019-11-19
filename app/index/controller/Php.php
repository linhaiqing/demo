<?php

namespace app\index\controller;
/**
 * PHP函数控制器
 * Class Preg
 */
class Php
{
    /**
     * array_map() 函数将用户自定义函数作用到数组中的每个值上，并返回用户自定义函数作用后的带有新值的数组。
     * @author haiqing.lin
     * @date   2019/11/19 0019
     */
    public function arrayMap()
    {
        $a  = array(1, 2, 3, 4, 5);
        $rs = array_map(function ($item) {
            return $item * $item;
        }, $a);
        echo '<pre>';
        print_r($rs);
        die();
    }

    /**
     * array_walk() 函数对数组中的每个元素应用用户自定义函数。在函数中，数组的键名和键值是参数。
     * @author haiqing.lin
     * @date   2019/11/19 0019
     */
    public function arrayWalk()
    {
        $a  = array(1, 2, 3, 4, 5);
        $rs = array_walk($a, function ($item) {
            echo  $item * $item;//直接输出
        });
        //echo true;
        print_r($rs);
        die();
    }


}
