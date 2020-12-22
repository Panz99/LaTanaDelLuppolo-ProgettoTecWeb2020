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
    $start = 0;
    $page = 1;
    if(isset($_GET['page'])){
        $start=($_GET['page']-1)*8;
        $page = $_GET['page'];
    }
    $term="";
    if(isset($_GET['search'])){
        $term = $_GET['search'];
    }

    try {
        $querySelect = ($term) ? "SELECT COUNT(*) FROM birre WHERE nome like '$term'" : "SELECT COUNT(*) FROM birre";
        $result = DBAccess::query($querySelect, true);
        $querySelect = ($term) ? "SELECT * FROM birre WHERE nome like '$term' LIMIT $start, 8" : "SELECT * FROM birre LIMIT $start, 8";
        $listaBirre = DBAccess::query($querySelect);
    } catch (Exception $e) {
        //Andrebbe lanciata una pagina con gli errori
        header('Location: notfound.php');
    }

    //Costruisco pagina
    $paginaHTML = file_get_contents('../html/prodotti.html');
    $paginaHTML = str_replace("<head/>", htmlMaker::makeHead("Prodotti - La tana del Luppolo"), $paginaHTML);
    $paginaHTML = str_replace("<keywords/>", "", $paginaHTML); 
    $paginaHTML = str_replace("<pages/>", htmlMaker::listPages($result[0], $page), $paginaHTML);
    $paginaHTML = str_replace("<listBeers/>", htmlMaker::listBeers($listaBirre), $paginaHTML);
    $paginaHTML = str_replace("<header/>", htmlMaker::makeHeader(), $paginaHTML);
    $paginaHTML = str_replace("<footer/>", htmlMaker::makeFooter(), $paginaHTML);
    $paginaHTML = str_replace('<a class="link" href="<root/>php/prodotti.php?page=1">', '<a class="active">', $paginaHTML);
    $paginaHTML = str_replace('<a href="prodotti.php?page='.$page.'" class="link page-padding">', '<a class="link page-padding active">', $paginaHTML);

    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);
    echo $paginaHTML;
?>