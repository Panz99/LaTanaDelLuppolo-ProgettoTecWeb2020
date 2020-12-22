<?php
    require_once 'htmlMaker.php';

    //Costruisco pagina
    $paginaHTML = file_get_contents('../html/notfound.html');
    $paginaHTML = str_replace("<head/>", htmlMaker::makeHead("Errore - La tana del Luppolo"), $paginaHTML);
    $paginaHTML = str_replace("<keywords/>", "", $paginaHTML); 
    $paginaHTML = str_replace("<header/>", htmlMaker::makeHeader(), $paginaHTML);
    $paginaHTML = str_replace("<footer/>", htmlMaker::makeFooter(), $paginaHTML);
    $paginaHTML = str_replace("<error/>", htmlMaker::makeNotfound(), $paginaHTML);
    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);
    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);
    echo $paginaHTML;


?>