<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Log;

class Index extends Controller
{
    public function index()
    {
        $data=Db::name("content")->paginate(1);
        return $this->fetch("index",['list'=>$data]);
    }

    public function details(){
        return $this->fetch("details");
    }
}
