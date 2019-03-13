<?php
namespace app\user\controller;
//记得引入模型
use app\user\model\User;
use app\user\model\AuthMiddleware;
//use app\user\model\User;
//use app\user\model\AuthMiddleware;
use think\console\Table;
use think\Controller;
use think\facade\Session;
use think\Request;
class Usercontrol extends Controller
{
    //用于判断登录状态
    var $status=false;

    public function index(){

        echo (time()|date("y-m-d h:i:s"));
        return $this->fetch('user/index');
    }
    //判断登录状态
    public function isLogin(){
        //未登录
        if($this->status){
          return  $this->Login();
        }
        else{
            return $this->noLogin();
        }

    }
    public function logout(){
        //账户退出
        $this->status=false;
        session('name',null);
        session('password', null);
        session('id',null);
    }
    //判断登录成
    public function Login(Request $request){
        //获取表单数据
        $list=$request->post();
//        echo request()->param('name');
//        echo input('param.name');
        dump($list!=null);
        //判断提交表单是否有值
        if ($list['name']!=null&&$list['password']!=null) {
            $user = User::where('name', $list['name'])
                ->where('password', $list['password'])->find();

            if ($user) {
//            登录成功
                //存入session
                session('name', $list['name']);
                session('password', $list['password']);
                session('id',$user['id']);
                $this->status = true;
                return "sescues";
            } else {
                //登录失败
                return "error";
            }
        }else{
            return "请输入用户名和密码";
        }
    }
    public function noLogin(){

        return 'function_no_login';
    }

    public function selectUser()
    {
//       dump( User::where("name='1' and password='1'") ->find());

        $user = User::where('id', 11)
            ->where('password','123')->find();

        $this->assign('user', $user);

        return $this->fetch('user/index');

//            view中html中写入
//        <!--数据库int 型接收时间戳   获取后再用data规定显示效果-->
//            <!--  {$user['created_at']|date='Y-m-d H:i:s' }-->


//        $user = User::get(2);
//       echo $user->in_charge_of->email;
//        echo $user->in_charge_of->nickname;

    }
    //增加用户
    public function insertUser(Request $request)
    {
        $list=$request->post();
        dump($list);
        //判断表单是否传值
        if ($list['name']!=null&&$list['username']!=null){
            $user = new User();
            $user->save([
                'name'  =>  $list['name'],
                'username'=> $list['username'],
                'rank'=>$list['rank'],

            //-------------待改部分---------------

            'in_charge_of'=>['email'    => 'thinkphp@qq.com', 'nickname'=> '流年'],

                'password'=>$list['rank'],
//                'created_at'=>time(),
            ]);
            echo $user->create_at;
//            echo dump($user->created_at);

        }




    }
    
    public function updateUser()
    {
//        dump(session('id'));
        //判断是否退出登录
        if (session('id')){
            User::where('id', session('id'))
            ->update(['name' => 'Thinkphp']);
        }
        else{
            return 'error';
        }
    }
    public function deleteUser()
    {

        $user = User::get(session('id'));
        $user->delete();
    }
    public function get1()
    {
        echo 4;

//        $n = new AuthMiddleware();
//        echo $n->getMessages();
//        echo $n->getUsername(2);

        echo AuthMiddleware::getMessages();

    }

}