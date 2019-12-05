<?php
require './inc/PHPprepare.php';


$in_user = $_POST['user'] ?? false;
$in_pass = $_POST['pass'] ?? false;
$in_logout = $_GET['logout'] ?? false;

require_once './controllers/AuthenticationController.php';
$controller = new Emensa\Controller\AuthenticationController();
$controller->authenticateUser($in_user, $in_logout, $in_pass);

// redirect
header('Location: '.$_SERVER['HTTP_REFERER']);