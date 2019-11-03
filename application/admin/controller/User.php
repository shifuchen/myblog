<?php
/**
 * Created by PhpStorm.
 * User: 石福臣
 * Date: 2019/10/15
 * Time: 16:59
 */

namespace app\admin\controller;


use think\Controller;
use think\Db;
use think\Log;
use think\Request;
use think\Session;

class User extends Common
{
//    界面跳转
    public function  adminlist(){
        return $this->fetch("adminuser");
    }
    public function list(){
        return $this->fetch("list");
    }
    public function role(){
        return $this->fetch("role");
    }
    public function  userform($id=null){
        $tiaozhuan="";
        if(input('get.id')!=null){
           $userdata= Db::name("user")->where('id',$id)->find();
           if($userdata['sex']=1){
               $userdata['sex']='男';
           }else {
               $userdata['sex']='女';
           }
           $userdata=json_encode($userdata,true);
            $tiaozhuan=$this->fetch("userform",['userdata'=>$userdata]);
        }else{
            $tiaozhuan=$this->fetch("userform",['userdata'=>"''"]);
        }
        return $tiaozhuan;
    }
    public function adminform($id=null){
        $tiaozhuan="";
        if(input('get.id')!=null){
            $adminData=Db::name('adminuser')->where('id',$id)->find();
            if($adminData['check']==1){
                $adminData['check']='on';
            }else{
                $adminData['check']='';
            }
            $adminData=json_encode($adminData,true);
            $tiaozhuan=$this->fetch('adminform',['adminData'=>$adminData]);
        }else{
            $tiaozhuan=$this->fetch('adminform',['adminData'=>"''"]);
        }
        return $tiaozhuan;
    }
    public function roleform(){
        return $this->fetch("roleform");
    }
    public function userinfo(){
        $adminId=Session::get("uid");
        $adminData=Db::name("adminuser")->where('id',$adminId)->find();
        unset($adminData['password']);
        return $this->fetch("userinfo",['adminData'=>json_encode($adminData,true)]);
    }
    public function password(){
        return $this->fetch("password");
    }
    public function userdetail(){
        return $this->fetch("userdetail");
    }
//    数据获取

    /**
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *
     * @memo  网站用户操作
     */

    public function  userList(){
        $user=new \app\admin\model\User();
        $page=input("get.page")?input("get.page"):1;
            $page=intval($page);
            $limit=input("get.limit")?input("get.limit"):1;
            $limit=intval($limit);
            $start=$limit*($page-1);
            $where=null;
            if(input("get.id")!=0){
                $where['id']=input('get.id');
            }
            if(input('get.username')!=null){
                $where['username']=input('get.username');
            }
            if(input("get.email")!=""){
                $where['email']=input('get.email');
            }
            if(input("get.sex")!=0){
                $where['sex']=input("sex");
            }
            $field=[
                'id',
                'username',
                'avatar',
                'phone',
                'email',
                "(case sex when '1' then '男' when '2' then '女' else '不限' end) as sex",
                'ip',
                'FROM_UNIXTIME(createtime,"%Y-%m-%d") as createtime',
                'FROM_UNIXTIME(updatetime,"%Y-%m-%d") as updatetime',
            ];
            $cate_list=Db::name("user")->limit($start,$limit)->where($where)->field($field)->select();
            $count=Db::name("user")->limit($start,$limit)->where($where)->count();
            $list["msg"]="";
            $list["code"]=0;
            $list["count"]=$count;
            $list["data"]=$cate_list;
            if(empty($cate_list)){
                $list["msg"]="暂无数据";
        }
        return json($list);
    }
    public function userAdd(Request $request){
        $user=new \app\admin\model\User();
        $data=$request->post();
        if($data['sex']=='男'){
            $data['sex']=1;
        }elseif ($data['sex']=='女'){
            $data['sex']=2;
        }else{
            $data['sex']=0;
        }
        $count=$user->insert(['username'=>$data['username'],'avatar'=>$data['avatar'],'phone'=>$data['phone']
        ,'email'=>$data['email'],'sex'=>$data['sex'],'ip'=>$data['ip'],'createtime'=>time(),'updatetime'=>time()]);
        $result=array();
       if($count>0){
           $result['code']=0;
           $result['msg']='新增成功！';
       }else{
           $result['code']=10001;
           $result['msg']='新增失败！';
       }
        return json($result);
    }
    public function useredit(Request $request){
        $data=$request->post();
        if($data['sex']=='男'){
            $data['sex']=1;
        }elseif ($data['sex']=='女'){
            $data['sex']=2;
        }else{
            $data['sex']=0;
        }
        $id=$data['id'];
        unset($data['file']);
        $data['updatetime']=time();
       $count= Db::name('user')->where('id',$id)->update($data);
        if($count>0){
            $result['code']=0;
            $result['msg']='修改成功！';
        }else{
            $result['code']=10001;
            $result['msg']='修改失败！';
        }
        return json($result);
    }

    public function userDel(){
        $user=new \app\admin\model\User();
        $id=input("get.id");
        $count=$user->where(['id'=>$id])->delete();
        $result=null;
        if($count>0){
            $result['code']=0;
            $result['msg']='删除成功！';
        }else{
            $result['msg']='删除失败！';
        }
        return $result;
    }
    public function userbatchdel(Request $request){
        $data=$request->port();
        return $data;
    }

    /**
     * @memo:后台管理用户
     */
    public function adminLists(){
        $page=input("get.page")?input("get.page"):1;
        $page=intval($page);
        $limit=input("get.limit")?input("get.limit"):1;
        $limit=intval($limit);
        $start=$limit*($page-1);
        $where=null;
        if(input("get.id")!=0){
            $where['id']=input('get.id');
        }
        if(input("get.loginname")!=""){
            $where['loginname']=input("get.loginname");
        }
        if(input("get.email")!=""){
            $where['email']=input("get.email");
        }
        if(input("get.telphone")!=""){
            $where['telphone']=input("get.telphone");
        }
        if(input("get.role")!=""){
            $where['role']=input("get.role");
        }
        $field=[
            'id',
            'loginname',
            'telphone',
            'email',
            'role',
            "jointime",
            'check',
            'FROM_UNIXTIME(jointime,"%Y-%m-%d") as jointime',
            'FROM_UNIXTIME(updatetime,"%Y-%m-%d") as updatetime',
        ];
        $cate_list=Db::name("adminuser")->limit($start,$limit)->where($where)->field($field)->select();
        $count=Db::name("adminuser")->limit($start,$limit)->where($where)->count();
        $list["msg"]="";
        $list["code"]=0;
        $list["count"]=$count;
        $list["data"]=$cate_list;
        if(empty($cate_list)){
            $list["msg"]="暂无数据";
        }
        return json($list);
    }
    public function adminAdd(Request $request){
        $data=$request->post();
        isset($data['switch'])?$data['switch']=1: $data['switch']=0;
        $count=Db::name("adminuser")->insert(['loginname'=>$data['loginname'],'telphone'=>$data['telphone'],'email'=>$data['email']
            ,'role'=>$data['role'],'jointime'=>time(),'updatetime'=>time(),'check'=>$data['switch']]);
        $result=array();
        if($count>0){
            $result['code']=0;
            $result['msg']='新增成功！';
        }else{
            $result['code']=10001;
            $result['msg']='新增失败！';
        }
        return json($result);
    }
    public function adminEdit(Request $request){
        $data=$request->post();
        $id=$data['id'];
        $data['updatetime']=time();
        isset($data['switch'])?$data['check']=1: $data['check']=0;
        if(isset($data['memo'])){
            unset($data['check']);
            unset($data['file']);
        }
        unset($data['switch']);
        $count= Db::name('adminuser')->where('id',$id)->update($data);
        if($count>0){
            $result['code']=0;
            $result['msg']='修改成功！';
        }else{
            $result['code']=10001;
            $result['msg']='修改失败！';
        }
        return json($result);
    }

}