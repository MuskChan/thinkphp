<?php

namespace app\index\model;

use think\Model;

class User extends Model
{
    // 表名
    protected $name = 'users';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = true;

    // 定义时间戳字段名
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
}