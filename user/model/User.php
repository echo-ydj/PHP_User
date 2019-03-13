<?php
namespace app\user\model;

use think\Model;

class User extends Model
{
    protected $table='user';
    // 定义时间戳字段名
    protected $createTime = 'create_at';
    protected $updateTime = 'update_at';
    //设置json字段
    protected $json = ['in_charge_of'];

    public function getMessages(){


        return 0;
    }
}