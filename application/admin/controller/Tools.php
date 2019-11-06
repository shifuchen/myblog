<?php


namespace app\admin\controller;


use think\Controller;
use think\Request;

class Tools extends Controller
{
    public function uploadimage(Request $request)
    {
        $img  = $request->file("file");
        $info = $img->move(ROOT_PATH . 'public/user_avatar');
        if ($info) {
            return json(['code' => 0, 'msg' => '上传成功！', 'url' => '/user_avatar/' . $info->getSaveName()]);
        } else {
            return json(['code' => 100021, 'msg' => '图片上传失败' . $img->getError(), 'url' => '']);
        }
    }

    public function uploadBlog(Request $request)
    {
        $img    = $request->file('file');
        $info   = $img->move(ROOT_PATH . 'public/blog_img');
        $result = null;
        if ($info) {
            $result['code']          = 0;
            $result['msg']           = '图片上传成功!';
            $result['data']['src']   = '/blog_img/' . $info->getSaveName();
            $result['data']['title'] = '博客图片';
        } else {
            $result['code']          = 100021;
            $result['msg']           = '图片上传失败!';
            $result['data']['src']   = '';
            $result['data']['title'] = $img->getError();
        }
        return json($result);
    }
}