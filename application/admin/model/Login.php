<?php


namespace app\admin\model;


use think\Model;
use think\Validate;
use think\Db;

class Login extends Model
{
    public function login($data){
        $validate = new Validate([
            'captcha|验证码'=>'require|captcha'
        ]);
        if (!$validate->check($data)) {
            dump($validate->getError());
        }
        $user = Db::name('adminuser')->where('loginname','=',$data['username'])->find();
        if($user){
            if($user['check']!=1){
                return 5;
            }else if($user['password'] == md5($data['password'])){
                session('username', $user['loginname']);
                session('uid', $user['id']);
                session('userinfo',$user['loginname'].$user['nickname'].$user['role'].time());
                return 3;
            }else{
                return 2;//密码错误
            }
        }else{
            return 1; //用户不存在
        }
    }
}