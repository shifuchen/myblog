<?php
/**
 * Created by PhpStorm.
 * User: 石福臣
 * Date: 2019/10/16
 * Time: 11:34
 */

namespace app\index\controller;


use think\Controller;

class Album extends Controller
{
    public function album(){
        return $this->fetch("album");
    }
}