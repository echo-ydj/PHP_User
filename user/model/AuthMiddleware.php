<?php
namespace app\user\model;
use think\Model;

class AuthMiddleware extends Model
{  var $id;

    protected $table='user';

    // 定义时间戳字段名
//   支持类型改为timestamp
    protected $autoWriteTimestamp = 'timestamp';
//    修改为在数据库中的字段名
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
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
    public static function getPowerRank($id){

        $user = self::where('id', $id)->find();
        return $user['rank'];
    }

    //
    public function getResponsibilityColumn($id){

        $user = self::where('id', $id)->find();
        return $user['in_charge_of'];
    }

}