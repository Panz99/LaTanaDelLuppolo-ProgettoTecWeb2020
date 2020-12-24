<?php
    require_once 'dbConnection.php';
    require_once 'htmlMaker.php';
    session_start();
    //controllo se minorenne
    if(!isset($_SESSION['adult']) || !$_SESSION['adult'])
        header('Location: ageverification.php');

    //controllo se loggato
    if(isset($_SESSION['id'])){
        //cambia chiamata icon account
    }

    $idbirra = $_GET["id"];



    //preleva info da database
    try{
        if(!$idbirra)
            throw new Exception("No id value found");

        $query = "SELECT * FROM birre WHERE id=".$idbirra;
        $birra = DBAccess::query($query)[0];

        $query = 'SELECT * FROM recensioni, utenti WHERE recensioni.birra='.$idbirra.' AND recensioni.utente=utenti.id';
        $recensioni = DBAccess::query($query);
    } catch (Exception $e) {
        //Andrebbe lanciata una pagina con gli errori
        header('Location: notfound.php');
    }

    //Costruisco pagina
    $paginaHTML = file_get_contents('../html/dettagli.html');
    $paginaHTML = str_replace("<head/>", htmlMaker::makeHead($birra["nome"]." - La tana del Luppolo"), $paginaHTML);
    $paginaHTML = str_replace("<keywords/>", ", ".$birra["nome"], $paginaHTML); 
    $paginaHTML = str_replace("<header/>", htmlMaker::makeHeader(), $paginaHTML);
    $paginaHTML = str_replace("<tornasu/>", htmlMaker::makeTornaSu(), $paginaHTML);
    $paginaHTML = str_replace("<footer/>", htmlMaker::makeFooter(), $paginaHTML);
    $paginaHTML = str_replace("<beerinfo/>", htmlMaker::beerInfo($birra), $paginaHTML);
    if(strpos($paginaHTML, "<reviews/>")!==false && $recensioni!==null)
        $paginaHTML = str_replace("<reviews/>", htmlMaker::beerReview($recensioni), $paginaHTML);
    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);
    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);
    echo $paginaHTML;


?>