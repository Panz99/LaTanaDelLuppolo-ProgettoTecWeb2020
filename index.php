<?php
    session_start();
    if(isset($_SESSION['adult']) && $_SESSION['adult']){
        header('Location: php/home.php');
    }
    else{
        header('Location: php/ageverification.php');
    }
    die();
?>