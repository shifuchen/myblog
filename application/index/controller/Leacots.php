<?php
/**
 * Created by PhpStorm.
 * User: 石福臣
 * Date: 2019/10/16
 * Time: 11:31
 */

namespace app\index\controller;


use think\Controller;

class Leacots extends Controller
{
    public function leacots(){
        return $this->fetch("leacots");
    }
}