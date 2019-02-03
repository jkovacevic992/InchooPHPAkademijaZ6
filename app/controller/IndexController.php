<?php

class IndexController
{
    public function index()
    {
        $view = new View();
        $posts = Post::all();
        $view->render('index', [
            'posts' => $posts
        ]);
    }

    public function newPost()
    {
        $data = $this->validate($_POST);

        if($data === false) {
            header('Location: ' . App::config('url'));
        }else{
            $connection = Db::connect();
            $time = date("Y.m.d H:i:s");
            $imageName = addslashes($_FILES["file"]["name"]);
            $imageTmp = $_FILES["file"]["tmp_name"];
            move_uploaded_file($imageTmp,BP."images/". $imageName);
            $sql = 'insert into post (content, time, image) values (:content, :time, :image)';
            $stmt = $connection->prepare($sql);
            $stmt->bindValue('image', $imageName);
            $stmt->bindValue('content', $data['content']);
            $stmt->bindValue('time', $time);
            $stmt->execute();
            header('Location: ' . App::config('url'));

        }
    }
    public function newComment($id)
    {
        $data = $this->validate($_POST);
        $connection = Db::connect();
        $sql = 'insert into comment (postID,content) values ('.$id.',:content)';

        $stmt = $connection->prepare($sql);
        $stmt->bindValue('content', $data['content']);
        $stmt->execute();
        header('Location: ' . App::config('url').'Index/view/'.$id);
    }
    public function deletePost($id)
    {

        $connection = Db::connect();

        $sql = 'delete from post where id = '. $id;

        $stmt = $connection->prepare($sql);

        $stmt->execute();
        header('Location: ' . App::config('url'));
    }

    private function validate($data)
    {
        $required = ['content'];
        foreach ($required as $key){
            if(!isset($data[$key])){
                return false;
            }
            $data[$key] = trim((string)$data[$key]);
            if(empty($data[$key])){
                return false;
            }
        }

        return $data;
    }

    public function view($id)
    {
        $view = new View();
        $comments = Comment::all($id);
        $view->render('view', [
            'post' => Post::find($id),
            'comments' => $comments
        ]);
    }
}