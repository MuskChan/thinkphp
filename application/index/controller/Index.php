<?php
namespace app\index\controller;

class Index
{
    public function index()
    {
        return view('index', ['version' => THINK_VERSION]);
    }

    //路径 http://thinkphp50.test/index.php/index/index/hello
    //http://localhost/index.php/index/Index/hello
    public function hello()
    {
        return view('welcome');
    }
}
