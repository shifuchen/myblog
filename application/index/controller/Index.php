<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Log;

class Index extends Controller
{
    public function index()
    {
        $data=Db::name("content")->paginate(5);
        return $this->fetch("index",['list'=>$data]);
    }

    public function details(){
        $contentDetail=Db::name("content")->where('id',input('id'))->find();
        Log::error(json($contentDetail));
        return $this->fetch("details",['list'=>$contentDetail]);
    }
}
