<?php
/**
 * Created by PhpStorm.
 * User: 石福臣
 * Date: 2019/10/16
 * Time: 11:30
 */

namespace app\index\controller;


use think\Controller;
use think\Db;
use think\Log;
use think\Request;
use think\Session;

class Whisper extends Controller
{
    public function whisper(){
        $field           = ['id','createuser', 'createuserid', 'content', 'weiimg', 'FROM_UNIXTIME(createtime,"%Y-%m-%d %T") as createtime','heatnum','writenum'];
        $dataList=Db::name('whisper')->field($field)->paginate(6);
        $commList=Db::name("comment")->where('type','微语')->select();
        return $this->fetch("whisper",['dataList'=>$dataList]);
    }

    public function whisperComm(Request $request){
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
                'content_id'     => $data['whisper_id'], 'createtime' => time(), 'updatetime' => time(),'type'=>'微语']);
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