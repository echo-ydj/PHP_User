<?php

namespace app\user\model;

use think\Model;

class FilterMiddleware extends Model
{
    protected $table = 'user';
    // 定义时间戳字段名
    protected $createTime = 'create_at';
    protected $updateTime = 'update_at';
    //设置json字段
    protected $json = ['in_charge_of'];

    public function getMessages()
    {


        return 0;
    }

    public function filterIllegalCharacters()
    {

    }
    public function filterForPureNumber()
    {

    }
    public function filterForPhone(){

    }

    public function filerForEmailAddress(){


    }


}