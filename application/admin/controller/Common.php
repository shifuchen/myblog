<?php
/**
 * Created by PhpStorm.
 * User: 石福臣
 * Date: 2019/10/15
 * Time: 17:05
 */

namespace app\admin\controller;


use think\Controller;
use think\Session;

class Common extends Controller
{
    /**
     * 判断后台登录
     */
    public function _initialize()
    {
        if (!session('userinfo')) {
            $this->error("您的登录证书已过期,请重新登录!", url("/admin/login/login"));
        }
    }

    public function getsession()
    {
        return session("userinfo");
    }

    public function logout()
    {
        return Session::delete("userinfo");
    }


}