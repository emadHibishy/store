<?php
    ob_start();
    session_start();
    if(isset($_SESSION['email'])){
        include_once("connection.php");
        include("includes/languages/english.php");
    $pageTitle = lang('');
        include("includes/functions/functions.php");
        include("includes/templates/header.php");
        include("includes/templates/navbar.php");



        
        include("includes/templates/footer.php");
    }else{
        $errMsg = lang('NOTALLOWED');
        redir('index.php',4);
    }
    ob_end_flush();
?>