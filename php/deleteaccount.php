<?php
require_once 'htmlMaker.php';
session_start();
//controllo se minorenne
if(!isset($_SESSION['adult']) || !$_SESSION['adult'])
    header('Location: ageverification.php');

//controllo se loggato
if(!isset($_SESSION['account_deleted'])){
    header('Location: accessdenied.php');
}
unset($_SESSION['account_deleted']);
//Costruisco pagina
$paginaHTML = file_get_contents('../html/deleteaccount.html');
$paginaHTML = str_replace("<head/>", htmlMaker::makeHead("Account eliminato - La tana del Luppolo"), $paginaHTML);
$paginaHTML = str_replace("<keywords/>", "", $paginaHTML); 
$paginaHTML = str_replace("<header/>", htmlMaker::makeHeader(""), $paginaHTML);
$paginaHTML = str_replace("<footer/>", htmlMaker::makeFooter(), $paginaHTML);
$paginaHTML = str_replace("<content/>", htmlMaker::makeDeleteAccount(), $paginaHTML);
$paginaHTML = str_replace("<root/>", "../", $paginaHTML);
echo $paginaHTML;
?>