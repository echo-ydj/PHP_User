<?php
namespace app\user\model;
use think\Model;

class AuthMiddleware extends Model
{  var $id;
    protected $table='user';
    // 定义时间戳字段名
    protected $createTime = 'create_at';
    protected $updateTime = 'update_at';
    //设置json字段
    protected $json = ['in_charge_of'];

//    构造函数
//    public function __construct($id)
//    {
//        parent::__construct($id);
//        $this->id=$id;
//
//    }



    public function getMessages($id){
//        find 差一个  select 查多个
//        $user = self::where('id', $id)->find();
        return 0;
    }
    public function checkAuthifMatched(){

    }
    public function getUsername($id){
        $user = self::where('id', $id)->find();

        return $user['name'];

    }
    public function getPowerRank($id){

        $user = self::where('id', $id)->find();
        return $user['rank'];
    }

    //
    public function getResponsibilityColumn($id){

        $user = self::where('id', $id)->find();
        return $user['in_charge_of'];
    }

}