<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Benutzer;

class LoginController extends Controller
{
    public function show() {
        return view('login.Login');
    }
    
    public function login(Request $request) {
        $user = $_POST['user'] ?? false;
        $pass = $_POST['pass'] ?? false;
        $benutzer = new Benutzer();

        $role = $benutzer->getRole($user);
        if (!$user || !$pass) {
            die('username or password empty');
        } else if (!$role) {
            $request->session()->put('loginstatus', 'fail');
        } else {
            $db_nutzer = $role->fetch_assoc();
            if (password_verify($pass, $db_nutzer['Hash'])) {
                // correct
                $request->session()->put('loginstatus', 'authenticated');
                $request->session()->put('user', $user);
                $request->session()->put('role', $db_nutzer['Rolle']);
                $request->session()->put('userid', $db_nutzer['BenutzerID']);

                // update last login
                $benutzer->updateLastLogin($user);
            } else {
                $request->session()->put('loginstatus', 'fail');
            }
        }
        
        return redirect('/login');
    }
    
    public function logout(Request $request) {
        $request->session()->flush();
        return redirect('/login');
    }
}