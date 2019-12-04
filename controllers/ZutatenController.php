<?php
namespace Emensa\Controller{
    require_once './models/Zutat.php';


    class ZutatenController
    {
        public function getView(){
            global $blade;

            $result = \Emensa\Model\Zutat::getAll();
            return $blade->run("zutaten.Zutaten",  [
                'num_rows' => sizeof($result),
                'zliste' => $result
            ]);
        }
    }
}


