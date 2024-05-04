<?php

session_start();

class Logout {
    public function logoutUser() {
        $_SESSION = array();

        session_destroy();

        if (isset($_COOKIE['remember_me'])) {
            setcookie('remember_me', '', time() - 3600, '/');
        }

        header("location: login.php");
        exit;
    }
}

$logoutHandler = new Logout();

$logoutHandler->logoutUser();
?>
