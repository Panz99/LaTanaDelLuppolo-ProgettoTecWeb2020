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

    $idbirra = $_GET["id"];

    /* PROVA imposta utente come ADMIN se = 1*/
    $_SESSION['admin']=1;


    //preleva info da database
    try{
        if(!$idbirra)
            throw new Exception("No id value found");

        $query = "SELECT * FROM birre WHERE id=".$idbirra;
        $birra = DBAccess::query($query)[0];
        //mostra pagina notfound se id non esiste
        if(empty($birra))
            throw new Exception("No id value found");

        $query = 'SELECT recensioni.id AS revid, recensioni.descrizione, recensioni.voto, utenti.username FROM recensioni, utenti WHERE recensioni.birra='.$idbirra.' AND recensioni.utente=utenti.id ';
        $recensioni = DBAccess::query($query);
        print_r($recensioni);
    } catch (Exception $e) {
        //Andrebbe lanciata una pagina con gli errori
        header('Location: notfound.php');
    }
    //breadcrumbs
    $path=[
        "Home" => "<root/>php/home.php",
        "Prodotti" => "<root/>php/prodotti.php",
        $birra["nome"] => "active",
    ];

    //Costruisco pagina
    $paginaHTML = file_get_contents('../html/dettagli.html');
    $paginaHTML = str_replace("<head/>", htmlMaker::makeHead($birra["nome"]." - La tana del Luppolo"), $paginaHTML);
    $paginaHTML = str_replace("<keywords/>", ", ".$birra["nome"], $paginaHTML); 
    $paginaHTML = str_replace("<bc/>", htmlMaker::makeBreadCrumbs($path), $paginaHTML);
    $paginaHTML = str_replace("<header/>", htmlMaker::makeHeader($username), $paginaHTML);
    $paginaHTML = str_replace("<tornasu/>", htmlMaker::makeTornaSu(), $paginaHTML);
    $paginaHTML = str_replace("<footer/>", htmlMaker::makeFooter(), $paginaHTML);
    $paginaHTML = str_replace("<beerinfo/>", htmlMaker::beerInfo($birra), $paginaHTML);
    if(strpos($paginaHTML, "<reviews/>")!==false && $recensioni!==null)
    {
        $paginaHTML = str_replace("<reviews/>", htmlMaker::beerReview($recensioni), $paginaHTML);
        
        if(strpos($paginaHTML, "<beerid/>")!==false)
            $paginaHTML = str_replace("<beerid/>", $idbirra, $paginaHTML);
    }
    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);
    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);
    echo $paginaHTML;


?>