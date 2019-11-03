<?php
/**
 * Created by PhpStorm.
 * User: 石福臣
 * Date: 2019/10/16
 * Time: 14:35
 */

namespace app\admin\controller;



use think\Controller;
use think\Db;
use think\Log;
use think\Request;

class Login extends Controller
{
    public function  login(){
        return $this->fetch("login");
    }
    public function reg(){
        return $this->fetch("reg");
    }
    public function forget(){
        return $this->fetch("forget");
    }
    public function regit(Request $request){
        $data=$request->post();
        $userdata=getRSAEncode($data['data']);
        $count=Db::name("adminuser")->insert(['loginname'=>$userdata['loginname'],'nickname'=>$userdata['nickname'],'password'=>md5($userdata['password']),
            'agreement'=>$userdata['agreement'],'jointime'=>time(),'updatetime'=>time()]);
        $result=null;
        if($count>0){
            $result['code']=0;
            $result['msg']="注册成功!";
        }else{
            $result['code']=10002;
            $result['msg']="注册失败!";
        }
        return json($result);
    }
    public function loginSys()
    {
        if(request()->isPost()){
            $admin = new Admin();
            $data=input('post.');
            if($admin->login($data)==3){
                $this->success("信息正确,正在为您跳转",'index/index');
            }else if($admin->login($data)==4){
                $this->error('验证码错误');
            }
            else{
                $this->error("用户名或密码错误");
            }
        }
        return $this->fetch();
    }

}