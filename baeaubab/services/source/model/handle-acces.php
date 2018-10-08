<?php
if (session_status() == PHP_SESSION_NONE)
    session_start();
//check if there is a user connected
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    if ($_SESSION['timer'] < (time() - (600))) { // 10 minutes == 600 seconds
        unset($_SESSION['loggedin']);
        //session_destroy();
        //session_start();
        //show an alert that the user has been disconnected due to the 15 minutes session timer expiration
        //redirect to login page
        $actual_link = urlencode((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
        header("location: /baeaubab/index.php?session=expired&token=$actual_link&status=" . $_SESSION['status']);
    } else {
        $_SESSION['timer'] = time();
    }
} else {
    //there is no current user connected
    //redirect to home
    header("location: /baeaubab/index.php?loggedin=false");
}