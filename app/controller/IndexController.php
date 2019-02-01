<?php
/**
 * Created by PhpStorm.
 * User: josip
 * Date: 30.01.19.
 * Time: 10:13
 */

class IndexController
{
    public function index()
    {
        $view = new View();
        $posts = [
            'First Post',
            'Second Post'
        ];
        $view->render('index', [
            "posts" => $posts
        ]);
    }
}