<?php


namespace app\admin\controller;


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

}