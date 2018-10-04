<?php
//check if there is a user connected
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
//     if ($_SESSION['timer'] < (time() - (15 * 60))) {
//         //unset($_SESSION['loggedin']);
//         //session_destroy();
//         //session_start();
//         //show an alert that the user has been disconnected due to the 15 minutes session timer expiration
//         //redirect to login page
//         header("location: http://baeaubab.com/index.php?session=expired");
//     } else {
//         $_SESSION['timer'] = time();
//     }
// } else {
//     //there is no current user connected
//     //redirect to home

//     echo '<script>location.href = "http://baeaubab.com/index.php?loggedin=false";</script>';
// }