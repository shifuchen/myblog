<?php
/**
 * Created by PhpStorm.
 * User: ${"石福臣"}
 * Date: 2019/10/15
 * Time: 15:45
 */

namespace app\admin\controller;


use think\Controller;

class Index extends Common
{
    public function index()
    {
        return $this->fetch();
    }

    public function home()
    {
        return $this->fetch("console");
    }
}