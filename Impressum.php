<?php
require_once './controllers/ImpressumController.php';
use \Emensa\Controller;

$controller = new \Emensa\Controller\ImpressumController();
echo $controller->getView();
