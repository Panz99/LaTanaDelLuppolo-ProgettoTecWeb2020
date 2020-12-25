<?php
    require_once 'htmlMaker.php';
    session_start();
    //controllo se minorenne
    if(!isset($_SESSION['adult']) || !$_SESSION['adult']){
      header('Location: ageverification.php');
    }
   
    //controllo se loggato
    if(isset($_SESSION['login'])){
      
    //Costruisco pagina
    $paginaHTML = file_get_contents('../html/account.html');
    $paginaHTML = str_replace("<head/>", htmlMaker::makeHead("Profilo - La tana del Luppolo"), $paginaHTML);
    $paginaHTML = str_replace("<keywords/>", ", account", $paginaHTML); 
    $paginaHTML = str_replace("<header/>", htmlMaker::makeHeader(), $paginaHTML);
    $paginaHTML = str_replace("<footer/>", htmlMaker::makeFooter(), $paginaHTML);
    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);
    $paginaHTML = str_replace("£userid£",$_SESSION['id'],$paginaHTML);
    $paginaHTML = str_replace("£name£",$_SESSION['nome'],$paginaHTML);
    $paginaHTML = str_replace("£surname£",$_SESSION['cogn'],$paginaHTML);
    $paginaHTML = str_replace("£data£",$_SESSION['bdate'],$paginaHTML);
    echo $paginaHTML;
    }
?>