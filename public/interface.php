<?php
interface demo {
    const NAME = "名称";
    function fun1();
    function fun2();
}
interface demo2 {
    function fun3();
    function fun4();
}
interface demo3 {
    const TEST = "Test";
    function fun5();
}
class MyPc implements demo, demo2 {
    function fun1() {
        echo "++++++++++<br />";
    }
    function fun2() {
        echo "----------<br />";
    }
    function fun3() {
        echo "1111111111<br />";
    }
    function fun4() {
        echo "2222222222<br />";
    }
}
class MyPs extends MyPc implements demo3 {
    function fun4() {
        echo "4444<br />";
    }
    function fun5() {
        echo "继承类后引用接口";
    }
}
$p = new MyPs;
$p->fun1();//++++++++++
$p->fun2();//----------
$p->fun3();//1111111111
$p->fun4();//2222222222
$p->fun5();//继承类后引用接口
?>
