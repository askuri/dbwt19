<?php
require './controllers/ZutatenController.php';

use Emensa\Controller;
$controller = new Emensa\Controller\ZutatenController();

echo $controller->getView();

