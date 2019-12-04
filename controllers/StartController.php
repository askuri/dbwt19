<?php
namespace Emensa\Controller;

require_once './inc/PHPprepare.php';

class StartController{

    public function getView(){
        global $blade;
        return $blade->run("start.Start",  []);
    }
}
