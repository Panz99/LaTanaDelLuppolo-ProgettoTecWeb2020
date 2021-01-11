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
    $start = 0;
    $page = 1;
    if(isset($_GET['page'])){
        $start=($_GET['page']-1)*8;
        $page = $_GET['page'];
    }
    $term="";
    $heading="Le nostre birre";
    if(isset($_GET['search'])){
         $term = filter_var($_GET['search'], FILTER_SANITIZE_STRING);
         $heading = "Risultati per: \"$term\"";
    }

    try {
        $querySelect = ($term) ? "SELECT COUNT(*) FROM birre WHERE lower(nome) LIKE '%".strtolower($term)."%' OR lower(tipo) LIKE '%".strtolower($term)."%'" : "SELECT COUNT(*) FROM birre";
        $result = DBAccess::query($querySelect, true);
        $querySelect = ($term) ? "SELECT * FROM birre WHERE lower(nome) LIKE '%".strtolower($term)."%' OR lower(tipo) LIKE '%".strtolower($term)."%' LIMIT $start, 8" : "SELECT * FROM birre LIMIT $start, 8";
        $listaBirre = DBAccess::query($querySelect);
        if(!$listaBirre)
            throw new Exception("Nessun prodotto trovato");
    } catch (Exception $e) {
        header('Location: notfound.php');
    }

    //Breadcrumbs
    $path=[
        "Home" => "<root/>php/home.php",
        "Prodotti" => "active",
    ];
    //Costruisco pagina
    $paginaHTML = file_get_contents('../html/prodotti.html');
    $paginaHTML = str_replace("<head/>", htmlMaker::makeHead("Prodotti - La tana del Luppolo"), $paginaHTML);
    $paginaHTML = str_replace("<keywords/>", "", $paginaHTML); 
    $paginaHTML = str_replace("<heading/>", htmlMaker::makeHeading($heading), $paginaHTML);
    $paginaHTML = str_replace("<pages/>", htmlMaker::listPages($result[0], $page), $paginaHTML);
    $paginaHTML = str_replace("<listBeers/>", htmlMaker::listBeers($listaBirre), $paginaHTML);
    $paginaHTML = str_replace("<bc/>", htmlMaker::makeBreadCrumbs($path), $paginaHTML);
    $paginaHTML = str_replace("<header/>", htmlMaker::makeHeader($username), $paginaHTML);
    $paginaHTML = str_replace("<footer/>", htmlMaker::makeFooter(), $paginaHTML);
    $paginaHTML = str_replace("<tornasu/>", htmlMaker::makeTornaSu(), $paginaHTML);
    if(!isset($_GET['search'])) {$paginaHTML = str_replace('<a class="link fillParent" href="<root/>php/prodotti.php?page=1">', '<a class="active" role="presentation">', $paginaHTML);}
    $paginaHTML = str_replace('<a href="prodotti.php?page='.$page.'" class="link page-padding fillParent">', '<a class="page-padding active fillParent" role="presentation">', $paginaHTML);

    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);
    echo $paginaHTML;
?>