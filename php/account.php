<?php
    session_start();
    //controllo se minorenne
    if(!isset($_SESSION['adult']) || !$_SESSION['adult'])
        header('Location: ageverification.php');

    //controllo se loggato
    if(isset($_SESSION['id'])){
        echo file_get_content('..html/dettagliaccount.html');
    }
    //Costruisco pagina
    echo file_get_contents('../html/login.html');
?>