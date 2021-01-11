<?php
    require_once 'htmlMaker.php';
    session_start();
    //controllo se minorenne
    if(!isset($_SESSION['adult']) || !$_SESSION['adult'])
        header('Location: ageverification.php');

    //controllo se loggato
    $username = "";
    if(isset($_SESSION['id'])){
        $username = $_SESSION['id'];
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
    $paginaHTML = str_replace("<bc/>", htmlMaker::makeBreadCrumbs($path), $paginaHTML);
    $paginaHTML = str_replace("<heading/>", htmlMaker::makeHeading("La nostra azienda"), $paginaHTML);
    $paginaHTML = str_replace("<header/>", htmlMaker::makeHeader($username), $paginaHTML);
    $paginaHTML = str_replace("<tornasu/>", htmlMaker::makeTornaSu(), $paginaHTML);
    $paginaHTML = str_replace("<footer/>", htmlMaker::makeFooter(), $paginaHTML);
    $paginaHTML = str_replace('<a class="link fillParent" href="<root/>php/contatti.php">', '<a class="active" role="presentation">', $paginaHTML);
    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);
    echo $paginaHTML;
    
?>