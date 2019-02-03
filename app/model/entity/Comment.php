<?php
/**
 * Created by PhpStorm.
 * User: josip
 * Date: 02.02.19.
 * Time: 19:02
 */

class Comment
{
    private $id;
    private $content;
    private $postID;
    public function __get($name)
    {
        return isset($this->$name) ? $this->$name : null;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __call($name, $arguments)
    {
        $function = substr($name, 0,3);
        if($function === 'set'){
            $this->__set(strtolower(substr($name,3)),$arguments[0]);
            return $this;
        }elseif ($function=== 'get'){
            return $this->__get(strtolower(substr($name,3)));
        }
        return $this;
    }


    public function __construct($id, $content, $post)
    {
        $this->setId($id);
        $this->setContent($content);
        $this->setPost($post);



    }
    public static function all($id)
    {
        $list = [];
        $db = Db::connect();
        $statement = $db->prepare('select * from comment where postID='. $id);
        $statement->execute();
        foreach ($statement->fetchAll() as $comment){
            $list[] = new Comment($comment->id, $comment->content, $comment->postID);
        }
        return $list;
    }
}

