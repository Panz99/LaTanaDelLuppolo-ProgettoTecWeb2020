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
    $paginaHTML = file_get_contents('../html/home.html');
    $paginaHTML = str_replace("<head/>", htmlMaker::makeHead("Locker - La tana del Luppolo"), $paginaHTML);
    $paginaHTML = str_replace("<header/>", htmlMaker::makeHeader(), $paginaHTML);
    $paginaHTML = str_replace('<a class="link" href="<root/>php/home.php">', '<a class="active">', $paginaHTML);
    $paginaHTML = str_replace("<footer/>", htmlMaker::make_footer(),$paginaHTML);
    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);

    echo $paginaHTML;
?>