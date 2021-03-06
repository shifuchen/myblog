<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Log;
use think\Request;
use think\Session;

class Index extends Controller
{
    public function index()
    {
        $data = Db::name("content")->paginate(5);
        return $this->fetch("index", ['list' => $data]);
    }

    public function details()
    {
        $contentDetail   = Db::name("content")->where('id', input('id'))->find();
        $field           = ['commentator', 'commentator_id', 'commcontent', 'content_id', 'FROM_UNIXTIME(createtime,"%Y-%m-%d") as createtime'];

        $contentCommlist = Db::name("comment")->where(['content_id'=>input('id'),'type'=>'文章' ])->field($field)->select();
        $contentCommlist['count'] = Db::name("comment")->where('content_id', input('id'))->field($field)->count();
            Log::error($contentCommlist);
        return $this->fetch("details", ['list' => $contentDetail, 'comments' => $contentCommlist]);
    }

    public function addComment(Request $request)
    {
        $data        = $request->post();
        $userSession = Session::get("indexUser");
        $result      = null;
        $count       = 0;
//        if (empty($userSession)) {
//            $result['code'] = 100021;
//            $result['msg']='登录后才能评论,请先登录!';
//        } else {
        $count = Db::name("comment")->insert(['commentator'    => $userSession['username'],
                                              'commentator_id' => $userSession['id'], 'commcontent' => $data['desc'],
                                              'content_id'     => $data['content_id'], 'createtime' => time(), 'updatetime' => time(),'type'=>'文章']);
        if ($count > 0) {
            $result['code'] = 0;
            $result['msg']  = '添加成功';
        } else {
            $result['code'] = 100020;
            $result['msg']  = '添加评论失败!';
        }
//        }
        return json($result);
    }
}
