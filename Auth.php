<?php
require './inc/PHPprepare.php';

$remoteConnection = mysqli_connect( getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASS'), getenv('DB_NAME'), (int) getenv('DB_PORT') );
if (mysqli_connect_errno()) {
    printf("Konnte nicht zur entfernten Datenbank verbinden: %s\n", mysqli_connect_error());
    exit();
}

$in_user = $_POST['user'] ?? false;
$in_pass = $_POST['pass'] ?? false;
$in_logout = $_GET['logout'] ?? false;

// get data
$query = "SELECT b.Hash, r.Rolle FROM Benutzer b
	JOIN Nutzerrolle r ON b.Nummer = r.Nummer	
	WHERE b.Nutzername = '".$in_user."'";
$result = mysqli_query($remoteConnection, $query);

if ($in_logout) {
    session_destroy();
} else if (!$in_user || !$in_pass) {
    die('username or password empty');
} else if (!$result) {
    $_SESSION['loginstatus'] = 'fail';
} else {
    $db_nutzer = $result->fetch_assoc();
    if (password_verify($in_pass, $db_nutzer['Hash'])) {
        // correct
        $_SESSION['loginstatus'] = 'authenticated';
        $_SESSION['user'] = $in_user;
        $_SESSION['role'] = $db_nutzer['Rolle'];
        
        // update last login
        $query = "UPDATE Benutzer SET LetzterLogin = NOW() WHERE Nutzername = '".$in_user."'";
        $result = mysqli_query($remoteConnection, $query);
    } else {
        $_SESSION['loginstatus'] = 'fail';
    }
}


// redirect
header('Location: '.$_SERVER['HTTP_REFERER']);