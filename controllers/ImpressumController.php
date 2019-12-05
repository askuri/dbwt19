<?php


namespace Emensa\Controller;

require 'inc/PHPprepare.php';

class ImpressumController
{

    public function getView(){
        global $blade;
        return $blade->run("impressum.Impressum",  [
        ]);
    }
}