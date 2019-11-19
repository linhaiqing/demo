<?php
namespace app\index\controller;
/**
 * 正则表达式控制器
 * Class Preg
 */
class Preg
{
    /**
     * ^ 为匹配输入字符串的开始位置。
     * [ 标记一个中括号表达式的开始
     * { 标记限定符表达式的开始
     * $ 匹配输入字符串的结尾位置
     * @author haiqing.lin
     * @date   2019/11/19 0019
     */
    public function test1()
    {
        //模式分隔符后的"i"标记这是一个大小写不敏感的搜索
        $pattern = "/^[a-z0-9_-]{3,15}$/";
        $subject = "runoob1";
        preg_match($pattern, $subject, $matches);
        echo '<pre>';
        print_r($matches);//runoob1
        die();

    }

    /**
     * + 号代表前面的字符必须至少出现一次（1次或多次）
     * @author haiqing.lin
     * @date   2019/11/19 0019
     */
    public function test2()
    {
        $pattern = "/abc+e/";//只能出现c,c必须最少出现一次
        $subject = "abcccccccce";
        preg_match($pattern, $subject, $matches);
        echo '<pre>';
        print_r($matches);//abcccccccce
        die();
    }

    /**
     * * 号代表字符可以不出现，也可以出现一次或者多次（0次、或1次、或多次）。
     * @author haiqing.lin
     * @date   2019/11/19 0019
     */
    public function test3()
    {
        $pattern = "/abc*e/";//可以不出现c,只能出现c
        $subject = "abe";
        preg_match($pattern, $subject, $matches);
        echo '<pre>';
        print_r($matches);//abe
        die();
    }

    /**
     * ? 问号代表前面的字符最多只可以出现一次（0次、或1次）。
     * @author haiqing.lin
     * @date   2019/11/19 0019
     */
    public function test4()
    {
        $pattern = "/abc?e/";//可以不出现c,只能出现一次c
        $subject = "abe";
        preg_match($pattern, $subject, $matches);
        echo '<pre>';
        print_r($matches);//abe
        die();
    }

    /**
     * {n} n 是一个非负整数。匹配确定的 n 次
     * @author haiqing.lin
     * @date   2019/11/19 0019
     */
    public function test5()
    {
        $pattern = "/o{2}/";//o最少出现2次,最多出现两次
        $subject = "foood";
        preg_match($pattern, $subject, $matches);
        echo '<pre>';
        print_r($matches);//oo
        die();
    }

    /**
     * {n,} n 是一个非负整数。至少匹配n 次
     * @author haiqing.lin
     * @date   2019/11/19 0019
     */
    public function test6()
    {
        $pattern = "/o{2,}/";//o最少出现2次，可以出现无限个o
        $subject = "foood";
        preg_match($pattern, $subject, $matches);
        echo '<pre>';
        print_r($matches);//ooo
        die();
    }

    /**
     * {n,m} m 和 n 均为非负整数，其中n <= m。最少匹配 n 次且最多匹配 m 次。
     * @author haiqing.lin
     * @date   2019/11/19 0019
     */
    public function test7()
    {
        $pattern = "/o{2,4}/";//o最少出现2次,最多出现4次
        $subject = "fooooood";
        preg_match($pattern, $subject, $matches);
        echo '<pre>';
        print_r($matches);//oooo
        die();
    }

    /**
     * . 匹配除 "\n" 之外的任何单个字符
     * @author haiqing.lin
     * @date   2019/11/19 0019
     */
    public function test8()
    {
        $pattern = "/.+/";
        $subject = "foooo\nood";
        preg_match($pattern, $subject, $matches);
        echo '<pre>';
        print_r($matches);//foooo
        die();
    }

    /**
     * (pattern) 匹配 pattern 并获取这一匹配
     * @author haiqing.lin
     * @date   2019/11/19 0019
     */
    public function test9()
    {
        $pattern = "/(o)/";//匹配o，只返回o
        $subject = "afoooda";
        preg_match($pattern, $subject, $matches);
        echo '<pre>';
        print_r($matches);//foooo
        die();
    }
}
