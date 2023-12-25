<?php 
    require_once('classes/main.class.php');
    $bmis->logout();
    header("Location: user_login.php");
?>