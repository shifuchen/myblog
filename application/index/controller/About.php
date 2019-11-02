<?php
/**
 * Created by PhpStorm.
 * User: 石福臣
 * Date: 2019/10/16
 * Time: 11:37
 */

namespace app\index\controller;


use think\Controller;

class About extends Controller
{
    public function about(){
        return $this->fetch("about");
    }
}