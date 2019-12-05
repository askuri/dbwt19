<?php


namespace Emensa\Controller;

require_once './inc/PHPprepare.php';

class AuthenticationController
{

    public function authenticateUser($user, $logout, $pass){
        $remoteConnection = connectToDB();
        // get data
        $query = "SELECT b.Hash, r.Rolle FROM Benutzer b
	JOIN Nutzerrolle r ON b.Nummer = r.Nummer	
	WHERE b.Nutzername = '".$user."'";
        $result = mysqli_query($remoteConnection, $query);

        if ($logout) {
            session_destroy();
        } else if (!$user || !$pass) {
            die('username or password empty');
        } else if (!$result) {
            $_SESSION['loginstatus'] = 'fail';
        } else {
            $db_nutzer = $result->fetch_assoc();
            if (password_verify($pass, $db_nutzer['Hash'])) {
                // correct
                $_SESSION['loginstatus'] = 'authenticated';
                $_SESSION['user'] = $user;
                $_SESSION['role'] = $db_nutzer['Rolle'];

                // update last login
                $query = "UPDATE Benutzer SET LetzterLogin = NOW() WHERE Nutzername = '".$user."'";
                $result = mysqli_query($remoteConnection, $query);
            } else {
                $_SESSION['loginstatus'] = 'fail';
            }
        }
    }

}