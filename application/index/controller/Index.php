<?php
namespace app\index\controller;

class Index
{
    public function index()
    {
        return 'index';
    }

    //路径 http://thinkphp50.test/index.php/index/index/hello
    //http://localhost/index.php/index/Index/hello
    public function hello()
    {
        return 'hello';
    }
}
