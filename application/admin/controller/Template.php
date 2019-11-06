<?php
/**
 * Created by PhpStorm.
 * User: 石福臣
 * Date: 2019/10/16
 * Time: 15:37
 */

namespace app\admin\controller;


class Template extends Common
{
    public function personalpage()
    {
        return $this->fetch("personalpage");
    }

    public function addresslist()
    {
        return $this->fetch("addresslist");
    }
}