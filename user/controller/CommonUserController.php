<?php


namespace app\user\controller;
use think\Controller;
//记得引入模型
use app\user\model\User;
use think\console\Table;
use think\facade\Session;
use think\Request;
class CommonUserController extends Controller
{
    public function useHomePage(){

        return "useHomePage()";
    }
    public function settingPage(){

        return "settingPage()";
    }
    public function messageBoxPage(){

        return "messageBoxPage()";
    }






}