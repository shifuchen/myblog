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
}