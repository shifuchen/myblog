<?php


namespace app\admin\controller;


use think\Db;
use think\Log;
use think\Request;
use think\Session;

class Content extends Common
{
    public function contentList(){
        return $this->fetch("list");
    }
    public function listForm(){
        return $this->fetch("listform");
    }
    public function contentTags(){
        return $this->fetch("tags");
    }
    public function tagsForm(){
        return $this->fetch("tagsform");
    }
    public function contentComment(){
        return $this->fetch("comment");
    }
    public function contForm(){
        return $this->fetch("contform");
    }
    public function contentLists(){
        $page=input("get.page")?input("get.page"):1;
        $page=intval($page);
        $limit=input("get.limit")?input("get.limit"):1;
        $limit=intval($limit);
        $start=$limit*($page-1);
        $where=null;
        if(input("get.id")!=0){
            $where['id']=input('get.id');
        }
        if(input('get.author')!=null){
            $where['author']=input('get.author');
        }
        if(input("get.title")!=""){
            $where['title']=input('get.title');
        }
        if(input("get.label")!=0){
            $where['label']=input("label");
        }
        $field=[
            'id',
            'label',
            'title',
            'author',
            'content',
            'status',
            'FROM_UNIXTIME(createtime,"%Y-%m-%d") as createtime',
            'FROM_UNIXTIME(updatetime,"%Y-%m-%d") as updatetime',
        ];
        $cate_list=Db::name("content")->limit($start,$limit)->where($where)->field($field)->select();
        $count=Db::name("content")->limit($start,$limit)->where($where)->count();
        $list["msg"]="";
        $list["code"]=0;
        $list["count"]=$count;
        $list["data"]=$cate_list;
        if(empty($cate_list)){
            $list["msg"]="暂无数据";
        }
        return json($list);
    }

    public function addContent(Request $request){
        $data=$request->post();
       $count= Db::name("content")->insert(['label'=>$data['label'],'title'=>$data['title'],'author'=>$data['author'],
            'author_id'=>Session::get("uid"),'content'=>$data['content'],'label_id'=>$data['label_id'],'createtime'=>time(),'updatetime'=>time()
        ,'status'=>'待发布']);
       $result=null;
       if($count>0){
           $result['code']=0;
           $result['msg']="文章已录入!";
       }else{
           $result['code']=0;
           $result['msg']="未录入成功错误信息!";
       }
        return $result;
    }

}