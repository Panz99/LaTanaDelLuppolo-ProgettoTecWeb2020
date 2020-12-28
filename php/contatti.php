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
    //Breadcrumbs
    $path=[
        "Home" => "<root/>php/home.php",
        "Contatti" => "active",
    ];
    //Costruisco pagina
    $paginaHTML = file_get_contents('../html/contatti.html');
    $paginaHTML = str_replace("<head/>", htmlMaker::makeHead("Contatti - La tana del Luppolo"), $paginaHTML);
    $paginaHTML = str_replace("<keywords/>", ", contatti, email, telefono", $paginaHTML); 
    $paginaHTML = str_replace("<header/>", htmlMaker::makeHeader(), $paginaHTML);
    $paginaHTML = str_replace("<bc/>", htmlMaker::makeBreadCrumbs($path), $paginaHTML);
    $paginaHTML = str_replace("<tornasu/>", htmlMaker::makeTornaSu(), $paginaHTML);
    $paginaHTML = str_replace("<footer/>", htmlMaker::makeFooter(), $paginaHTML);
    $paginaHTML = str_replace('<a class="link fillParent" href="<root/>php/contatti.php">', '<a class="active">', $paginaHTML);
    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);
    echo $paginaHTML;
    
?>