<?php


/**
 * @method setId($id)
 * @method setContent($content)
 * @method setImage($image)
 * @method setTime($time)
 */
class Post
{
    private $id;
    private $content;
    private $image;
    private $time;

    public function __construct($id, $content, $time, $image = null)
    {
        $this->setId($id);
        $this->setContent($content);
        $this->setImage($image);
        $this->setTime($time);


    }

    public static function all()
    {
        $list = [];
        $db = Db::connect();
        $statement = $db->prepare('select * from post');
        $statement->execute();
        foreach ($statement->fetchAll() as $post) {
            $list[] = new Post($post->id, $post->content, $post->time, $post->image);
        }
        arsort($list);
        return $list;
    }

    public static function find($id)
    {
        $id = intval($id);
        $db = Db::connect();
        $statement = $db->prepare('select * from post where id = :id');
        $statement->bindValue('id', $id);
        $statement->execute();
        $post = $statement->fetch();
        return new Post($post->id, $post->content, $post->time, $post->image);
    }

    public static function countComments($id)
    {
        $id = intval($id);
        $db = Db::connect();
        $statement = $db->prepare('select count(*) from comment where postID= :id');
        $statement->bindValue('id', $id);
        $statement->execute();

        return get_object_vars($statement->fetch())['count(*)'][0];
    }

    public function __call($name, $arguments)
    {
        $function = substr($name, 0, 3);
        if ($function === 'set') {
            $this->__set(strtolower(substr($name, 3)), $arguments[0]);
            return $this;
        } elseif ($function === 'get') {
            return $this->__get(strtolower(substr($name, 3)));
        }
        return $this;
    }

    public function __get($name)
    {
        return isset($this->$name) ? $this->$name : null;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }


}