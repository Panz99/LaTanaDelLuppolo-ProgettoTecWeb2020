<?php
    require_once 'dbConnection.php';
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

    try {
        $querySelect = "SELECT * FROM birre ORDER BY costo asc LIMIT 3";
        $offerte = DBAccess::query($querySelect);
    } catch (Exception $e) {
        //Andrebbe lanciata una pagina con gli errori
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
    $path=[
        "Home" => "active",
    ];
    //Costruisco pagina
    $paginaHTML = file_get_contents('../html/home.html');
    $paginaHTML = str_replace("<head/>", htmlMaker::makeHead("Home - La tana del Luppolo"), $paginaHTML);
    $paginaHTML = str_replace("<keywords/>", ", homepage", $paginaHTML); 
    $paginaHTML = str_replace("<header/>", htmlMaker::makeHeader($username), $paginaHTML);
    $paginaHTML = str_replace("<heading/>", htmlMaker::makeHeading("La nostra vetrina"),$paginaHTML);
    $paginaHTML = str_replace('<a class="link fillParent" href="<root/>php/home.php" xml:lang="en" lang="en">', '<a class="active" xml:lang="en" lang="en" role="presentation">', $paginaHTML);
    $paginaHTML = str_replace("<bc/>", htmlMaker::makeBreadCrumbs($path), $paginaHTML);
    $paginaHTML = str_replace("<sales/>", htmlMaker::listBeers($offerte), $paginaHTML);
    $paginaHTML = str_replace("<tornasu/>", htmlMaker::makeTornaSu(), $paginaHTML);
    $paginaHTML = str_replace("<footer/>", htmlMaker::makeFooter(), $paginaHTML);
    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);

    echo $paginaHTML;
?>