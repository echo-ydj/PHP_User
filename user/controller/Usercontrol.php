<?php
namespace app\user\controller;
//记得引入模型
use app\user\model\User;
use app\user\model\AuthMiddleware;
use think\console\Table;
use think\Controller;
use think\facade\Session;
use think\Request;
use think\facade\Cookie;

class Usercontrol extends Controller
{
    //用于判断登录状态
    var $status=false;
    public $user;

    public function index(){
//        直接输出日期
     echo   time()%86400 == 57600 ? date('Y-m-d') : date('Y-m-d H:i');


        $this->assign('time',time());
        return $this->fetch('user/index');
    }
    //判断是否登录
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
            $user = AuthMiddleware::where('name', $list['name'])
                ->where('password', $list['password'])->find();

            if ($user) {
    //            登录成功
                //存入session
                //
                //   ------------------ session关闭浏览器后失效  不能设置失效时间--------------

                session('name', $list['name']);
                session('password', $list['password']);
                session('id',$user['id']);
                $name=Session::get('name');



//                      登录状态改为true
                $this->status = true;
                $this->assign('name',$name);
//                return $this->fetch('user/index2');
                return redirect('ajax');
                return redirect("/user/usercontrol/get1?id=".session('id'));
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
        $id=$this->request->get('id');
        echo $id;
        $user =AuthMiddleware::where('id', $id)->find();
//            ->where('password','123')->find();
        dump($user);
        echo $user['name'];
        echo $user['created_at'];
//        echo $user->name;
        $this->assign('time',$user['created_at']);
        $this->assign('user', $user);
        return $this->fetch('user/select_user');
//        return $this->fetch('user/index');



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
//            $user = new User();
            $user =new AuthMiddleware();
            $user['in_charge_of']=array(['email'    => 'thinkphp@qq.com', 'nickname'=> '流年']);
           $flag= $user->save([
                'name'  =>  $list['name'],
                'username'=> $list['username'],
                'rank'=>$list['rank'],

            //-------------待改部分---------------

//            'in_charge_of'=>['email'    => 'thinkphp@qq.com', 'nickname'=> '流年'],

                'password'=>$list['rank'],
//                'created_at'=>time(),
            ]);
//            echo $user->create_at;
            if($flag){
//                注册成功
                return   "sucess";

            }else{
//                注册失败
                return 0;
            }
        }




    }
    
    public function updateUser(Request $request)
    {   $id=session('id');
//        dump(session('id'));
        $list=$request->post();
        $id=$this->request->get('id');
        //判断是否退出登录
        if (session('id')){
//            此方法更新后数据库  不会  自动生成时间戳
//            User::where('id', 10)
//            ->update(['name' => 'php']);

//            此方法更新后数据库   会  自动生成时间戳
            $user = new AuthMiddleware();
//        // 显式指定更新数据操作
        $user->isUpdate(true)
////            save 首值为条件
            ->save(['id' => $id, 'username' =>$list['username'],
                  'password'=>$list['password']]);
//                ->save(['id'=>$id,'username'=>'as']);
            return $this->redirect('index');
        }
        else{
            return 'error';
        }




    }
    public function deleteUser()
    {

        $user = AuthMiddleware::get($this->request->get('id'));
        if (true) {

            $user->delete();
          return $this->success('删除成功','/user/usercontrol/index');

        }else{

            return $this->error('删除失败');
        }


//        dump(input('param.id'));
//        dump(input('id'));
    }
    public function get1()
    {

//        get1?a=1&b=2
//        --1--
//        $l =new Request();
//        dump( $l->get('id'));
////        --2--
//        dump($this->request->get('id'));
//       -- 3--
//        $get=input('get.');
//        dump(input('get.'));
//        dump(input('get.a'));
//        dump(input('get.b'));
        echo "---------------------<br>";
        $n = new AuthMiddleware(12);
        echo $n->getUsername($this->request->get('id')) . "<br>";
        echo $n->getPowerRank($this->request->get('id'));

        $list=$n->getResponsibilityColumn($this->request->get('id'));
        dump($list);
        session('na',12);
        echo session_id();
        dump( $list[0]->email);
//        echo session_save_path;

        Cookie::set('name',14,30);
//        if(Cookie::has('name')){
//           echo Cookie::get('name');
//            //删除cookie
////            echo Cookie::delete('name');
//
//
//        }

    }
    public function fenye(){
        //
        $list = AuthMiddleware::where('id','>=',1)->paginate(4);
//        dump($list);
// 把分页数据赋值给模板变量list
        $this->assign('list', $list);
// 渲染模板输出
        return $this->fetch('user/index2');

    }
    public function ajax(){
        $user= AuthMiddleware::where('id','>=',1)->select();
        $this->assign('user',$user);
        return $this->fetch('user/ajaxtest');

    }
    public function search1(){
        $name=$this->request->get('username');
//        dump($name);
//        if ($name==null){
//            return $this->ajax();
//        }
       $user= AuthMiddleware::where('username','like',$name.'%')->
                whereOr('username','like','%'.$name)->
                whereOr('username','like','%'.$name.'%')->select();
//      dump($user);
        echo "<br>";
      foreach ($user as $value)
      {
//          dump($value);
          echo '<a href="selectuser?id='.$value['id'].'">'.($value['name']).'--'.

              ($value['username']).'</a><br>';

      }
//        $this->assign('user',$user);
//        return $this->fetch('user/ajaxtest');


    }
    function test(){
//        update同时updated_at时间改变
//        ---------1-------------
//        $user =User::get(5);
//        $user->name="xigai";
//        $user->save();
//        ----------2------------
//        $user->isUpdate(true)->save(['id'=>5,'name'=>'xiugai']);



        // 初始化session

        ini_set('session.gc_maxlifetime',10);
        Session::set('name','is name');

//        Session::expire(10);


        echo Session::get('name');

    }
    function test1(){


        echo Session::get('name');
    }
}