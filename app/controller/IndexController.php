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
            $imagetmp= addslashes (file_get_contents($_FILES['myimage']['tmp_name']));
            $connection = Db::connect();
            $time = date("Y.m.d H:i:s");
            $sql = 'insert into post (content, image, time) values (:content, :image, :time)';
            $stmt = $connection->prepare($sql);
            $stmt->bindValue('content', $data['content']);
            $stmt->bindValue('image', $imagetmp);
            $stmt->bindValue('time', $time);
            $stmt->execute();
            header('Location: ' . App::config('url'));

        }
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
        $view->render('view', [
            'post' => Post::find($id)
        ]);
    }
}