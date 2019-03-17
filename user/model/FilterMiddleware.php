<?php

namespace app\user\model;

use think\Model;

class FilterMiddleware extends Model
{
    protected $table = 'user';

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