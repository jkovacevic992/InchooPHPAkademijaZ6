<?php
/**
 * Created by PhpStorm.
 * User: josip
 * Date: 30.01.19.
 * Time: 10:09
 */

class View
{
    private $layout;

    public function __construct($layout = 'layout')
    {
        $this->layout = basename($layout);
    }

    public function render($name, $args = [])
    {
        ob_start();
        extract($args);
        include BP . "app/view/$name.phtml";
        $content = ob_get_clean();


        if( $this->layout){
        include BP . "app/view/{$this->layout}.phtml";
        }else{
            echo $content;
        }
        return $this;
    }
}