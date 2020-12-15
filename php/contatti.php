<?php
    session_start();
    //controllo se minorenne
    if(!isset($_SESSION['adult']) || !$_SESSION['adult'])
        header('Location: ageverification.php');

    //controllo se loggato
    if(isset($_SESSION['id'])){
        //cambia chiamata icon account
    }

    //Costruisco pagina
    echo file_get_contents('../html/contatti.html');
?>