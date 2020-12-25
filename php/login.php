<?php
    require_once 'htmlMaker.php';
    session_start();
    $paginaHTML = file_get_contents('../html/login.html');
    //controllo se minorenne
    if(!isset($_SESSION['adult']) || !$_SESSION['adult']){
        header('Location: ageverification.php');
    }
    //quando si è sbagliato di inserire le credenziali giusti
    if(isset($_SESSION['id']) && !isset($_SESSION['login'])) {
        unset($_SESSION['id']);
        $paginaHTML=str_replace("<p id='loginerror'>","<p id='loginerror'>Le credenziali inserite non sono corrette</p>",$paginaHTML);
    }
    //controllo se loggato
    if(isset($_SESSION['login']) && $_SESSION['login']){
        header('Location: dettagliprofilo.php');
    }
    //Costruisco pagina
    $paginaHTML = file_get_contents('../html/login.html');
    $paginaHTML = str_replace("<head/>", htmlMaker::makeHead("Accedi - La tana del Luppolo"), $paginaHTML);
    $paginaHTML = str_replace("<keywords/>", ", account", $paginaHTML); 
    $paginaHTML = str_replace("<header/>", htmlMaker::makeHeader(), $paginaHTML);
    $paginaHTML = str_replace("<tornasu/>", htmlMaker::makeTornaSu(), $paginaHTML);
    $paginaHTML = str_replace("<footer/>", htmlMaker::makeFooter(), $paginaHTML);
    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);
    echo $paginaHTML;
?>