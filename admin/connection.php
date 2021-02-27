<?php
    $db         = 'mysql:host=localhost;dbname=store';
    $user       = 'root';
    $password   = '';
    $option     =[
        PDO:: MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    ];
    try {
        $con = new PDO($db,$user,$password,$option);
        $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        echo 'failed ' .$e->getMessage() ;
    }
?>