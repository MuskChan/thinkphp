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

    public function store(Request $request)
    {
        $params = $request->instance()->param();
        $this->model->save($params);
        $result = array(
            "code" => 200,
            "msg" => '操作成功'
        );

        return json($result);
    }

    public function destroy(Request $request)
    {
        $params = $request->instance()->param();
        $this->model
            ->where('id', $params['id'])
            ->delete();
        $result = array(
            "code" => 200,
            "msg" => '操作成功'
        );

        return json($result);
    }

    public function update(Request $request)
    {
        $params = $request->instance()->param();
        $this->model
            ->update($params);
        $result = array(
            "code" => 200,
            "msg" => '操作成功'
        );

        return json($result);
    }
}
