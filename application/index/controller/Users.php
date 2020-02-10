<?php
namespace app\index\controller;

use think\Request;
use think\Controller;
use app\index\model\User;

class Users extends Controller
{
    //http://thinkphp50.test/index.php/index/user/index
    public function index(User $user, Request $request)
    {
        if ($request->instance()->isAjax()) {
            $total = $user
                ->count();
            $list = $user
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

    public function store(User $user, Request $request)
    {
        if ($request->instance()->isAjax()) {
            $params = $request->instance()->param();
            $user->save($params);
            $result = array(
                "code" => 200,
                "msg" => '操作成功'
            );

            return json($result);
        }

        return view('create');
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
