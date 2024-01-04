<?php 
    require 'config.php';

    $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

    try {
        $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $pdo->setAttribute(PDO::ATTR_ERRMODE ,  PDO::ERRMODE_WARNING);
        return $pdo;
    } catch (PDOException $e){
        echo $e->getMessage();
    }

?>