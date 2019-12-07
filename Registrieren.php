<?php
require './controllers/RegistrierenController.php';
use Emensa\Controller;
$controller = new Emensa\Controller\RegistrierenController();

echo $controller->run();

?>
