<?php
require 'inc/PHPprepare.php';

$role = $_SESSION['role'] ?? 'Gast'; // default price
$id = $_GET['id'];

require './controllers/DetailController.php';
use Emensa\Controller;
$controller = new Emensa\Controller\DetailController();

echo $controller->getView($id, $role);
