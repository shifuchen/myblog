<?php
/**
 * Created by PhpStorm.
 * User: 石福臣
 * Date: 2019/10/16
 * Time: 16:32
 */

namespace app\admin\controller;


use think\Db;
use think\Log;
use think\Request;

class Message extends Common
{
    public function message(Request $request)
    {
        return $this->fetch("message");
    }

    public function detail()
    {
        return $this->fetch("detail");
    }

    public function messageList()
    {
        $page  = input("get.page") ? input("get.page") : 1;
        $page  = intval($page);
        $limit = input("get.limit") ? input("get.limit") : 1;
        $limit = intval($limit);
        $start = $limit * ($page - 1);
        $where = null;
        $field = [
            'id',
            'messageTitle',
            'messageType',
            'content',
            'ip',
            'FROM_UNIXTIME(createtime,"%Y-%m-%d") as createtime',
            'createUser',
        ];
        if (input("messageType") != "") {
            $where['messageType'] = input("messageType");
            $where['ifread']      = 0;
        }
        $cate_list            = Db::name("message")->limit($start, $limit)->where($where)->field($field)->select();
        $countall             = Db::name("message")->limit($start, $limit)->where($where)->count();
        $count                = null;
        $count['countNotice'] = Db::name("message")->where(['messageType' => '通知', 'ifread' => 0])->count();
        $count['countDirect'] = Db::name("message")->where(['messageType' => '私信', 'ifread' => 0])->count();
        $count['countCheck']  = Db::name("message")->where(['messageType' => '审核', 'ifread' => 0])->count();
        $count['countAll']    = Db::name("message")->where('ifread', 0)->count();
        $list["msg"]          = "";
        $list["code"]         = 0;
        $list["count"]        = $countall;
        $list['typecount']    = $count;
        $list["data"]         = $cate_list;
        if (empty($cate_list)) {
            $list["msg"] = "暂无数据";
        }
        return json($list);
    }
}