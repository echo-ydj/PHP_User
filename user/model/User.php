<?php
namespace app\user\model;

use think\Model;

class User extends Model
{
    protected $table='user';

    protected $autoWriteTimestamp = true;
    // 定义时间戳字段名
//    protected $dateFormat = 'Y-m-d H:i:s';
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
    //设置json字段
    protected $json = ['in_charge_of'];


    public function getMessages(){


        return 0;
    }
}