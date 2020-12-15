<?php
    require_once 'htmlMaker.php';
    session_start();
    //controllo se minorenne
    if(!isset($_SESSION['adult']) || !$_SESSION['adult'])
        header('Location: ageverification.php');

    //controllo se loggato
    if(isset($_SESSION['id'])){
        echo file_get_content('..html/dettagliaccount.html');
    }
    //Costruisco pagina
    $paginaHTML = file_get_contents('../html/login.html');
    $paginaHTML = str_replace("<head/>", htmlMaker::makeHead("Accedi - La tana del Luppolo"), $paginaHTML);
    $paginaHTML = str_replace("<header/>", htmlMaker::makeHeader(), $paginaHTML);
    $paginaHTML = str_replace("<footer/>", htmlMaker::makeFooter(), $paginaHTML);
    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);
    echo $paginaHTML;
?>