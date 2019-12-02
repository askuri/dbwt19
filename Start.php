<?php
require './controllers/StartController.php';
use Emensa\Controller;
$controller = new Emensa\Controller\StartController();

echo $controller->getView();

?>
