<?php
    require_once 'htmlMaker.php';
    session_start();
    //controllo se minorenne
    if(!isset($_SESSION['adult']) || !$_SESSION['adult'])
        header('Location: ageverification.php');

    //controllo se loggato
    if(isset($_SESSION['id'])){
        //cambia chiamata icon account
    }

    //Costruisco pagina
    $paginaHTML = file_get_contents('../html/contatti.html');
    $paginaHTML = str_replace("<head/>", htmlMaker::makeHead("Contatti - La tana del Luppolo"), $paginaHTML);
    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);
    echo $paginaHTML;
    
?>