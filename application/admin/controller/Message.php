<?php
/**
 * Created by PhpStorm.
 * User: 石福臣
 * Date: 2019/10/16
 * Time: 16:32
 */

namespace app\admin\controller;


class Message extends Common
{
    public  function message(){
        return $this->fetch("message");
    }
    public function detail(){
        return $this->fetch("detail");
    }
}