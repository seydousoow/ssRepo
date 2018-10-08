<?php

function connect()
{
    require('config.php');
    $host = $config['DB_HOST'];
    $username = $config['DB_USERNAME'];
    $password = $config['DB_PASSWORD'];
    $db_name = $config['DB_DATABASE'];
    $bd = null;
    try {
        $bd = new PDO('mysql:host=' . $host . ';dbname=' . $db_name . ';charset=utf8', $username, $password);
        $bd->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Error:" . $e->getMessage());
    }
    return $bd;
}
