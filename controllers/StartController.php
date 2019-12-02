<?php
namespace Emensa\Controller;

require './inc/PHPprepare.php';

class StartController{

    public function getView(){
        global $blade;
        return $blade->run("start.Start",  []);
    }
}
?>
