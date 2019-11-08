<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Log;

class Index extends Controller
{
    public function index()
    {
        $data=Db::name("content")->paginate(10);
        $page = $data->render();
        Log::error($page);
        return $this->fetch("index",['list'=>$data,'page'=>$page]);
    }

    public function details(){
        return $this->fetch("details");
    }
}
