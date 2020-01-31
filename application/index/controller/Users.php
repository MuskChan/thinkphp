<?php
namespace app\index\controller;

use think\Request;

class Users
{
    public function __construct()
    {
        $this->model = new \app\index\model\User;
    }

    //http://thinkphp50.test/index.php/index/user/index
    public function index(Request $request)
    {
        if ($request->instance()->isAjax()) {
            $total = $this->model
                ->count();
            $list = $this->model
                ->select();

            $result = array(
                "code" => 0,
                "msg" => '',
                "count" => $total,
                "data" => $list
            );

            return json($result);
        }

        return view('index');
    }

    public function store()
    {
        return 2;
    }
}
