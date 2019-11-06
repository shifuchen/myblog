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
    public function listForm($id=null){
        $tiaozhuan="";

        if($id!=null){
            $contentData=Db::name("content")->where('id',$id)->find();
            $contentData=json_encode($contentData,true);
            $tiaozhuan=$this->fetch('listform',['contentData'=>$contentData]);
        }else{
            $tiaozhuan=$this->fetch('listform',['contentData'=>"''"]);
        }
        return $tiaozhuan;
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
           $result['code']=10050;
           $result['msg']="未录入成功错误信息!";
       }
        return json($result);
    }
    public function editContent(Request $request){
        $data=$request->post();
        $data['updatetime']=time();
        unset($data['file']);
        $count=Db::name("content")->where("id",$data['id'])->update($data);
        $result=null;
        if($count>0){
            $result['code']=0;
            $result['msg']="文章已修改!";
        }else{
            $result['code']=10050;
            $result['msg']="未录入成功错误信息!";
        }
        return json($result);
    }
    public function contentDel(Request $request){
        $data=$request->post();
        $result=null;
        $count=Db::name("content")->where('id',$data['id'])->delete();
        if($count>0){
            $result['code']=0;
            $result['msg']="数据已删除";
        }else{
            $result['code']=100003;
            $result['msg']="数据删除失败!";
        }
        return json($result);

    }

    public function tagsList(){
        $page=input("get.page")?input("get.page"):1;
        $page=intval($page);
        $limit=input("get.limit")?input("get.limit"):1;
        $limit=intval($limit);
        $start=$limit*($page-1);
        $cate_list=Db::name("tags")->limit($start,$limit)->select();
        $count=Db::name("tags")->limit($start,$limit)->count();
        $list["msg"]="";
        $list["code"]=0;
        $list["count"]=$count;
        $list["data"]=$cate_list;
        if(empty($cate_list)){
            $list["msg"]="暂无数据";
        }
        return json($list);
    }
    public function tagsAdd(Request $request){
        $tags=$request->get();
        $count=Db::name("tags")->insert(['tags'=>$tags['tags']]);
        $result=null;
        if($count>0){
            $result['code']=0;
            $result['msg']="分类添加成功!";
        }else{
            $result['code']=10050;
            $result['msg']="分类添加失败!";
        }
        return json($result);
    }
    public function selectTags(){
        $result=null;

        $result['data']=Db::name("tags")->select();
        if(empty($result['data'])){
            $result['data']="暂无数据!";
            $result['code']=10020;
        }else{
            $result['code']=0;
        }
        return json($result);
    }
    public function commentList(){
        $page=input("get.page")?input("get.page"):1;
        $page=intval($page);
        $limit=input("get.limit")?input("get.limit"):1;
        $limit=intval($limit);
        $start=$limit*($page-1);
        $where=null;
        if(input("get.id")!=0){
            $where['id']=input('get.id');
        }
        if(input('get.commentator')!=null){
            $where['commentator']=input('get.commentator');
        }
        if(input("get.commContent")!=""){
            $where['commContent']=input('get.commContent');
        }
        $field=[
            'id',
            'commentator',
            'commcontent',
            'FROM_UNIXTIME(createtime,"%Y-%m-%d") as createtime',
            'FROM_UNIXTIME(updatetime,"%Y-%m-%d") as updatetime',
        ];
        $cate_list=Db::name("comment")->limit($start,$limit)->where($where)->field($field)->select();
        $count=Db::name("comment")->limit($start,$limit)->where($where)->count();
        $list["msg"]="";
        $list["code"]=0;
        $list["count"]=$count;
        $list["data"]=$cate_list;
        if(empty($cate_list)){
            $list["msg"]="暂无数据";
        }
        return json($list);

    }

}