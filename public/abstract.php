<?php
//作用：抽象类不实现具体方法，具体方法由子类完成。
//定义抽象类 abstract
abstract class A{
    //abstract 定义抽象类的方法，这里没有花括号。子类必须实现这个抽象方法。
    abstract public function say();
    //抽象类可以有参数
    abstract public function eat($argument);
    //在抽象类中可以定义普通的方法。
    public function run(){
        echo '这是run方法';
    }
}
class B extends A{
    //子类必须实现父类的抽象方法，否则是致命的错误。
    public function say(){
        echo '这是say方法,实现了抽象方法';
    }
    public function eat($argument){
        echo '抽象类可以有参数 ，输出参数：'.$argument;
    }
}
$b =new B;
$b->say();
echo '<br>';
$b->eat('apple');
echo '<br>';
$b->run();
