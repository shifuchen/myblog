<?php
/**
 * Created by PhpStorm.
 * User: 石福臣
 * Date: 2019/10/16
 * Time: 11:30
 */

namespace app\index\controller;


use think\Controller;

class Whisper extends Controller
{
    public function whisper(){
        return $this->fetch("whisper");
    }
}