<?php
namespace app\index\service;
/**
 * interface 接口
 * 与大多数抽象类一样，interface 也有抽象方法，不管不能和抽象类一样在接口中包含具体的方法或变量（做为抽象性的例外）
 * 一般约定接口总以字母 I 或者 i 开头
 * 接口中定义的所有方法都必须是public，这是接口的特性
 */

// 定义一个接口类，以 interface 开头而不是 class
interface Interfaces{

    // 可以定义常量
    const USERNAME = 'hhh';

    // 定义的方法，子类必须实现
    public function getInfo($info);

    public function sendInfo($info);

}
