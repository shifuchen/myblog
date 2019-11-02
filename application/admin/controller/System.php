<?php
/**
 * Created by PhpStorm.
 * User: 石福臣
 * Date: 2019/10/16
 * Time: 17:24
 */

namespace app\admin\controller;


class System extends Common
{
    public function website(){
        return $this->fetch("website");
    }
    public function email(){
        return $this->fetch("email");
    }
}